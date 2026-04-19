<?php

namespace EduSync\Controllers;

use EduSync\Core\Session;
use EduSync\Core\View;
use EduSync\Models\AcademicYear;
use EduSync\Models\Grade;
use EduSync\Models\Subject;

class GradesController
{
    public function showGrades(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $year   = $this->requireYear($userId);
        $yearId = (int)$year['id'];

        View::render('grades/index', [
            'title'      => __('nav.grades'),
            'flash'      => Session::getFlash(),
            'userName'   => Session::get('user_name', ''),
            'grouped'    => Grade::getBySubjectGrouped($userId, $yearId),
            'all'        => Grade::getAllByUser($userId, $yearId),
            'average'    => Grade::getWeightedAverage($userId, $yearId),
            'activeYear' => $year,
        ], 'layouts/app');
    }

    public function showCreateGrade(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $year   = $this->requireYear($userId);

        View::render('grades/grade_form', [
            'title'    => __('grades.new_title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'grade'    => null,
            'subjects' => Subject::getAllByUserAndYear($userId, (int)$year['id']),
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
            Session::flash('error', __('grades.invalid_subject'));
            Session::redirect('/grades/create');
        }

        Grade::create($userId, $subjectId, $name, $value, $maxValue, $coefficient, $gradedAt, $comment);
        Session::flash('success', __('grades.grade_added'));
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

        $year = $this->requireYear($userId);
        View::render('grades/grade_form', [
            'title'    => __('grades.edit_title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'grade'    => $grade,
            'subjects' => Subject::getAllByUserAndYear($userId, (int)$year['id']),
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
            Session::flash('error', __('grades.invalid_subject'));
            Session::redirect('/grades/edit?id=' . $id);
        }

        Grade::update($id, $userId, $subjectId, $name, $value, $maxValue, $coefficient, $gradedAt, $comment);
        Session::flash('success', __('grades.grade_updated'));
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
            Session::flash('success', __('grades.grade_deleted'));
        }

        Session::redirect('/grades');
    }

    public function exportGrades(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        $year    = $this->requireYear($userId);
        $yearId  = (int)$year['id'];
        $grouped = Grade::getBySubjectGrouped($userId, $yearId);
        $average = Grade::getWeightedAverage($userId, $yearId);

        if (empty($grouped)) {
            Session::flash('error', __('courses.no_grades_export'));
            Session::redirect('/grades');
        }

        $date       = date('d/m/Y');
        $avgDisplay = $average !== null ? number_format($average, 2) . '/20' : '—';

        $tableRows = '';
        foreach ($grouped as $group) {
            $color    = htmlspecialchars($group['subject_color'], ENT_QUOTES);
            $subjName = htmlspecialchars($group['subject_name'], ENT_QUOTES);
            $subjAvg  = $group['average'] !== null ? number_format($group['average'], 2) . '/20' : '—';

            $tableRows .= '<tr style="background:#f5f5f7">'
                . '<td colspan="4" style="padding:6px 10px 6px 14px;border-left:4px solid ' . $color . ';font-weight:700;font-size:10pt;border-bottom:1px solid #e5e5e5">' . $subjName . '</td>'
                . '<td style="padding:6px 10px;text-align:right;color:#6366f1;font-weight:600;font-size:9pt;border-bottom:1px solid #e5e5e5">' . $subjAvg . '</td>'
                . '</tr>';

            foreach ($group['grades'] as $g) {
                $norm    = number_format((float) $g['value'] / (float) $g['max_value'] * 20, 2);
                $dateStr = $g['graded_at'] ? date('d/m/Y', strtotime($g['graded_at'])) : '';

                $tableRows .= '<tr>'
                    . '<td style="padding:5px 10px;border-bottom:1px solid #f0f0f0;font-size:9pt;font-weight:500">' . htmlspecialchars($g['name'], ENT_QUOTES) . '</td>'
                    . '<td style="padding:5px 10px;border-bottom:1px solid #f0f0f0;font-size:9pt;text-align:center">' . $g['value'] . '/' . $g['max_value'] . '</td>'
                    . '<td style="padding:5px 10px;border-bottom:1px solid #f0f0f0;font-size:9pt;text-align:center;font-weight:700;color:#6366f1">' . $norm . '/20</td>'
                    . '<td style="padding:5px 10px;border-bottom:1px solid #f0f0f0;font-size:9pt;text-align:center;color:#888">&times;' . $g['coefficient'] . '</td>'
                    . '<td style="padding:5px 10px;border-bottom:1px solid #f0f0f0;font-size:9pt;text-align:center;color:#888">' . $dateStr . '</td>'
                    . '</tr>';

                if (!empty($g['comment'])) {
                    $tableRows .= '<tr><td colspan="5" style="padding:2px 10px 5px 22px;font-size:8pt;color:#888;font-style:italic;border-bottom:1px solid #f0f0f0">'
                        . htmlspecialchars($g['comment'], ENT_QUOTES)
                        . '</td></tr>';
                }
            }

            $tableRows .= '<tr><td colspan="5" style="height:8px"></td></tr>';
        }

        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><style>'
              . '*{box-sizing:border-box;margin:0;padding:0}'
              . 'body{font-family:DejaVu Sans,sans-serif;font-size:9.5pt;color:#111;padding:1cm 1.5cm}'
              . 'table{width:100%;border-collapse:collapse}'
              . '</style></head><body>'
              . '<table style="margin-bottom:8px"><tr>'
              . '<td style="font-size:18pt;font-weight:700;color:#6366f1">Grade Report</td>'
              . '<td style="text-align:right;font-size:8.5pt;color:#888;vertical-align:bottom;padding-bottom:3px">EduSync &nbsp;&bull;&nbsp; ' . $date . '</td>'
              . '</tr></table>'
              . '<table style="margin-bottom:12px"><tr><td style="border-top:2px solid #6366f1;font-size:0">&nbsp;</td></tr></table>'
              . '<table>'
              . '<thead><tr style="background:#fafafa">'
              . '<th style="padding:5px 10px;text-align:left;font-size:7.5pt;font-weight:600;color:#888;text-transform:uppercase;border-bottom:1px solid #e5e5e5">Grade</th>'
              . '<th style="padding:5px 10px;text-align:center;font-size:7.5pt;font-weight:600;color:#888;text-transform:uppercase;border-bottom:1px solid #e5e5e5;width:13%">Value</th>'
              . '<th style="padding:5px 10px;text-align:center;font-size:7.5pt;font-weight:600;color:#888;text-transform:uppercase;border-bottom:1px solid #e5e5e5;width:13%">/20</th>'
              . '<th style="padding:5px 10px;text-align:center;font-size:7.5pt;font-weight:600;color:#888;text-transform:uppercase;border-bottom:1px solid #e5e5e5;width:10%">Coeff</th>'
              . '<th style="padding:5px 10px;text-align:center;font-size:7.5pt;font-weight:600;color:#888;text-transform:uppercase;border-bottom:1px solid #e5e5e5;width:14%">Date</th>'
              . '</tr></thead>'
              . '<tbody>' . $tableRows . '</tbody>'
              . '</table>'
              . '<table style="margin-top:12px;width:auto">'
              . '<tr>'
              . '<td style="padding:8px 14px;border:2px solid #6366f1;font-size:9pt;color:#555;font-weight:600">Overall average</td>'
              . '<td style="padding:8px 16px;border-top:2px solid #6366f1;border-right:2px solid #6366f1;border-bottom:2px solid #6366f1;font-size:14pt;font-weight:700;color:#6366f1">' . $avgDisplay . '</td>'
              . '</tr>'
              . '</table>'
              . '</body></html>';

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('grade_report_' . date('d-m-Y') . '.pdf', ['Attachment' => true]);
        exit;
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
            $error = __('grades.name_required');
        } elseif (strlen($name) > 200) {
            $error = __('grades.name_too_long');
        } elseif ($subjectId <= 0) {
            $error = __('grades.subject_required');
        } elseif ($value < 0) {
            $error = __('grades.value_negative');
        } elseif ($maxValue <= 0) {
            $error = __('grades.max_value_zero');
        } elseif ($value > $maxValue) {
            $error = __('grades.value_exceeds_max');
        } elseif ($coefficient <= 0) {
            $error = __('grades.coefficient_zero');
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

    private function requireYear(int $userId): array
    {
        $year = AcademicYear::getActiveForUser($userId);
        if (!$year) {
            Session::flash('error', __('academic_year.required'));
            Session::redirect('/academic-years?setup=1');
        }
        return $year;
    }
}
