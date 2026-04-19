<?php

namespace EduSync\Controllers;

use EduSync\Core\Session;
use EduSync\Core\View;
use EduSync\Models\AcademicYear;

class AcademicYearController
{
    public function show(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        View::render('academic_years/index', [
            'title'    => __('academic_year.title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'years'    => AcademicYear::getByUser($userId),
            'active'   => AcademicYear::getActiveForUser($userId),
            'setup'    => isset($_GET['setup']),
        ], 'layouts/app');
    }

    public function create(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            Session::flash('error', __('academic_year.name_required'));
            Session::redirect($this->backUrl());
        }
        if (strlen($name) > 100) {
            Session::flash('error', __('academic_year.name_too_long'));
            Session::redirect($this->backUrl());
        }

        AcademicYear::create($userId, $name);
        Session::flash('success', __('academic_year.created'));
        Session::redirect($this->backUrl());
    }

    public function switch(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_GET['id'] ?? 0);

        if ($id > 0 && AcademicYear::getByIdAndUser($id, $userId)) {
            AcademicYear::setActive($id, $userId);
        }

        $to = trim($_GET['redirect_to'] ?? '');
        if ($to && str_starts_with($to, '/') && !str_starts_with($to, '//')) {
            Session::redirect($to);
        }
        $referer = $_SERVER['HTTP_REFERER'] ?? '/dashboard';
        $parsed  = parse_url($referer);
        $safe    = empty($parsed['host']) || $parsed['host'] === ($_SERVER['HTTP_HOST'] ?? '');
        Session::redirect($safe ? $referer : '/dashboard');
    }

    public function rename(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);
        $name   = trim($_POST['name'] ?? '');

        if ($name === '') {
            Session::flash('error', __('academic_year.name_required'));
            Session::redirect($this->backUrl());
        }
        if (strlen($name) > 100) {
            Session::flash('error', __('academic_year.name_too_long'));
            Session::redirect($this->backUrl());
        }

        if ($id > 0 && AcademicYear::getByIdAndUser($id, $userId)) {
            AcademicYear::rename($id, $userId, $name);
            Session::flash('success', __('academic_year.renamed'));
        }
        Session::redirect($this->backUrl());
    }

    public function delete(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);

        if ($id <= 0 || !AcademicYear::getByIdAndUser($id, $userId)) {
            Session::redirect($this->backUrl());
        }

        if (AcademicYear::hasSubjects($id, $userId)) {
            Session::flash('error', __('academic_year.has_subjects'));
            Session::redirect($this->backUrl());
        }

        AcademicYear::delete($id, $userId);
        Session::flash('success', __('academic_year.deleted'));
        Session::redirect($this->backUrl());
    }

    public function exportZip(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_GET['id'] ?? 0);

        $year = $id > 0 ? \EduSync\Models\AcademicYear::getByIdAndUser($id, $userId) : null;
        if (!$year) {
            http_response_code(404);
            return;
        }

        $docs    = \EduSync\Models\AcademicYear::getDocumentsForExport($id, $userId);
        $grouped = \EduSync\Models\Grade::getBySubjectGrouped($userId, $id);
        $average = \EduSync\Models\Grade::getWeightedAverage($userId, $id);

        $zipFile = tempnam(sys_get_temp_dir(), 'edusync_');
        $zip     = new \ZipArchive();
        if ($zip->open($zipFile, \ZipArchive::OVERWRITE) !== true) {
            http_response_code(500);
            return;
        }

        $sanitize   = fn(string $s) => preg_replace('/[\/\\\\:*?"<>|]/', '_', $s);
        $yearFolder = $sanitize($year['name']);

        // Folder structure + documents
        foreach ($docs as $doc) {
            $subject = $sanitize((string) $doc['subject_name']);
            $theme   = $sanitize((string) $doc['theme_name']);
            $chapter = $sanitize((string) $doc['chapter_name']);
            $zip->addEmptyDir("$subject/$theme/$chapter");

            if ($doc['title'] === null) {
                continue;
            }

            $content = $doc['content'];
            if (is_resource($content)) {
                $content = stream_get_contents($content);
            }
            $ext   = pathinfo((string) $doc['original_name'], PATHINFO_EXTENSION) ?: 'bin';
            $title = $sanitize((string) $doc['title']);
            $zip->addFromString("$subject/$theme/$chapter/$title.$ext", (string) $content);
        }

        // Grades PDF — identical to GradesController::exportGrades()
        if (!empty($grouped)) {
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
                    $norm    = number_format((float)$g['value'] / (float)$g['max_value'] * 20, 2);
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
                            . htmlspecialchars($g['comment'], ENT_QUOTES) . '</td></tr>';
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
                  . '<table style="margin-top:12px;width:auto"><tr>'
                  . '<td style="padding:8px 14px;border:2px solid #6366f1;font-size:9pt;color:#555;font-weight:600">Overall average</td>'
                  . '<td style="padding:8px 16px;border-top:2px solid #6366f1;border-right:2px solid #6366f1;border-bottom:2px solid #6366f1;font-size:14pt;font-weight:700;color:#6366f1">' . $avgDisplay . '</td>'
                  . '</tr></table>'
                  . '</body></html>';

            $options = new \Dompdf\Options();
            $options->set('isHtml5ParserEnabled', true);
            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $zip->addFromString('grades.pdf', $dompdf->output());
        }

        $zip->close();

        $zipName = $yearFolder . '.zip';
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zipName . '"');
        header('Content-Length: ' . filesize($zipFile));
        header('Cache-Control: no-store');
        readfile($zipFile);
        unlink($zipFile);
        exit;
    }

    public function forceDelete(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        header('Content-Type: application/json');

        $id       = (int) ($_POST['id'] ?? 0);
        $password = $_POST['password'] ?? '';

        $year = $id > 0 ? \EduSync\Models\AcademicYear::getByIdAndUser($id, $userId) : null;
        if (!$year) {
            echo json_encode(['ok' => false, 'error' => 'Year not found.']);
            return;
        }

        $db   = \EduSync\Core\Database::getInstance();
        $stmt = $db->prepare('SELECT password FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$userId]);
        $row = $stmt->fetch();

        if (!$row || !password_verify($password, $row['password'])) {
            echo json_encode(['ok' => false, 'error' => __('academic_year.wrong_password')]);
            return;
        }

        \EduSync\Models\AcademicYear::delete($id, $userId);
        echo json_encode(['ok' => true]);
    }

    private function backUrl(): string
    {
        $to = trim($_POST['redirect_to'] ?? '');
        if ($to && str_starts_with($to, '/') && !str_starts_with($to, '//')) {
            return $to;
        }
        return '/academic-years';
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
