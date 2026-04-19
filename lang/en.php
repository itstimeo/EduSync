<?php

return [

    // ── Navigation ────────────────────────────────────────────────────
    'nav' => [
        'courses'  => 'Courses',
        'grades'   => 'Grades',
        'planning' => 'Planning',
        'revision' => 'Revision',
        'profile'  => 'Profile',
    ],

    // ── Confirmation modal ────────────────────────────────────────────
    'modal' => [
        'cancel' => 'Cancel',
        'delete' => 'Delete',
    ],

    // ── Common ────────────────────────────────────────────────────────
    'common' => [
        'save'         => 'Save',
        'cancel'       => 'Cancel',
        'delete'       => 'Delete',
        'edit'         => 'Edit',
        'back'         => 'Back',
        'add'          => 'Add',
        'name'         => 'Name',
        'color'        => 'Color',
        'required'     => 'Required',
        'optional'     => 'optional',
        'description'  => 'Description',
        'title'        => 'Title',
        'date'         => 'Date',
        'export'       => 'Export',
        'export_pdf'   => 'Export PDF',
        'settings'     => 'Settings',
        'new'          => 'New',
        'no_items'     => 'Nothing here yet.',
        'error'        => 'Error.',
        'rename'       => 'Rename',
        'create'       => 'Create',
    ],

    // ── Auth ──────────────────────────────────────────────────────────
    'auth' => [
        'login' => [
            'title'       => 'Sign in to EduSync',
            'subtitle'    => 'Welcome back',
            'email'       => 'Email address',
            'password'    => 'Password',
            'remember'    => 'Remember me',
            'submit'      => 'Sign in',
            'no_account'  => "Don't have an account?",
            'register'    => 'Create one',
        ],
        'register' => [
            'title'       => 'Create your account',
            'subtitle'    => 'Start organizing your studies',
            'first_name'  => 'First name',
            'last_name'   => 'Last name',
            'email'       => 'Email address',
            'password'    => 'Password',
            'confirm'     => 'Confirm password',
            'submit'      => 'Create account',
            'has_account' => 'Already have an account?',
            'login'       => 'Sign in',
        ],
        'verify_email' => [
            'title'    => 'Verify your email',
            'subtitle' => 'Enter the 6-digit code sent to your email address.',
            'code'     => 'Verification code',
            'submit'   => 'Verify',
        ],
        'verify_ip' => [
            'title'    => 'New device detected',
            'subtitle' => 'Enter the 6-digit code sent to your email to confirm this device.',
            'code'     => 'Security code',
            'submit'   => 'Confirm device',
        ],
        'errors' => [
            'email_password_required' => 'Email and password are required.',
            'all_fields_required'     => 'All fields are required.',
            'passwords_no_match'      => 'Passwords do not match.',
            'code_required'           => 'Verification code is required.',
        ],
    ],

    // ── Dashboard ─────────────────────────────────────────────────────
    'dashboard' => [
        'title'               => 'Dashboard',
        'recent_grades'       => 'Recent grades',
        'overall_average'     => 'Overall average',
        'this_week'           => "This week's events",
        'no_events'           => 'No events this week.',
        'todays_revisions'    => "Today's revisions",
        'nothing_to_revise'   => 'Nothing to revise today.',
        'last_step_mastered'  => 'Last step done — mastered',
        'mark_done'           => 'Done',
        'no_grades'           => 'No grades yet.',
    ],

    // ── Courses ───────────────────────────────────────────────────────
    'courses' => [
        'title'           => 'My subjects',
        'no_subjects'     => 'No subjects yet...',
        'no_themes'       => 'No themes yet.',
        'no_chapters'     => 'No chapters yet.',
        'no_documents'    => 'No documents yet.',
        'export_all'      => 'Export all',
        'export'          => 'Export',
        'write'           => '✎ Write',
        'upload'          => '+ Upload',
        'new_subject'     => '+ New subject',
        'new_theme'       => '+ New theme',
        'new_chapter'     => '+ New chapter',
        'subjects'        => 'Subjects',
        'themes'          => 'Themes',
        'chapters'        => 'Chapters',
        'documents'       => 'Documents',

        // Subject form
        'subject_name'    => 'Subject name',
        'new_subject_title'  => 'New subject',
        'edit_subject_title' => 'Edit subject',

        // Theme form
        'theme_name'      => 'Theme name',
        'new_theme_title'  => 'New theme',
        'edit_theme_title' => 'Edit theme',

        // Chapter form
        'chapter_name'    => 'Chapter name',
        'new_chapter_title'  => 'New chapter',
        'edit_chapter_title' => 'Edit chapter',

        // Document upload
        'upload_title'    => 'Upload document',
        'doc_title'       => 'Title',
        'choose_file'     => 'Choose file',
        'no_file_chosen'  => 'No file chosen',
        'file_hint'       => 'PDF, DOCX, image — max 50 MB',
        'edit_doc_title'  => 'Edit document',
        'replace_file'    => 'Replace file',
        'current_file'    => 'Current',
        'keep_file_hint'  => 'Leave empty to keep the current file.',

        // Document view
        'download'        => 'Download',
        'no_preview'      => 'Preview not available for this file type.',

        // Note editor
        'new_note_title'  => 'New note',
        'edit_note_title' => 'Edit note',
        'create_note'     => 'Create note',
        'note_placeholder' => 'Start writing your note…',

        // Errors
        'name_required'     => 'Please enter a name.',
        'title_required'    => 'Title is required.',
        'file_required'     => 'Please select a file.',
        'file_too_large'    => 'File is too large. Maximum allowed is 50 MB.',
        'no_docs_to_export' => 'No documents to export.',
        'no_grades_export'  => 'No grades to export.',

        // Flash
        'subject_created' => 'Subject created.',
        'subject_updated' => 'Subject updated.',
        'subject_deleted' => 'Subject deleted.',
        'theme_created'   => 'Theme created.',
        'theme_updated'   => 'Theme updated.',
        'theme_deleted'   => 'Theme deleted.',
        'chapter_created' => 'Chapter created.',
        'chapter_updated' => 'Chapter updated.',
        'chapter_deleted' => 'Chapter deleted.',
        'doc_uploaded'    => 'Document uploaded.',
        'doc_updated'     => 'Document updated.',
        'doc_deleted'     => 'Document deleted.',
        'note_created'    => 'Note created.',
        'note_saved'      => 'Note saved.',
        'invalid_subject' => 'Invalid subject.',

        // Confirm
        'delete_confirm'  => 'Delete «%s»?',
    ],

    // ── Grades ────────────────────────────────────────────────────────
    'grades' => [
        'title'           => 'Grades',
        'new_grade'       => '+ New grade',
        'export_pdf'      => 'Export PDF',
        'overall_average' => 'Overall average',
        'by_subject'      => 'By subject',
        'chronological'   => 'Chronological',
        'statistics'      => 'Statistics',
        'no_grades'       => 'No grades yet.',
        'avg'             => 'Avg:',
        'overall_avg'     => 'Overall average',
        'avg_progression' => 'Average progression',
        'add_dates_hint'  => 'Add dates to your grades to see trends.',
        'page_of'         => 'Page %d of %d',

        // Form
        'subject'     => 'Subject',
        'grade_name'  => 'Grade name',
        'value'       => 'Grade',
        'out_of'      => 'Out of',
        'coefficient' => 'Coefficient',
        'comment'     => 'Comment',
        'select_subj' => '— select —',
        'new_title'   => 'New grade',
        'edit_title'  => 'Edit grade',

        // Errors
        'name_required'       => 'Grade name is required.',
        'name_too_long'       => 'Grade name is too long (max 200 characters).',
        'subject_required'    => 'Please select a subject.',
        'value_negative'      => 'Grade value cannot be negative.',
        'max_value_zero'      => 'Max value must be greater than 0.',
        'value_exceeds_max'   => 'Grade value cannot exceed max value.',
        'coefficient_zero'    => 'Coefficient must be greater than 0.',
        'invalid_subject'     => 'Invalid subject.',

        // Flash
        'grade_added'   => 'Grade added.',
        'grade_updated' => 'Grade updated.',
        'grade_deleted' => 'Grade deleted.',

        // Confirm
        'delete_confirm' => 'Delete this grade?',
    ],

    // ── Planning ──────────────────────────────────────────────────────
    'planning' => [
        'title'        => 'Planning',
        'new_event'    => '+ New event',
        'calendar'     => 'Calendar',
        'list'         => 'List',
        'no_events'    => 'No events this month.',
        'no_day_events' => 'No events on this day.',
        'more'         => '+%d more',
        'settings'     => 'Settings',

        // Event form
        'new_event_title'  => 'New event',
        'edit_event_title' => 'Edit event',
        'event_title'      => 'Title',
        'type'             => 'Type',
        'color'            => 'Color',
        'start_date'       => 'Start date',
        'end_date'         => 'End date',
        'end_date_opt'     => '(optional)',
        'description'      => 'Description',
        'description_opt'  => '(optional)',
        'save'             => 'Save',
        'delete'           => 'Delete',

        // Errors
        'title_required'      => 'Title is required.',
        'title_too_long'      => 'Title is too long (max 200 characters).',
        'start_date_required' => 'Please select a start date.',
        'end_date_invalid'    => 'End date must be on or after start date.',

        // Settings
        'settings_title'     => 'Event types',
        'settings_subtitle'  => 'Manage your event types and their colors.',
        'add_type'           => 'Add a type',
        'type_placeholder'   => 'Type name (e.g. Lab Work)',
        'type_name_required' => 'Please enter a type name.',

        // Flash
        'event_created'  => 'Event created.',
        'event_updated'  => 'Event updated.',
        'event_deleted'  => 'Event deleted.',
        'type_added'     => 'Type added.',
        'type_deleted'   => 'Type deleted.',
        'settings_saved' => 'Settings saved.',
        'type_name_error'=> 'Type name is required (max 50 characters).',

        // Confirm
        'delete_confirm' => 'Delete «%s»?',
        'delete_type_confirm' => 'Delete type «%s»?',
    ],

    // ── Profile ───────────────────────────────────────────────────────
    'profile' => [
        'title'          => 'Profile',
        'informations'   => 'Informations',
        'first_name'     => 'First name',
        'last_name'      => 'Last name',
        'save'           => 'Save',
        'photo'          => 'Profile photo',
        'upload_photo'   => 'Upload a photo',
        'delete_photo'   => 'Delete photo',
        'security'       => 'Security',
        'email_address'  => 'Email address',
        'change_email'   => 'Change email',
        'password'       => 'Password',
        'change_password'=> 'Change password',
        'integrations'   => 'Integrations',
        'gcal_title'     => 'Sync with Google Calendar',
        'gcal_desc'      => 'Your planning events will be automatically pushed to your Google Calendar when created, edited or deleted.',
        'connected'      => '● Connected',
        'disconnected'   => '● Disconnected',
        'connect'        => 'Connect',
        'disconnect'     => 'Disconnect',
        'language'       => 'Language',
        'language_desc'  => 'Choose the interface language.',
        'session'        => 'Session',
        'logout'         => 'Log out',
        'logout_desc'    => 'End your current session on this device.',
        'logout_confirm' => 'Log out of EduSync?',

        // Email change popup
        'email_popup_title'   => 'Change email address',
        'current_email'       => 'Current email',
        'new_email'           => 'New email',
        'send_codes'          => 'Send codes',
        'codes_sent'          => 'Codes have been sent to both addresses. Enter them below.',
        'code_old_email'      => 'Code sent to current email',
        'code_new_email'      => 'Code sent to new email',
        'confirm'             => 'Confirm',

        // Password change popup
        'pw_popup_title'  => 'Change password',
        'current_password'=> 'Current password',
        'new_password'    => 'New password',
        'pw_hint'         => '(min. 8 characters)',
        'confirm_new_pw'  => 'Confirm new password',

        // Flash
        'profile_updated' => 'Profile updated.',
        'photo_deleted'   => 'Photo deleted.',

        // Errors
        'name_required'   => 'First name and last name are required.',

        // Photo
        'photo_hint'      => 'JPEG, PNG or WebP — max 10 MB',
        'change_image'    => 'Change image',
        'save_photo'      => 'Save photo',
        'delete_photo_confirm' => 'Delete your profile photo?',

        // Integrations
        'change'          => 'Change',
        'gcal_not_connected' => "Events won't sync until connected.",
        'gcal_disconnect_confirm' => 'Disconnect Google Calendar?',

        // Password popup
        'pw_too_short'    => 'At least 8 characters.',
        'pw_no_match'     => 'Passwords do not match.',
        'password_updated'=> 'Password updated.',

        // Generic inline states
        'saving'          => 'Saving…',
        'sending'         => 'Sending…',
        'verifying'       => 'Verifying…',

        // Academic year section
        'academic_year'      => 'Academic year',
        'academic_year_desc' => 'Choose the active year for courses and grades.',
        'academic_year_none' => 'No academic year created yet.',
        'academic_year_manage' => 'Manage years',

        // Google Calendar flash
        'gcal_connected'       => 'Google Calendar connected.',
        'gcal_disconnected'    => 'Google Calendar disconnected.',
        'gcal_oauth_invalid'   => 'Invalid OAuth state. Please try again.',
        'gcal_access_denied'   => 'Google Calendar access denied.',
        'gcal_missing_code'    => 'Missing authorization code.',
    ],

    // ── Revision ─────────────────────────────────────────────────────
    'revision' => [
        'title'           => 'Revision',
        'due_today'       => 'Due today (%d)',
        'nothing_today'   => 'Nothing to revise today. 🎉',
        'upcoming'        => 'Upcoming (%d)',
        'no_upcoming'     => 'No upcoming revisions.',
        'repetition'      => 'Repetition %d/%d',
        'overdue'         => 'overdue',
        'reviewed_next'   => 'Reviewed today — Next:',
        'next_overdue'    => 'Next step is also overdue — click to advance',
        'last_step'       => 'Last step done — marked as mastered',
        'stop_tracking'   => 'Stop tracking this item?',
        'track_new'       => 'Track a new item',
        'item_type'       => 'Item type',
        'chapter'         => 'Chapter',
        'document'        => 'Document',
        'item_label'      => 'Item',
        'select_item'     => 'Select an item…',
        'select_item_err' => 'Please select an item.',
        'start_date'      => 'Start date (J0)',
        'start_date_err'  => 'Please select a start date.',
        'first_rev_hint'  => 'First revision = J0 + first interval days.',
        'interval_sched'  => 'Interval schedule',
        'default_sched'   => 'Default',
        'use_preset'      => 'Use a preset',
        'custom'          => 'Custom',
        'builtin_sched'   => 'Built-in: J+1 → J+3 → J+7 → J+14 → J+30',
        'select_preset'   => 'Select a preset…',
        'custom_hint'     => 'Days from today, comma-separated. Positive integers only.',
        'custom_placeholder'=> 'e.g. 1, 3, 7, 14, 30',
        'add_to_schedule' => 'Add to schedule',
        'edit_session'    => 'Edit session',
        'keep_custom'     => '— keep custom steps —',
        'save_changes'    => 'Save changes',
        'recalc_hint'     => 'Recalculates next revision from scratch (step 1).',
        'apply_preset'    => 'Apply a preset',

        // Flash
        'item_added'        => 'Item added to revision schedule.',
        'session_updated'   => 'Session updated.',
        'session_removed'   => 'Revision session removed.',
        'already_tracked'   => 'This item is already being tracked.',
        'invalid_item'      => 'Please select a valid item.',
        'invalid_intervals' => 'Invalid intervals. Enter positive integers separated by commas (e.g. 1, 3, 7).',
        'invalid_date'      => 'Invalid start date.',
        'invalid_steps'     => 'Add at least one step with a valid day (integer ≥ 0).',
        'preset_not_found'  => 'Preset not found.',
    ],

    // ── Revision settings ─────────────────────────────────────────────
    'revision_settings' => [
        'title'           => 'Revision settings',
        'your_presets'    => 'Your presets',
        'no_presets'      => 'No presets yet. Create one below.',
        'default_badge'   => 'Default',
        'new_preset'      => 'New preset',
        'edit_preset'     => 'Edit preset',
        'preset_name'     => 'Preset name',
        'preset_placeholder' => 'e.g. Standard, Intensive, Light',
        'steps'           => 'Steps',
        'col_day'         => 'Day (J+)',
        'col_action'      => 'Action label (optional)',
        'step_hint'       => 'Day 0 = today, day 1 = tomorrow, etc. Steps are followed in order.',
        'create_preset'   => 'Create preset',
        'save_changes'    => 'Save changes',
        'remove_step'     => 'Remove step',
        'step_placeholder'=> 'e.g. Re-read notes',

        // Errors
        'name_required'   => 'Preset name is required.',
        'name_too_long'   => 'Preset name is too long (max 100 characters).',
        'step_required'   => 'Add at least one step.',
        'step_invalid'    => 'Each step must have a valid day (integer ≥ 0).',
        'min_step'        => 'Add at least one step with a valid day (positive integer).',
        'name_duplicate'  => 'A preset with this name already exists.',

        // Flash
        'preset_created'  => 'Preset created.',
        'preset_updated'  => 'Preset updated.',
        'preset_deleted'  => 'Preset deleted.',

        // Confirm
        'delete_confirm'  => 'Delete preset "%s"? Existing sessions are not affected.',
    ],

    // ── Academic year ─────────────────────────────────────────────────
    'academic_year' => [
        'title'            => 'Academic years',
        'new'              => 'New academic year',
        'name_placeholder' => 'e.g. 2024-2025, L1 Law, Terminale…',
        'rename_placeholder'=> 'New name…',
        'active'           => 'Active',
        'set_active'       => 'Set as active',
        'setup_hint'       => 'Please create an academic year to get started.',
        'none'             => 'No academic years yet.',
        'required'         => 'Please create an academic year first.',
        'has_subjects'     => 'This year has subjects attached and cannot be deleted.',
        'name_required'    => 'Please enter a name.',
        'name_too_long'    => 'Name is too long (max 100 characters).',
        'created'          => 'Academic year created.',
        'renamed'          => 'Academic year renamed.',
        'deleted'          => 'Academic year deleted.',
        'switched'         => 'Active year changed.',
        'delete_confirm'   => 'Delete this academic year?',
        'manage'           => 'Manage years',
        'no_year'          => 'No active year',
        'rename_title'     => 'Rename year',
        'new_name'         => 'New name',
        'delete_data_title'  => 'This year contains data',
        'delete_data_warning'=> 'Download your data before deleting. This action is irreversible.',
        'subjects_count'   => '%d subject(s)',
        'themes_count'     => '%d theme(s)',
        'chapters_count'   => '%d chapter(s)',
        'documents_count'  => '%d document(s)',
        'grades_count'     => '%d grade(s)',
        'download_zip'     => 'Download ZIP',
        'confirm_password' => 'Type your password to confirm deletion',
        'wrong_password'   => 'Incorrect password.',
        'force_delete'     => 'Delete permanently',
        'deleting'         => 'Deleting…',
    ],

    // ── Date/time arrays ─────────────────────────────────────────────
    'months' => [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December',
    ],
    'months_short' => [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
    ],
    'days_short' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
];
