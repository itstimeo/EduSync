<?php

namespace EduSync\Controllers;

use EduSync\Core\Session;
use EduSync\Core\View;
use EduSync\Models\Event;
use EduSync\Models\EventTypeColor;
use EduSync\Services\GoogleCalendarService;

class EventsController
{
    public function showPlanning(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        $month = trim($_GET['month'] ?? '');
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = date('Y-m');
        }
        $firstDay = $month . '-01';
        $lastDay  = date('Y-m-t', strtotime($firstDay));

        $monthEvents = Event::getByMonth($userId, $firstDay, $lastDay);

        // Build dayMap — substr(0,10) normalises DATETIME columns to YYYY-MM-DD
        $dayMap = [];
        foreach ($monthEvents as $e) {
            $sd     = substr($e['start_date'], 0, 10);
            $edRaw  = (isset($e['end_date']) && $e['end_date'] && $e['end_date'] !== '0000-00-00')
                ? $e['end_date'] : $e['start_date'];
            $ed     = substr($edRaw, 0, 10);
            $eStart = max($sd, $firstDay);
            $eEnd   = min($ed, $lastDay);
            if ($eStart > $eEnd) continue;
            $cur = $eStart;
            while ($cur <= $eEnd) {
                $dayMap[$cur][] = $e;
                $cur = date('Y-m-d', strtotime($cur . ' +1 day'));
            }
        }

        View::render('planning/index', [
            'title'      => __('nav.planning'),
            'flash'      => Session::getFlash(),
            'userName'   => Session::get('user_name', ''),
            'month'      => $month,
            'firstDay'   => $firstDay,
            'lastDay'    => $lastDay,
            'events'     => $monthEvents,
            'dayMap'     => $dayMap,
            'upcoming'   => Event::getUpcoming($userId),
            'typeColors' => EventTypeColor::getByUser($userId),
        ], 'layouts/app');
    }

    public function showCreateEvent(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        $date = trim($_GET['date'] ?? '');
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $date = '';
        }

        View::render('planning/event_form', [
            'title'       => __('planning.new_event_title'),
            'flash'       => Session::getFlash(),
            'userName'    => Session::get('user_name', ''),
            'event'       => null,
            'prefillDate' => $date,
            'typeColors'  => EventTypeColor::getByUser($userId),
        ], 'layouts/app');
    }

    public function createEvent(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        [$title, $type, $color, $startDate, $endDate, $description, $error] = $this->parseForm();
        if ($error) {
            Session::flash('error', $error);
            Session::redirect('/planning/create');
        }

        $id = Event::create($userId, $title, $type, $color, $startDate, $endDate, $description);
        try {
            if (GoogleCalendarService::isConnected($userId)) {
                $newEvent = Event::getByIdAndUser($id, $userId);
                if ($newEvent) {
                    $gcalId = GoogleCalendarService::pushEvent($userId, $newEvent);
                    if ($gcalId) Event::updateGcalId($id, $userId, $gcalId);
                }
            }
        } catch (\Throwable $e) {}
        Session::flash('success', __('planning.event_created'));
        Session::redirect('/planning');
    }

    public function showEditEvent(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_GET['id'] ?? 0);

        $event = Event::getByIdAndUser($id, $userId);
        if (!$event) {
            Session::redirect('/planning');
        }

        View::render('planning/event_form', [
            'title'       => __('planning.edit_event_title'),
            'flash'       => Session::getFlash(),
            'userName'    => Session::get('user_name', ''),
            'event'       => $event,
            'prefillDate' => '',
            'typeColors'  => EventTypeColor::getByUser($userId),
        ], 'layouts/app');
    }

    public function updateEvent(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);

        $event = Event::getByIdAndUser($id, $userId);
        if (!$event) {
            Session::redirect('/planning');
        }

        [$title, $type, $color, $startDate, $endDate, $description, $error] = $this->parseForm();
        if ($error) {
            Session::flash('error', $error);
            Session::redirect('/planning/edit?id=' . $id);
        }

        Event::update($id, $userId, $title, $type, $color, $startDate, $endDate, $description);
        try {
            if (GoogleCalendarService::isConnected($userId)) {
                $updated = Event::getByIdAndUser($id, $userId);
                if ($updated) {
                    $gcalId = GoogleCalendarService::pushEvent($userId, $updated);
                    if ($gcalId && !$event['gcal_event_id']) Event::updateGcalId($id, $userId, $gcalId);
                }
            }
        } catch (\Throwable $e) {}
        Session::flash('success', __('planning.event_updated'));
        Session::redirect('/planning');
    }

    public function deleteEvent(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);

        $event = Event::getByIdAndUser($id, $userId);
        if ($event) {
            try {
                if (!empty($event['gcal_event_id']) && GoogleCalendarService::isConnected($userId)) {
                    GoogleCalendarService::deleteEvent($userId, $event['gcal_event_id']);
                }
            } catch (\Throwable $e) {}
            Event::delete($id, $userId);
            Session::flash('success', __('planning.event_deleted'));
        }

        Session::redirect('/planning');
    }

    public function showSettings(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        View::render('planning/settings', [
            'title'     => __('nav.planning') . ' — ' . __('common.settings'),
            'flash'     => Session::getFlash(),
            'userName'  => Session::get('user_name', ''),
            'typeList'  => EventTypeColor::getAllByUser($userId),
        ], 'layouts/app');
    }

    public function saveSettings(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        // Handle delete
        $deleteId = (int) ($_POST['delete_type'] ?? 0);
        if ($deleteId > 0) {
            $typeRow = EventTypeColor::getById($deleteId, $userId);
            if ($typeRow) {
                Event::deleteByType($userId, $typeRow['type']);
                EventTypeColor::deleteById($deleteId, $userId);
            }
            Session::flash('success', __('planning.type_deleted'));
            Session::redirect('/planning/settings');
        }

        // Handle save all
        $typeList = EventTypeColor::getAllByUser($userId);
        foreach ($typeList as $row) {
            $id    = (int) $row['id'];
            $label = trim($_POST['label_' . $id] ?? '');
            $color = trim($_POST['color_' . $id] ?? '');
            if ($label !== '' && strlen($label) <= 100 && preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
                EventTypeColor::updateById($id, $userId, $label, $color);
                Event::updateColorByType($userId, $row['type'], $color);
            }
        }

        Session::flash('success', __('planning.settings_saved'));
        Session::redirect('/planning/settings');
    }

    public function addType(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        $label = trim($_POST['new_label'] ?? '');
        $color = trim($_POST['new_color'] ?? '#6366f1');

        if ($label === '' || strlen($label) > 50) {
            Session::flash('error', __('planning.type_name_error'));
            Session::redirect('/planning/settings');
        }
        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        $typeKey = substr(strtolower(preg_replace('/[^a-z0-9]+/i', '_', $label)), 0, 50);
        EventTypeColor::insert($userId, $typeKey, $label, $color);

        Session::flash('success', __('planning.type_added'));
        Session::redirect('/planning/settings');
    }

    // ================================================================
    // Helpers
    // ================================================================

    private function parseForm(): array
    {
        $title       = trim($_POST['title']       ?? '');
        $type        = trim($_POST['type']         ?? 'other');
        $color       = trim($_POST['color']        ?? '#6366f1');
        $startDate   = trim($_POST['start_date']   ?? '');
        $endDate     = trim($_POST['end_date']     ?? '') ?: null;
        $description = trim($_POST['description']  ?? '') ?: null;

        if ($type === '' || strlen($type) > 50) {
            $type = 'other';
        }
        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        $error = null;
        if ($title === '') {
            $error = __('planning.title_required');
        } elseif (strlen($title) > 200) {
            $error = __('planning.title_too_long');
        } elseif ($startDate === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate)) {
            $error = __('planning.start_date_required');
        } elseif ($endDate !== null && $endDate < $startDate) {
            $error = __('planning.end_date_invalid');
        }

        return [$title, $type, $color, $startDate, $endDate, $description, $error];
    }

    private function requireAuth(): void
    {
        if (!Session::has('user_id')) {
            Session::redirect('/login');
        }
    }

    private function userId(): int
    {
        return (int) Session::get('user_id');
    }
}
