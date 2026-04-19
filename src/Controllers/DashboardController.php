<?php

namespace EduSync\Controllers;

use EduSync\Core\Session;
use EduSync\Core\View;
use EduSync\Models\AcademicYear;
use EduSync\Models\Grade;
use EduSync\Models\Event;
use EduSync\Models\EventTypeColor;
use EduSync\Models\RevisionSession;

class DashboardController
{
    public function show(): void
    {
        if (!Session::has('user_id')) {
            Session::redirect('/login');
        }

        $userId = (int) Session::get('user_id');

        $year      = AcademicYear::getActiveForUser($userId);
        $yearId    = $year ? (int)$year['id'] : null;
        $grades    = Grade::getRecentByUser($userId, 5, $yearId);
        $average   = Grade::getWeightedAverage($userId, $yearId);
        $events    = Event::getWeekByUser($userId);
        $revisions = RevisionSession::getTodayByUser($userId);

        View::render('dashboard/index', [
            'flash'      => Session::getFlash(),
            'title'      => __('dashboard.title'),
            'userName'   => Session::get('user_name', ''),
            'grades'     => $grades,
            'average'    => $average,
            'events'     => $events,
            'typeColors' => EventTypeColor::getByUser($userId),
            'revisions'  => $revisions,
            'activeYear' => $year,
        ], 'layouts/app');
    }
}
