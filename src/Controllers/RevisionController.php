<?php

namespace EduSync\Controllers;

use EduSync\Core\Session;
use EduSync\Core\View;
use EduSync\Models\RevisionSession;
use EduSync\Models\RevisionPreset;

class RevisionController
{
    // ================================================================
    // Main page
    // ================================================================

    public function show(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        $due      = RevisionSession::getTodayByUser($userId);
        $upcoming = RevisionSession::getUpcomingByUser($userId);

        // Build sessions map for JS edit panel (id => session data)
        $sessionsMap = [];
        foreach (array_merge($due, $upcoming) as $s) {
            $sessionsMap[(int)$s['id']] = [
                'id'         => (int)$s['id'],
                'start_date' => $s['start_date'] ?? date('Y-m-d'),
                'intervals'  => json_decode($s['intervals'] ?? '[]', true) ?: [],
            ];
        }

        View::render('revision/index', [
            'title'       => __('nav.revision'),
            'flash'       => Session::getFlash(),
            'userName'    => Session::get('user_name', ''),
            'due'         => $due,
            'upcoming'    => $upcoming,
            'presets'     => RevisionPreset::getByUser($userId),
            'default'     => RevisionPreset::getDefault($userId),
            'chapters'    => RevisionSession::getAvailableChapters($userId),
            'documents'   => RevisionSession::getAvailableDocuments($userId),
            'sessionsMap' => $sessionsMap,
        ], 'layouts/app');
    }

    // ================================================================
    // Session CRUD
    // ================================================================

    public function addItem(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        $startDate = trim($_POST['start_date'] ?? '');
        if ($startDate !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate)) {
            $startDate = '';
        }

        $itemType  = trim($_POST['item_type'] ?? '');
        $itemId    = (int) ($_POST['item_id'] ?? 0);
        $mode      = trim($_POST['interval_mode'] ?? 'default');
        $presetId  = (int) ($_POST['preset_id'] ?? 0);
        $customRaw = trim($_POST['custom_intervals'] ?? '');

        if (!in_array($itemType, ['chapter', 'document'], true) || $itemId <= 0) {
            Session::flash('error', __('revision.invalid_item'));
            Session::redirect('/revision');
        }

        $intervals = $this->resolveIntervals($mode, $presetId, $customRaw, $userId);
        if ($intervals === null) {
            Session::flash('error', __('revision.invalid_intervals'));
            Session::redirect('/revision');
        }

        try {
            RevisionSession::create($userId, $itemType, $itemId, $intervals, $startDate);
            Session::flash('success', __('revision.item_added'));
        } catch (\PDOException $e) {
            $mysqlErrno = $e->errorInfo[1] ?? 0;
            if ($e->getCode() === '23000' && $mysqlErrno == 1062) {
                Session::flash('error', __('revision.already_tracked'));
            } else {
                Session::flash('error', 'DB error [' . $e->getCode() . '/' . $mysqlErrno . ']: ' . $e->getMessage());
            }
        }

        Session::redirect('/revision');
    }

    public function markDone(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);
        $from   = trim($_POST['from'] ?? '');

        RevisionSession::markDone($id, $userId);
        Session::redirect($from === 'dashboard' ? '/dashboard' : '/revision');
    }

    public function deleteItem(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);

        RevisionSession::delete($id, $userId);
        Session::flash('success', __('revision.session_removed'));
        Session::redirect('/revision');
    }

    public function toggleReview(): void
    {
        $this->requireAuth();
        $id   = (int) ($_POST['id'] ?? 0);
        $from = trim($_POST['from'] ?? '');
        RevisionSession::toggle($id, $this->userId());
        Session::redirect($from === 'dashboard' ? '/dashboard' : '/revision');
    }

    public function editSession(): void
    {
        $this->requireAuth();
        $userId   = $this->userId();
        $id       = (int) ($_POST['id'] ?? 0);
        $startDate = trim($_POST['start_date'] ?? '');
        $mode      = trim($_POST['interval_mode'] ?? 'steps');
        $presetId  = (int) ($_POST['preset_id'] ?? 0);
        $rawSteps  = $_POST['steps'] ?? [];

        if ($id <= 0) {
            Session::redirect('/revision');
        }

        if ($startDate === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate)) {
            Session::flash('error', __('revision.invalid_date'));
            Session::redirect('/revision');
        }

        if ($mode === 'preset' && $presetId > 0) {
            $preset = RevisionPreset::getById($presetId, $userId);
            if (!$preset) {
                Session::flash('error', __('revision.preset_not_found'));
                Session::redirect('/revision');
            }
            $intervals = json_decode($preset['intervals'], true) ?: null;
        } else {
            $intervals = RevisionPreset::parseSteps(is_array($rawSteps) ? $rawSteps : []);
        }

        if ($intervals === null || count($intervals) === 0) {
            Session::flash('error', __('revision.invalid_steps'));
            Session::redirect('/revision');
        }

        RevisionSession::editSession($id, $userId, $startDate, $intervals);
        Session::flash('success', __('revision.session_updated'));
        Session::redirect('/revision');
    }

    // ================================================================
    // Settings (presets)
    // ================================================================

    public function showSettings(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        View::render('revision/settings', [
            'title'    => __('revision_settings.title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'presets'  => RevisionPreset::getByUser($userId),
        ], 'layouts/app');
    }

    public function savePreset(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        $presetId = (int) ($_POST['preset_id'] ?? 0);
        $name     = trim($_POST['name'] ?? '');
        $rawSteps = $_POST['steps'] ?? [];

        if ($name === '') {
            Session::flash('error', __('revision_settings.name_required'));
            Session::redirect('/revision/settings');
        }
        if (strlen($name) > 100) {
            Session::flash('error', __('revision_settings.name_too_long'));
            Session::redirect('/revision/settings');
        }

        $intervals = RevisionPreset::parseSteps(is_array($rawSteps) ? $rawSteps : []);
        if ($intervals === null || count($intervals) === 0) {
            Session::flash('error', __('revision_settings.min_step'));
            Session::redirect('/revision/settings');
        }

        try {
            if ($presetId > 0) {
                $existing = RevisionPreset::getById($presetId, $userId);
                if ($existing) {
                    RevisionPreset::update($presetId, $userId, $name, $intervals);
                    Session::flash('success', __('revision_settings.preset_updated'));
                }
            } else {
                RevisionPreset::create($userId, $name, $intervals);
                Session::flash('success', __('revision_settings.preset_created'));
            }
        } catch (\PDOException $e) {
            Session::flash('error', __('revision_settings.name_duplicate'));
        }

        Session::redirect('/revision/settings');
    }

    public function deletePreset(): void
    {
        $this->requireAuth();
        $userId   = $this->userId();
        $presetId = (int) ($_POST['preset_id'] ?? 0);

        RevisionPreset::delete($presetId, $userId);
        Session::flash('success', __('revision_settings.preset_deleted'));
        Session::redirect('/revision/settings');
    }

    public function setDefaultPreset(): void
    {
        $this->requireAuth();
        $userId   = $this->userId();
        $presetId = (int) ($_POST['preset_id'] ?? 0);

        $preset = RevisionPreset::getById($presetId, $userId);
        if ($preset) {
            RevisionPreset::setDefault($presetId, $userId);
        }

        Session::redirect('/revision/settings');
    }

    public function unsetDefaultPreset(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        RevisionPreset::unsetDefault($userId);
        Session::redirect('/revision/settings');
    }

    // ================================================================
    // Helpers
    // ================================================================

    private function resolveIntervals(string $mode, int $presetId, string $customRaw, int $userId): ?array
    {
        if ($mode === 'preset' && $presetId > 0) {
            $preset = RevisionPreset::getById($presetId, $userId);
            if (!$preset) {
                return null;
            }
            return json_decode($preset['intervals'], true) ?: null;
        }

        if ($mode === 'custom') {
            return RevisionPreset::parseIntervals($customRaw);
        }

        // Default: use user's default preset, or built-in [1,3,7,14,30]
        $default = RevisionPreset::getDefault($userId);
        if ($default) {
            return json_decode($default['intervals'], true) ?: null;
        }

        return [
            ['day' => 1,  'action' => ''],
            ['day' => 3,  'action' => ''],
            ['day' => 7,  'action' => ''],
            ['day' => 14, 'action' => ''],
            ['day' => 30, 'action' => ''],
        ];
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
