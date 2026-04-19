<?php

namespace EduSync\Controllers;

use EduSync\Core\Session;
use EduSync\Core\View;
use EduSync\Models\AcademicYear;
use EduSync\Models\Chapter;
use EduSync\Models\Document;
use EduSync\Models\Subject;
use EduSync\Models\Theme;

class CoursesController
{
    // ================================================================
    // SUBJECTS
    // ================================================================

    public function showSubjects(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $year   = $this->requireYear($userId);

        View::render('courses/subjects', [
            'title'      => __('nav.courses'),
            'flash'      => Session::getFlash(),
            'userName'   => Session::get('user_name', ''),
            'subjects'   => Subject::getAllByUserAndYear($userId, (int)$year['id']),
            'activeYear' => $year,
        ], 'layouts/app');
    }

    public function showCreateSubject(): void
    {
        $this->requireAuth();

        View::render('courses/subject_form', [
            'title'    => __('courses.new_subject_title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'subject'  => null,
        ], 'layouts/app');
    }

    public function createSubject(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        $name  = trim($_POST['name']  ?? '');
        $color = trim($_POST['color'] ?? '#6366f1');

        if ($name === '') {
            Session::flash('error', __('courses.name_required'));
            Session::redirect('/courses/create');
        }

        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        $year = $this->requireYear($userId);
        Subject::create($userId, $name, $color, (int)$year['id']);
        Session::flash('success', __('courses.subject_created'));
        Session::redirect('/courses');
    }

    public function showEditSubject(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_GET['id'] ?? 0);

        $subject = Subject::getByIdAndUser($id, $userId);
        if (!$subject) {
            Session::redirect('/courses');
        }

        View::render('courses/subject_form', [
            'title'    => __('courses.edit_subject_title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'subject'  => $subject,
        ], 'layouts/app');
    }

    public function updateSubject(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);

        $subject = Subject::getByIdAndUser($id, $userId);
        if (!$subject) {
            Session::redirect('/courses');
        }

        $name  = trim($_POST['name']  ?? '');
        $color = trim($_POST['color'] ?? '#6366f1');

        if ($name === '') {
            Session::flash('error', __('courses.name_required'));
            Session::redirect('/courses/edit?id=' . $id);
        }

        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        Subject::update($id, $userId, $name, $color);
        Session::flash('success', __('courses.subject_updated'));
        Session::redirect('/courses');
    }

    public function deleteSubject(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);

        $subject = Subject::getByIdAndUser($id, $userId);
        if ($subject) {
            Subject::delete($id, $userId);
            Session::flash('success', __('courses.subject_deleted'));
        }

        Session::redirect('/courses');
    }

    // ================================================================
    // THEMES
    // ================================================================

    public function showThemes(): void
    {
        $this->requireAuth();
        $userId    = $this->userId();
        $subjectId = (int) ($_GET['subject_id'] ?? 0);

        $subject = Subject::getByIdAndUser($subjectId, $userId);
        if (!$subject) {
            Session::redirect('/courses');
        }

        View::render('courses/themes', [
            'title'    => htmlspecialchars($subject['name']) . ' — ' . __('courses.themes'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'subject'  => $subject,
            'themes'   => Theme::getAllBySubject($subjectId),
        ], 'layouts/app');
    }

    public function showCreateTheme(): void
    {
        $this->requireAuth();
        $userId    = $this->userId();
        $subjectId = (int) ($_GET['subject_id'] ?? 0);

        $subject = Subject::getByIdAndUser($subjectId, $userId);
        if (!$subject) {
            Session::redirect('/courses');
        }

        View::render('courses/theme_form', [
            'title'    => __('courses.new_theme_title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'subject'  => $subject,
            'theme'    => null,
        ], 'layouts/app');
    }

    public function createTheme(): void
    {
        $this->requireAuth();
        $userId    = $this->userId();
        $subjectId = (int) ($_POST['subject_id'] ?? 0);

        $subject = Subject::getByIdAndUser($subjectId, $userId);
        if (!$subject) {
            Session::redirect('/courses');
        }

        $name  = trim($_POST['name']  ?? '');
        $color = trim($_POST['color'] ?? '#6366f1');
        if ($name === '') {
            Session::flash('error', __('courses.name_required'));
            Session::redirect('/themes/create?subject_id=' . $subjectId);
        }
        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        Theme::create($subjectId, $name, $color);
        Session::flash('success', __('courses.theme_created'));
        Session::redirect('/themes?subject_id=' . $subjectId);
    }

    public function showEditTheme(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_GET['id'] ?? 0);

        $theme = Theme::getByIdForUser($id, $userId);
        if (!$theme) {
            Session::redirect('/courses');
        }

        $subject = Subject::getByIdAndUser($theme['subject_id'], $userId);

        View::render('courses/theme_form', [
            'title'    => __('courses.edit_theme_title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'subject'  => $subject,
            'theme'    => $theme,
        ], 'layouts/app');
    }

    public function updateTheme(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);

        $theme = Theme::getByIdForUser($id, $userId);
        if (!$theme) {
            Session::redirect('/courses');
        }

        $name  = trim($_POST['name']  ?? '');
        $color = trim($_POST['color'] ?? '#6366f1');
        if ($name === '') {
            Session::flash('error', __('courses.name_required'));
            Session::redirect('/themes/edit?id=' . $id);
        }
        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        Theme::update($id, $name, $color);
        Session::flash('success', __('courses.theme_updated'));
        Session::redirect('/themes?subject_id=' . $theme['subject_id']);
    }

    public function deleteTheme(): void
    {
        $this->requireAuth();
        $userId    = $this->userId();
        $id        = (int) ($_POST['id'] ?? 0);
        $subjectId = (int) ($_POST['subject_id'] ?? 0);

        $theme = Theme::getByIdForUser($id, $userId);
        if ($theme) {
            Theme::delete($id);
            Session::flash('success', __('courses.theme_deleted'));
        }

        Session::redirect('/themes?subject_id=' . $subjectId);
    }

    // ================================================================
    // CHAPTERS
    // ================================================================

    public function showChapters(): void
    {
        $this->requireAuth();
        $userId  = $this->userId();
        $themeId = (int) ($_GET['theme_id'] ?? 0);

        $theme = Theme::getByIdForUser($themeId, $userId);
        if (!$theme) {
            Session::redirect('/courses');
        }

        View::render('courses/chapters', [
            'title'    => htmlspecialchars($theme['name']) . ' — ' . __('courses.chapters'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'theme'    => $theme,
            'chapters' => Chapter::getAllByTheme($themeId),
        ], 'layouts/app');
    }

    public function showCreateChapter(): void
    {
        $this->requireAuth();
        $userId  = $this->userId();
        $themeId = (int) ($_GET['theme_id'] ?? 0);

        $theme = Theme::getByIdForUser($themeId, $userId);
        if (!$theme) {
            Session::redirect('/courses');
        }

        View::render('courses/chapter_form', [
            'title'    => __('courses.new_chapter_title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'theme'    => $theme,
            'chapter'  => null,
        ], 'layouts/app');
    }

    public function createChapter(): void
    {
        $this->requireAuth();
        $userId  = $this->userId();
        $themeId = (int) ($_POST['theme_id'] ?? 0);

        $theme = Theme::getByIdForUser($themeId, $userId);
        if (!$theme) {
            Session::redirect('/courses');
        }

        $name  = trim($_POST['name']  ?? '');
        $color = trim($_POST['color'] ?? '#6366f1');
        if ($name === '') {
            Session::flash('error', __('courses.name_required'));
            Session::redirect('/chapters/create?theme_id=' . $themeId);
        }
        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        Chapter::create($themeId, $name, $color);
        Session::flash('success', __('courses.chapter_created'));
        Session::redirect('/chapters?theme_id=' . $themeId);
    }

    public function showEditChapter(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_GET['id'] ?? 0);

        $chapter = Chapter::getByIdForUser($id, $userId);
        if (!$chapter) {
            Session::redirect('/courses');
        }

        View::render('courses/chapter_form', [
            'title'    => __('courses.edit_chapter_title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'theme'    => ['id' => $chapter['theme_id'], 'name' => $chapter['theme_name'], 'subject_id' => $chapter['subject_id'], 'subject_name' => $chapter['subject_name']],
            'chapter'  => $chapter,
        ], 'layouts/app');
    }

    public function updateChapter(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);

        $chapter = Chapter::getByIdForUser($id, $userId);
        if (!$chapter) {
            Session::redirect('/courses');
        }

        $name  = trim($_POST['name']  ?? '');
        $color = trim($_POST['color'] ?? '#6366f1');
        if ($name === '') {
            Session::flash('error', __('courses.name_required'));
            Session::redirect('/chapters/edit?id=' . $id);
        }
        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        Chapter::update($id, $name, $color);
        Session::flash('success', __('courses.chapter_updated'));
        Session::redirect('/chapters?theme_id=' . $chapter['theme_id']);
    }

    public function deleteChapter(): void
    {
        $this->requireAuth();
        $userId  = $this->userId();
        $id      = (int) ($_POST['id'] ?? 0);
        $themeId = (int) ($_POST['theme_id'] ?? 0);

        $chapter = Chapter::getByIdForUser($id, $userId);
        if ($chapter) {
            Chapter::delete($id);
            Session::flash('success', __('courses.chapter_deleted'));
        }

        Session::redirect('/chapters?theme_id=' . $themeId);
    }

    // ================================================================
    // DOCUMENTS
    // ================================================================

    public function showDocuments(): void
    {
        $this->requireAuth();
        $userId    = $this->userId();
        $chapterId = (int) ($_GET['chapter_id'] ?? 0);

        $chapter = Chapter::getByIdForUser($chapterId, $userId);
        if (!$chapter) {
            Session::redirect('/courses');
        }

        View::render('courses/documents', [
            'title'     => htmlspecialchars($chapter['name']) . ' — ' . __('courses.documents'),
            'flash'     => Session::getFlash(),
            'userName'  => Session::get('user_name', ''),
            'chapter'   => $chapter,
            'documents' => Document::getAllByChapter($chapterId),
        ], 'layouts/app');
    }

    public function showUploadDocument(): void
    {
        $this->requireAuth();
        $userId    = $this->userId();
        $chapterId = (int) ($_GET['chapter_id'] ?? 0);

        $chapter = Chapter::getByIdForUser($chapterId, $userId);
        if (!$chapter) {
            Session::redirect('/courses');
        }

        View::render('courses/document_form', [
            'title'    => __('courses.upload_title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'chapter'  => $chapter,
        ], 'layouts/app');
    }

    public function uploadDocument(): void
    {
        $this->requireAuth();
        $userId    = $this->userId();
        $chapterId = (int) ($_POST['chapter_id'] ?? $_GET['chapter_id'] ?? 0);

        $chapter = Chapter::getByIdForUser($chapterId, $userId);
        if (!$chapter) {
            Session::redirect('/courses');
        }

        // Detect when PHP silently drops POST data because CONTENT_LENGTH > post_max_size
        $contentLength = (int) ($_SERVER['CONTENT_LENGTH'] ?? 0);
        $postMaxBytes  = (function (string $v): int {
            $v = trim($v); $u = strtolower(substr($v, -1)); $n = (int) $v;
            return $u === 'g' ? $n << 30 : ($u === 'm' ? $n << 20 : ($u === 'k' ? $n << 10 : $n));
        })(ini_get('post_max_size'));
        if ($contentLength > 0 && $postMaxBytes > 0 && $contentLength > $postMaxBytes) {
            Session::flash('error', __('courses.file_too_large'));
            Session::redirect('/documents/upload?chapter_id=' . $chapterId);
        }

        $title       = trim($_POST['title']       ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($title === '') {
            Session::flash('error', __('courses.title_required'));
            Session::redirect('/documents/upload?chapter_id=' . $chapterId);
        }

        if (empty($_FILES['file']) || $_FILES['file']['error'] === UPLOAD_ERR_NO_FILE) {
            Session::flash('error', __('courses.file_required'));
            Session::redirect('/documents/upload?chapter_id=' . $chapterId);
        }

        try {
            Document::upload($chapterId, $title, $description, $_FILES['file']);
            Session::flash('success', __('courses.doc_uploaded'));
        } catch (\RuntimeException $e) {
            Session::flash('error', $e->getMessage());
        }

        Session::redirect('/documents?chapter_id=' . $chapterId);
    }

    public function deleteDocument(): void
    {
        $this->requireAuth();
        $userId    = $this->userId();
        $id        = (int) ($_POST['id']         ?? 0);
        $chapterId = (int) ($_POST['chapter_id'] ?? 0);

        $doc = Document::getMetaByIdForUser($id, $userId);
        if ($doc) {
            Document::delete($id);
            Session::flash('success', __('courses.doc_deleted'));
        }

        Session::redirect('/documents?chapter_id=' . $chapterId);
    }

    public function viewDocument(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_GET['id'] ?? 0);

        $doc = Document::getMetaByIdForUser($id, $userId);
        if (!$doc) {
            Session::redirect('/courses');
        }

        if ($doc['file_type'] === 'text/html') {
            $full = Document::getByIdForUser($id, $userId);
            $doc['note_content'] = $full ? (string) $full['content'] : '';
        }

        View::render('courses/document_view', [
            'title'    => htmlspecialchars($doc['title']),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'doc'      => $doc,
        ], 'layouts/app');
    }

    public function showCreateNote(): void
    {
        $this->requireAuth();
        $userId    = $this->userId();
        $chapterId = (int) ($_GET['chapter_id'] ?? 0);

        $chapter = Chapter::getByIdForUser($chapterId, $userId);
        if (!$chapter) {
            Session::redirect('/courses');
        }

        View::render('courses/note_editor', [
            'title'    => __('courses.new_note_title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'chapter'  => $chapter,
            'note'     => null,
        ], 'layouts/app');
    }

    public function createNote(): void
    {
        $this->requireAuth();
        $userId    = $this->userId();
        $chapterId = (int) ($_POST['chapter_id'] ?? 0);

        $chapter = Chapter::getByIdForUser($chapterId, $userId);
        if (!$chapter) {
            Session::redirect('/courses');
        }

        $noteTitle   = trim($_POST['title']       ?? '');
        $description = trim($_POST['description'] ?? '');
        $content     = $_POST['content']           ?? '';

        if ($noteTitle === '') {
            Session::flash('error', __('courses.title_required'));
            Session::redirect('/documents/note/new?chapter_id=' . $chapterId);
        }

        Document::createNote($chapterId, $noteTitle, $description, $content);
        Session::flash('success', __('courses.note_created'));
        Session::redirect('/documents?chapter_id=' . $chapterId);
    }

    public function showEditNote(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_GET['id'] ?? 0);

        $doc = Document::getByIdForUser($id, $userId);
        if (!$doc || $doc['file_type'] !== 'text/html') {
            Session::redirect('/courses');
        }

        View::render('courses/note_editor', [
            'title'    => __('courses.edit_note_title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'chapter'  => [
                'id'           => $doc['chapter_id'],
                'name'         => $doc['chapter_name'],
                'color'        => $doc['chapter_color'],
                'theme_id'     => $doc['theme_id'],
                'theme_name'   => $doc['theme_name'],
                'subject_id'   => $doc['subject_id'],
                'subject_name' => $doc['subject_name'],
            ],
            'note' => $doc,
        ], 'layouts/app');
    }

    public function printNote(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_GET['id'] ?? 0);

        $doc = Document::getByIdForUser($id, $userId);
        if (!$doc || $doc['file_type'] !== 'text/html') {
            Session::redirect('/courses');
        }

        $title   = htmlspecialchars($doc['title'], ENT_QUOTES);
        $content = (string) $doc['content'];
        $filename = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $doc['title']) . '.pdf';

        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8">'
              . '<style>'
              . '*{box-sizing:border-box;margin:0;padding:0}'
              . 'body{font-family:DejaVu Sans,sans-serif;font-size:12pt;color:#111;line-height:1.75;padding:1cm 1.2cm}'
              . 'h1.note-title{font-size:18pt;font-weight:700;margin-bottom:.4cm;border-bottom:1px solid #ccc;padding-bottom:.2cm}'
              . '.note-body h1{font-size:15pt;font-weight:700;margin:1em 0 .3em}'
              . '.note-body h2{font-size:13pt;font-weight:700;margin:1em 0 .3em}'
              . '.note-body h3{font-size:11pt;font-weight:700;margin:.8em 0 .25em}'
              . '.note-body p,.note-body div{margin:.3em 0}'
              . '.note-body ul,.note-body ol{padding-left:1.5em;margin:.4em 0}'
              . '.note-body li{margin:.15em 0}'
              . '.note-body b,.note-body strong{font-weight:700}'
              . '.note-body i,.note-body em{font-style:italic}'
              . '.note-body u{text-decoration:underline}'
              . '.note-body s,.note-body strike{text-decoration:line-through}'
              . '.note-body sup{font-size:.75em;vertical-align:super}'
              . '.note-body sub{font-size:.75em;vertical-align:sub}'
              . '.note-body hr{border:none;border-top:1px solid #ccc;margin:.5em 0}'
              . '</style>'
              . '</head><body>'
              . '<h1 class="note-title">' . $title . '</h1>'
              . '<div class="note-body">' . $content . '</div>'
              . '</body></html>';

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($filename, ['Attachment' => true]);
        exit;
    }

    public function updateNote(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);

        $doc = Document::getMetaByIdForUser($id, $userId);
        if (!$doc || $doc['file_type'] !== 'text/html') {
            Session::redirect('/courses');
        }

        $noteTitle   = trim($_POST['title']       ?? '');
        $description = trim($_POST['description'] ?? '');
        $content     = $_POST['content']           ?? '';

        if ($noteTitle === '') {
            Session::flash('error', __('courses.title_required'));
            Session::redirect('/documents/note/edit?id=' . $id);
        }

        Document::updateNote($id, $noteTitle, $description, $content);
        Session::flash('success', __('courses.note_saved'));
        Session::redirect('/documents/view?id=' . $id);
    }

    public function serveDocument(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_GET['id'] ?? 0);

        $doc = Document::getByIdForUser($id, $userId);
        if (!$doc || $doc['content'] === null) {
            http_response_code(404);
            echo '<h1>404 — Document not found</h1>';
            return;
        }

        header('Content-Type: '        . $doc['file_type']);
        header('Content-Disposition: inline; filename="' . addslashes($doc['original_name']) . '"');
        header('Content-Length: '      . strlen($doc['content']));
        echo $doc['content'];
    }

    public function downloadDocument(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_GET['id'] ?? 0);

        $doc = Document::getByIdForUser($id, $userId);
        if (!$doc || $doc['content'] === null) {
            http_response_code(404);
            echo '<h1>404 — Document not found</h1>';
            return;
        }

        header('Content-Type: '        . $doc['file_type']);
        header('Content-Disposition: attachment; filename="' . addslashes($doc['original_name']) . '"');
        header('Content-Length: '      . strlen($doc['content']));
        echo $doc['content'];
    }

    public function showEditDocument(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_GET['id'] ?? 0);

        $doc = Document::getMetaByIdForUser($id, $userId);
        if (!$doc) {
            Session::redirect('/courses');
        }

        View::render('courses/document_edit', [
            'title'    => __('courses.edit_doc_title'),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'doc'      => $doc,
        ], 'layouts/app');
    }

    public function updateDocument(): void
    {
        $this->requireAuth();
        $userId = $this->userId();
        $id     = (int) ($_POST['id'] ?? 0);

        $doc = Document::getMetaByIdForUser($id, $userId);
        if (!$doc) {
            Session::redirect('/courses');
        }

        $title       = trim($_POST['title']       ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($title === '') {
            Session::flash('error', __('courses.title_required'));
            Session::redirect('/documents/edit?id=' . $id);
        }

        $file = (!empty($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE)
            ? $_FILES['file']
            : null;

        try {
            Document::update($id, $title, $description, $file);
            Session::flash('success', __('courses.doc_updated'));
        } catch (\RuntimeException $e) {
            Session::flash('error', $e->getMessage());
            Session::redirect('/documents/edit?id=' . $id);
        }

        Session::redirect('/documents/view?id=' . $id);
    }

    public function exportCourses(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        $subjectId = isset($_GET['subject_id']) ? (int) $_GET['subject_id'] : null;
        $themeId   = isset($_GET['theme_id'])   ? (int) $_GET['theme_id']   : null;
        $chapterId = isset($_GET['chapter_id']) ? (int) $_GET['chapter_id'] : null;

        if ($chapterId) {
            $chapter = Chapter::getByIdForUser($chapterId, $userId);
            if (!$chapter) Session::redirect('/courses');
            $docs    = Document::getAllByChapterForExport($chapterId, $userId);
            $zipName = $this->safeName($chapter['name']) . '.zip';
        } elseif ($themeId) {
            $theme   = Theme::getByIdForUser($themeId, $userId);
            if (!$theme) Session::redirect('/courses');
            $docs    = Document::getAllByThemeForExport($themeId, $userId);
            $zipName = $this->safeName($theme['name']) . '.zip';
        } elseif ($subjectId) {
            $subject = Subject::getByIdAndUser($subjectId, $userId);
            if (!$subject) Session::redirect('/courses');
            $docs    = Document::getAllBySubjectForExport($subjectId, $userId);
            $zipName = $this->safeName($subject['name']) . '.zip';
        } else {
            $docs    = Document::getAllForExport($userId);
            $zipName = 'Courses.zip';
        }

        $tmpFile = tempnam(sys_get_temp_dir(), 'es_zip_');
        $zip     = new \ZipArchive();
        if ($zip->open($tmpFile, \ZipArchive::OVERWRITE) !== true) {
            Session::flash('error', 'Could not create ZIP archive.');
            Session::redirect('/courses');
        }

        // Create complete folder structure (including subjects/themes/chapters with no documents)
        if ($chapterId) {
            $zip->addEmptyDir($this->safeName($chapter['name']));
        } else {
            foreach (Document::getChaptersHierarchyForExport($userId, $subjectId, $themeId) as $row) {
                $parts = [];
                if (!$subjectId && !$themeId && $row['subject_name'] !== null) {
                    $parts[] = $this->safeName($row['subject_name']);
                }
                if (!$themeId && $row['theme_name'] !== null) {
                    $parts[] = $this->safeName($row['theme_name']);
                }
                if ($row['chapter_name'] !== null) {
                    $parts[] = $this->safeName($row['chapter_name']);
                }
                if (!empty($parts)) {
                    $zip->addEmptyDir(implode('/', $parts));
                }
            }
        }

        foreach ($docs as $doc) {
            $parts = [];

            if (!$subjectId && !$themeId && !$chapterId) {
                $parts[] = $this->safeName($doc['subject_name']);
            }
            if (!$themeId && !$chapterId) {
                $parts[] = $this->safeName($doc['theme_name']);
            }
            if (!$chapterId) {
                $parts[] = $this->safeName($doc['chapter_name']);
            }

            if ($doc['file_type'] === 'text/html') {
                $parts[]     = $this->safeName($doc['title']) . '.pdf';
                $fileContent = $this->htmlNoteToPdf($doc['title'], (string) $doc['content']);
            } else {
                $ext     = pathinfo((string) $doc['original_name'], PATHINFO_EXTENSION);
                $base    = pathinfo((string) $doc['original_name'], PATHINFO_FILENAME);
                $parts[] = $this->safeName($base) . ($ext !== '' ? '.' . $ext : '');
                $fileContent = (string) $doc['content'];
            }

            $zip->addFromString(implode('/', $parts), $fileContent);
        }

        $zip->close();

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zipName . '"');
        header('Content-Length: ' . filesize($tmpFile));
        readfile($tmpFile);
        unlink($tmpFile);
        exit;
    }

    private function htmlNoteToPdf(string $title, string $content): string
    {
        $safeTitle = htmlspecialchars($title, ENT_QUOTES);
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8">'
              . '<style>'
              . '*{box-sizing:border-box;margin:0;padding:0}'
              . 'body{font-family:DejaVu Sans,sans-serif;font-size:12pt;color:#111;line-height:1.75;padding:1cm 1.2cm}'
              . 'h1.note-title{font-size:18pt;font-weight:700;margin-bottom:.4cm;border-bottom:1px solid #ccc;padding-bottom:.2cm}'
              . '.note-body h1{font-size:15pt;font-weight:700;margin:1em 0 .3em}'
              . '.note-body h2{font-size:13pt;font-weight:700;margin:1em 0 .3em}'
              . '.note-body h3{font-size:11pt;font-weight:700;margin:.8em 0 .25em}'
              . '.note-body p,.note-body div{margin:.3em 0}'
              . '.note-body ul,.note-body ol{padding-left:1.5em;margin:.4em 0}'
              . '.note-body li{margin:.15em 0}'
              . '.note-body b,.note-body strong{font-weight:700}'
              . '.note-body i,.note-body em{font-style:italic}'
              . '.note-body u{text-decoration:underline}'
              . '.note-body s,.note-body strike{text-decoration:line-through}'
              . '.note-body sup{font-size:.75em;vertical-align:super}'
              . '.note-body sub{font-size:.75em;vertical-align:sub}'
              . '.note-body hr{border:none;border-top:1px solid #ccc;margin:.5em 0}'
              . '</style>'
              . '</head><body>'
              . '<h1 class="note-title">' . $safeTitle . '</h1>'
              . '<div class="note-body">' . $content . '</div>'
              . '</body></html>';

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->output();
    }

    private function safeName(string $name): string
    {
        $safe = preg_replace('/[\/\\\\:*?"<>|]/', '_', $name);
        return trim($safe) ?: 'unnamed';
    }

    // ================================================================
    // Helpers
    // ================================================================

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
