<?php

namespace EduSync\Controllers;

use EduSync\Core\Session;
use EduSync\Core\View;
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

        View::render('courses/subjects', [
            'title'    => 'Courses',
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'subjects' => Subject::getAllByUser($userId),
        ], 'layouts/app');
    }

    public function showCreateSubject(): void
    {
        $this->requireAuth();

        View::render('courses/subject_form', [
            'title'    => 'New subject',
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
            Session::flash('error', 'Subject name is required.');
            Session::redirect('/courses/create');
        }

        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        Subject::create($userId, $name, $color);
        Session::flash('success', 'Subject created.');
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
            'title'    => 'Edit subject',
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
            Session::flash('error', 'Subject name is required.');
            Session::redirect('/courses/edit?id=' . $id);
        }

        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        Subject::update($id, $userId, $name, $color);
        Session::flash('success', 'Subject updated.');
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
            Session::flash('success', 'Subject deleted.');
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
            'title'    => htmlspecialchars($subject['name']) . ' — Themes',
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
            'title'    => 'New theme',
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
            Session::flash('error', 'Theme name is required.');
            Session::redirect('/themes/create?subject_id=' . $subjectId);
        }
        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        Theme::create($subjectId, $name, $color);
        Session::flash('success', 'Theme created.');
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
            'title'    => 'Edit theme',
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
            Session::flash('error', 'Theme name is required.');
            Session::redirect('/themes/edit?id=' . $id);
        }
        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        Theme::update($id, $name, $color);
        Session::flash('success', 'Theme updated.');
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
            Session::flash('success', 'Theme deleted.');
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
            'title'    => htmlspecialchars($theme['name']) . ' — Chapters',
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
            'title'    => 'New chapter',
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
            Session::flash('error', 'Chapter name is required.');
            Session::redirect('/chapters/create?theme_id=' . $themeId);
        }
        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        Chapter::create($themeId, $name, $color);
        Session::flash('success', 'Chapter created.');
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
            'title'    => 'Edit chapter',
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
            Session::flash('error', 'Chapter name is required.');
            Session::redirect('/chapters/edit?id=' . $id);
        }
        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            $color = '#6366f1';
        }

        Chapter::update($id, $name, $color);
        Session::flash('success', 'Chapter updated.');
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
            Session::flash('success', 'Chapter deleted.');
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
            'title'     => htmlspecialchars($chapter['name']) . ' — Documents',
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
            'title'    => 'Upload document',
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
            Session::flash('error', 'File is too large. Maximum allowed is 50 MB.');
            Session::redirect('/documents/upload?chapter_id=' . $chapterId);
        }

        $title       = trim($_POST['title']       ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($title === '') {
            Session::flash('error', 'Title is required.');
            Session::redirect('/documents/upload?chapter_id=' . $chapterId);
        }

        if (empty($_FILES['file']) || $_FILES['file']['error'] === UPLOAD_ERR_NO_FILE) {
            Session::flash('error', 'Please select a file.');
            Session::redirect('/documents/upload?chapter_id=' . $chapterId);
        }

        try {
            Document::upload($chapterId, $title, $description, $_FILES['file']);
            Session::flash('success', 'Document uploaded.');
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
            Session::flash('success', 'Document deleted.');
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

        View::render('courses/document_view', [
            'title'    => htmlspecialchars($doc['title']),
            'flash'    => Session::getFlash(),
            'userName' => Session::get('user_name', ''),
            'doc'      => $doc,
        ], 'layouts/app');
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
            'title'    => 'Edit document',
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
            Session::flash('error', 'Title is required.');
            Session::redirect('/documents/edit?id=' . $id);
        }

        $file = (!empty($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE)
            ? $_FILES['file']
            : null;

        try {
            Document::update($id, $title, $description, $file);
            Session::flash('success', 'Document updated.');
        } catch (\RuntimeException $e) {
            Session::flash('error', $e->getMessage());
            Session::redirect('/documents/edit?id=' . $id);
        }

        Session::redirect('/documents/view?id=' . $id);
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
}
