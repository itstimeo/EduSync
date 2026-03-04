<?php

namespace EduSync\Controllers;

use EduSync\Core\Session;
use EduSync\Core\View;
use EduSync\Models\Grade;
use EduSync\Models\Subject;

class GradesController
{
    public function showGrades(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        View::render('grades/index', [
            'title'    => 'Grades',
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'grouped'  => Grade::getBySubjectGrouped($userId),
            'all'      => Grade::getAllByUser($userId),
            'average'  => Grade::getWeightedAverage($userId),
        ], 'layouts/app');
    }

    public function showCreateGrade(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        View::render('grades/grade_form', [
            'title'    => 'New grade',
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'grade'    => null,
            'subjects' => Subject::getAllByUser($userId),
        ], 'layouts/app');
    }

    public function createGrade(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        [$subjectId, $name, $value, $maxValue, $coefficient, $gradedAt, $comment, $error] = $this->parseForm();
        if ($error) {
            Session::flash('error', $error);
            Session::redirect('/grades/create');
        }

        $subject = Subject::getByIdAndUser($subjectId, $userId);
        if (!$subject) {
            Session::flash('error', 'Invalid subject.');
            Session::redirect('/grades/create');
        }

        Grade::create($userId, $subjectId, $name, $value, $maxValue, $coefficient, $gradedAt, $comment);
        Session::flash('success', 'Grade added.');
        Session::redirect('/grades');
    }

    public function showEditGrade(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_GET['id'] ?? 0);

        $grade = Grade::getByIdAndUser($id, $userId);
        if (!$grade) {
            Session::redirect('/grades');
        }

        View::render('grades/grade_form', [
            'title'    => 'Edit grade',
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'grade'    => $grade,
            'subjects' => Subject::getAllByUser($userId),
        ], 'layouts/app');
    }

    public function updateGrade(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);

        $grade = Grade::getByIdAndUser($id, $userId);
        if (!$grade) {
            Session::redirect('/grades');
        }

        [$subjectId, $name, $value, $maxValue, $coefficient, $gradedAt, $comment, $error] = $this->parseForm();
        if ($error) {
            Session::flash('error', $error);
            Session::redirect('/grades/edit?id=' . $id);
        }

        $subject = Subject::getByIdAndUser($subjectId, $userId);
        if (!$subject) {
            Session::flash('error', 'Invalid subject.');
            Session::redirect('/grades/edit?id=' . $id);
        }

        Grade::update($id, $userId, $subjectId, $name, $value, $maxValue, $coefficient, $gradedAt, $comment);
        Session::flash('success', 'Grade updated.');
        Session::redirect('/grades');
    }

    public function deleteGrade(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);

        $grade = Grade::getByIdAndUser($id, $userId);
        if ($grade) {
            Grade::delete($id, $userId);
            Session::flash('success', 'Grade deleted.');
        }

        Session::redirect('/grades');
    }

    // ================================================================
    // Helpers
    // ================================================================

    private function parseForm(): array
    {
        $subjectId   = (int)   ($_POST['subject_id']   ?? 0);
        $name        = trim(   $_POST['name']          ?? '');
        $value       = (float) ($_POST['value']        ?? 0);
        $maxValue    = (float) ($_POST['max_value']    ?? 20);
        $coefficient = (float) ($_POST['coefficient']  ?? 1);
        $gradedAt    = trim(   $_POST['graded_at']     ?? '') ?: null;
        $comment     = trim(   $_POST['comment']       ?? '') ?: null;

        $error = null;
        if ($name === '') {
            $error = 'Grade name is required.';
        } elseif (strlen($name) > 200) {
            $error = 'Grade name is too long (max 200 characters).';
        } elseif ($subjectId <= 0) {
            $error = 'Please select a subject.';
        } elseif ($value < 0) {
            $error = 'Grade value cannot be negative.';
        } elseif ($maxValue <= 0) {
            $error = 'Max value must be greater than 0.';
        } elseif ($value > $maxValue) {
            $error = 'Grade value cannot exceed max value.';
        } elseif ($coefficient <= 0) {
            $error = 'Coefficient must be greater than 0.';
        }

        return [$subjectId, $name, $value, $maxValue, $coefficient, $gradedAt, $comment, $error];
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
