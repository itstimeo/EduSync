<?php

namespace EduSync\Controllers;

use EduSync\Core\Session;
use EduSync\Core\View;
use EduSync\Models\Grade;
use EduSync\Models\Event;
use EduSync\Models\RevisionSession;

class DashboardController
{
    public function show(): void
    {
        if (!Session::has('user_id')) {
            Session::redirect('/login');
        }

        $userId = (int) Session::get('user_id');

        $grades    = Grade::getRecentByUser($userId);
        $average   = Grade::getWeightedAverage($userId);
        $events    = Event::getWeekByUser($userId);
        $revisions = RevisionSession::getTodayByUser($userId);

        View::render('dashboard/index', [
            'flash'     => Session::getFlash(),
            'title'     => 'Dashboard',
            'userName'  => Session::get('user_name', ''),
            'grades'    => $grades,
            'average'   => $average,
            'events'    => $events,
            'revisions' => $revisions,
        ], 'layouts/app');
    }
}
