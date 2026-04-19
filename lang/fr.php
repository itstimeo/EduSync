<?php

return [

    // ── Navigation ────────────────────────────────────────────────────
    'nav' => [
        'courses'  => 'Cours',
        'grades'   => 'Notes',
        'planning' => 'Planning',
        'revision' => 'Révision',
        'profile'  => 'Profil',
    ],

    // ── Confirmation modal ────────────────────────────────────────────
    'modal' => [
        'cancel' => 'Annuler',
        'delete' => 'Supprimer',
    ],

    // ── Common ────────────────────────────────────────────────────────
    'common' => [
        'save'         => 'Enregistrer',
        'cancel'       => 'Annuler',
        'delete'       => 'Supprimer',
        'edit'         => 'Modifier',
        'back'         => 'Retour',
        'add'          => 'Ajouter',
        'name'         => 'Nom',
        'color'        => 'Couleur',
        'required'     => 'Obligatoire',
        'optional'     => 'facultatif',
        'description'  => 'Description',
        'title'        => 'Titre',
        'date'         => 'Date',
        'export'       => 'Exporter',
        'export_pdf'   => 'Exporter PDF',
        'settings'     => 'Paramètres',
        'new'          => 'Nouveau',
        'no_items'     => 'Rien ici pour l\'instant.',
        'error'        => 'Erreur.',
        'rename'       => 'Renommer',
        'create'       => 'Créer',
    ],

    // ── Auth ──────────────────────────────────────────────────────────
    'auth' => [
        'login' => [
            'title'       => 'Connexion à EduSync',
            'subtitle'    => 'Bon retour parmi nous',
            'email'       => 'Adresse e-mail',
            'password'    => 'Mot de passe',
            'remember'    => 'Se souvenir de moi',
            'submit'      => 'Se connecter',
            'no_account'  => 'Pas encore de compte ?',
            'register'    => 'Créer un compte',
        ],
        'register' => [
            'title'       => 'Créer votre compte',
            'subtitle'    => 'Commencez à organiser vos études',
            'first_name'  => 'Prénom',
            'last_name'   => 'Nom',
            'email'       => 'Adresse e-mail',
            'password'    => 'Mot de passe',
            'confirm'     => 'Confirmer le mot de passe',
            'submit'      => 'Créer le compte',
            'has_account' => 'Déjà un compte ?',
            'login'       => 'Se connecter',
        ],
        'verify_email' => [
            'title'    => 'Vérifiez votre e-mail',
            'subtitle' => 'Saisissez le code à 6 chiffres envoyé à votre adresse e-mail.',
            'code'     => 'Code de vérification',
            'submit'   => 'Vérifier',
        ],
        'verify_ip' => [
            'title'    => 'Nouvel appareil détecté',
            'subtitle' => 'Saisissez le code à 6 chiffres envoyé par e-mail pour confirmer cet appareil.',
            'code'     => 'Code de sécurité',
            'submit'   => 'Confirmer l\'appareil',
        ],
        'errors' => [
            'email_password_required' => 'L\'e-mail et le mot de passe sont obligatoires.',
            'all_fields_required'     => 'Tous les champs sont obligatoires.',
            'passwords_no_match'      => 'Les mots de passe ne correspondent pas.',
            'code_required'           => 'Le code de vérification est obligatoire.',
        ],
    ],

    // ── Dashboard ─────────────────────────────────────────────────────
    'dashboard' => [
        'title'               => 'Tableau de bord',
        'recent_grades'       => 'Notes récentes',
        'overall_average'     => 'Moyenne générale',
        'this_week'           => 'Événements cette semaine',
        'no_events'           => 'Aucun événement cette semaine.',
        'todays_revisions'    => 'Révisions du jour',
        'nothing_to_revise'   => 'Rien à réviser aujourd\'hui.',
        'last_step_mastered'  => 'Dernière étape validée — maîtrisé',
        'mark_done'           => 'Terminé',
        'no_grades'           => 'Aucune note pour l\'instant.',
    ],

    // ── Courses ───────────────────────────────────────────────────────
    'courses' => [
        'title'           => 'Mes matières',
        'no_subjects'     => 'Aucune matière pour l\'instant...',
        'no_themes'       => 'Aucun thème pour l\'instant.',
        'no_chapters'     => 'Aucun chapitre pour l\'instant.',
        'no_documents'    => 'Aucun document pour l\'instant.',
        'export_all'      => 'Tout exporter',
        'export'          => 'Exporter',
        'write'           => '✎ Rédiger',
        'upload'          => '+ Importer',
        'new_subject'     => '+ Nouvelle matière',
        'new_theme'       => '+ Nouveau thème',
        'new_chapter'     => '+ Nouveau chapitre',
        'subjects'        => 'Matières',
        'themes'          => 'Thèmes',
        'chapters'        => 'Chapitres',
        'documents'       => 'Documents',

        // Subject form
        'subject_name'    => 'Nom de la matière',
        'new_subject_title'  => 'Nouvelle matière',
        'edit_subject_title' => 'Modifier la matière',

        // Theme form
        'theme_name'      => 'Nom du thème',
        'new_theme_title'  => 'Nouveau thème',
        'edit_theme_title' => 'Modifier le thème',

        // Chapter form
        'chapter_name'    => 'Nom du chapitre',
        'new_chapter_title'  => 'Nouveau chapitre',
        'edit_chapter_title' => 'Modifier le chapitre',

        // Document upload
        'upload_title'    => 'Importer un document',
        'doc_title'       => 'Titre',
        'choose_file'     => 'Choisir un fichier',
        'no_file_chosen'  => 'Aucun fichier choisi',
        'file_hint'       => 'PDF, DOCX, image — max 50 Mo',
        'edit_doc_title'  => 'Modifier le document',
        'replace_file'    => 'Remplacer le fichier',
        'current_file'    => 'Actuel',
        'keep_file_hint'  => 'Laissez vide pour conserver le fichier actuel.',

        // Document view
        'download'        => 'Télécharger',
        'no_preview'      => 'Aperçu non disponible pour ce type de fichier.',

        // Note editor
        'new_note_title'  => 'Nouvelle note',
        'edit_note_title' => 'Modifier la note',
        'create_note'     => 'Créer la note',
        'note_placeholder' => 'Commencez à rédiger votre note…',

        // Errors
        'name_required'     => 'Veuillez saisir un nom.',
        'title_required'    => 'Le titre est obligatoire.',
        'file_required'     => 'Veuillez sélectionner un fichier.',
        'file_too_large'    => 'Fichier trop volumineux. Maximum autorisé : 50 Mo.',
        'no_docs_to_export' => 'Aucun document à exporter.',
        'no_grades_export'  => 'Aucune note à exporter.',

        // Flash
        'subject_created' => 'Matière créée.',
        'subject_updated' => 'Matière mise à jour.',
        'subject_deleted' => 'Matière supprimée.',
        'theme_created'   => 'Thème créé.',
        'theme_updated'   => 'Thème mis à jour.',
        'theme_deleted'   => 'Thème supprimé.',
        'chapter_created' => 'Chapitre créé.',
        'chapter_updated' => 'Chapitre mis à jour.',
        'chapter_deleted' => 'Chapitre supprimé.',
        'doc_uploaded'    => 'Document importé.',
        'doc_updated'     => 'Document mis à jour.',
        'doc_deleted'     => 'Document supprimé.',
        'note_created'    => 'Note créée.',
        'note_saved'      => 'Note enregistrée.',
        'invalid_subject' => 'Matière invalide.',

        // Confirm
        'delete_confirm'  => 'Supprimer «%s» ?',
    ],

    // ── Grades ────────────────────────────────────────────────────────
    'grades' => [
        'title'           => 'Notes',
        'new_grade'       => '+ Nouvelle note',
        'export_pdf'      => 'Exporter PDF',
        'overall_average' => 'Moyenne générale',
        'by_subject'      => 'Par matière',
        'chronological'   => 'Chronologique',
        'statistics'      => 'Statistiques',
        'no_grades'       => 'Aucune note pour l\'instant.',
        'avg'             => 'Moy :',
        'overall_avg'     => 'Moyenne générale',
        'avg_progression' => 'Évolution de la moyenne',
        'add_dates_hint'  => 'Ajoutez des dates à vos notes pour voir les tendances.',
        'page_of'         => 'Page %d sur %d',

        // Form
        'subject'     => 'Matière',
        'grade_name'  => 'Nom de la note',
        'value'       => 'Note',
        'out_of'      => 'Sur',
        'coefficient' => 'Coefficient',
        'comment'     => 'Commentaire',
        'select_subj' => '— sélectionner —',
        'new_title'   => 'Nouvelle note',
        'edit_title'  => 'Modifier la note',

        // Errors
        'name_required'       => 'Le nom de la note est obligatoire.',
        'name_too_long'       => 'Le nom est trop long (max 200 caractères).',
        'subject_required'    => 'Veuillez sélectionner une matière.',
        'value_negative'      => 'La note ne peut pas être négative.',
        'max_value_zero'      => 'La note maximale doit être supérieure à 0.',
        'value_exceeds_max'   => 'La note ne peut pas dépasser la note maximale.',
        'coefficient_zero'    => 'Le coefficient doit être supérieur à 0.',
        'invalid_subject'     => 'Matière invalide.',

        // Flash
        'grade_added'   => 'Note ajoutée.',
        'grade_updated' => 'Note mise à jour.',
        'grade_deleted' => 'Note supprimée.',

        // Confirm
        'delete_confirm' => 'Supprimer cette note ?',
    ],

    // ── Planning ──────────────────────────────────────────────────────
    'planning' => [
        'title'        => 'Planning',
        'new_event'    => '+ Nouvel événement',
        'calendar'     => 'Calendrier',
        'list'         => 'Liste',
        'no_events'    => 'Aucun événement ce mois-ci.',
        'no_day_events' => 'Aucun événement ce jour.',
        'more'         => '+%d de plus',
        'settings'     => 'Paramètres',

        // Event form
        'new_event_title'  => 'Nouvel événement',
        'edit_event_title' => 'Modifier l\'événement',
        'event_title'      => 'Titre',
        'type'             => 'Type',
        'color'            => 'Couleur',
        'start_date'       => 'Date de début',
        'end_date'         => 'Date de fin',
        'end_date_opt'     => '(facultatif)',
        'description'      => 'Description',
        'description_opt'  => '(facultatif)',
        'save'             => 'Enregistrer',
        'delete'           => 'Supprimer',

        // Errors
        'title_required'      => 'Le titre est obligatoire.',
        'title_too_long'      => 'Le titre est trop long (max 200 caractères).',
        'start_date_required' => 'Veuillez sélectionner une date de début.',
        'end_date_invalid'    => 'La date de fin doit être égale ou postérieure à la date de début.',

        // Settings
        'settings_title'     => 'Types d\'événements',
        'settings_subtitle'  => 'Gérez vos types d\'événements et leurs couleurs.',
        'add_type'           => 'Ajouter un type',
        'type_placeholder'   => 'Nom du type (ex. Travaux pratiques)',
        'type_name_required' => 'Veuillez saisir un nom de type.',

        // Flash
        'event_created'  => 'Événement créé.',
        'event_updated'  => 'Événement mis à jour.',
        'event_deleted'  => 'Événement supprimé.',
        'type_added'     => 'Type ajouté.',
        'type_deleted'   => 'Type supprimé.',
        'settings_saved' => 'Paramètres enregistrés.',
        'type_name_error'=> 'Le nom du type est obligatoire (max 50 caractères).',

        // Confirm
        'delete_confirm'      => 'Supprimer «%s» ?',
        'delete_type_confirm' => 'Supprimer le type «%s» ?',
    ],

    // ── Profile ───────────────────────────────────────────────────────
    'profile' => [
        'title'          => 'Profil',
        'informations'   => 'Informations',
        'first_name'     => 'Prénom',
        'last_name'      => 'Nom',
        'save'           => 'Enregistrer',
        'photo'          => 'Photo de profil',
        'upload_photo'   => 'Importer une photo',
        'delete_photo'   => 'Supprimer la photo',
        'security'       => 'Sécurité',
        'email_address'  => 'Adresse e-mail',
        'change_email'   => 'Changer l\'e-mail',
        'password'       => 'Mot de passe',
        'change_password'=> 'Changer le mot de passe',
        'integrations'   => 'Intégrations',
        'gcal_title'     => 'Synchroniser avec Google Agenda',
        'gcal_desc'      => 'Vos événements de planning seront automatiquement envoyés vers Google Agenda lors de leur création, modification ou suppression.',
        'connected'      => '● Connecté',
        'disconnected'   => '● Déconnecté',
        'connect'        => 'Connecter',
        'disconnect'     => 'Déconnecter',
        'language'       => 'Langue',
        'language_desc'  => "Choisissez la langue de l'interface.",
        'session'        => 'Session',
        'logout'         => 'Se déconnecter',
        'logout_desc'    => 'Terminer votre session sur cet appareil.',
        'logout_confirm' => 'Se déconnecter d\'EduSync ?',

        // Email change popup
        'email_popup_title'   => 'Changer l\'adresse e-mail',
        'current_email'       => 'E-mail actuel',
        'new_email'           => 'Nouvel e-mail',
        'send_codes'          => 'Envoyer les codes',
        'codes_sent'          => 'Les codes ont été envoyés aux deux adresses. Saisissez-les ci-dessous.',
        'code_old_email'      => 'Code envoyé à l\'e-mail actuel',
        'code_new_email'      => 'Code envoyé au nouvel e-mail',
        'confirm'             => 'Confirmer',

        // Password change popup
        'pw_popup_title'  => 'Changer le mot de passe',
        'current_password'=> 'Mot de passe actuel',
        'new_password'    => 'Nouveau mot de passe',
        'pw_hint'         => '(min. 8 caractères)',
        'confirm_new_pw'  => 'Confirmer le nouveau mot de passe',

        // Flash
        'profile_updated' => 'Profil mis à jour.',
        'photo_deleted'   => 'Photo supprimée.',

        // Errors
        'name_required'   => 'Le prénom et le nom sont obligatoires.',

        // Photo
        'photo_hint'      => 'JPEG, PNG ou WebP — max 10 Mo',
        'change_image'    => "Changer l'image",
        'save_photo'      => 'Enregistrer la photo',
        'delete_photo_confirm' => 'Supprimer votre photo de profil ?',

        // Integrations
        'change'          => 'Modifier',
        'gcal_not_connected' => "Les événements ne seront pas synchronisés tant que vous n'êtes pas connecté.",
        'gcal_disconnect_confirm' => 'Déconnecter Google Agenda ?',

        // Password popup
        'pw_too_short'    => 'Au moins 8 caractères.',
        'pw_no_match'     => 'Les mots de passe ne correspondent pas.',
        'password_updated'=> 'Mot de passe mis à jour.',

        // Generic inline states
        'saving'          => 'Enregistrement…',
        'sending'         => 'Envoi en cours…',
        'verifying'       => 'Vérification…',

        // Academic year section
        'academic_year'      => 'Année scolaire',
        'academic_year_desc' => 'Choisissez l\'année active pour les cours et les notes.',
        'academic_year_none' => 'Aucune année scolaire créée pour l\'instant.',
        'academic_year_manage' => 'Gérer les années',

        // Google Calendar flash
        'gcal_connected'       => 'Google Agenda connecté.',
        'gcal_disconnected'    => 'Google Agenda déconnecté.',
        'gcal_oauth_invalid'   => 'État OAuth invalide. Veuillez réessayer.',
        'gcal_access_denied'   => 'Accès à Google Agenda refusé.',
        'gcal_missing_code'    => 'Code d\'autorisation manquant.',
    ],

    // ── Revision ─────────────────────────────────────────────────────
    'revision' => [
        'title'           => 'Révision',
        'due_today'       => 'À réviser aujourd\'hui (%d)',
        'nothing_today'   => 'Rien à réviser aujourd\'hui. 🎉',
        'upcoming'        => 'À venir (%d)',
        'no_upcoming'     => 'Aucune révision à venir.',
        'repetition'      => 'Répétition %d/%d',
        'overdue'         => 'en retard',
        'reviewed_next'   => 'Révisé aujourd\'hui — Prochain :',
        'next_overdue'    => 'L\'étape suivante est aussi en retard — cliquer pour avancer',
        'last_step'       => 'Dernière étape validée — maîtrisé',
        'stop_tracking'   => 'Arrêter le suivi de cet élément ?',
        'track_new'       => 'Suivre un nouvel élément',
        'item_type'       => 'Type d\'élément',
        'chapter'         => 'Chapitre',
        'document'        => 'Document',
        'item_label'      => 'Élément',
        'select_item'     => 'Sélectionner un élément…',
        'select_item_err' => 'Veuillez sélectionner un élément.',
        'start_date'      => 'Date de départ (J0)',
        'start_date_err'  => 'Veuillez sélectionner une date de départ.',
        'first_rev_hint'  => 'Première révision = J0 + premier intervalle.',
        'interval_sched'  => 'Planning des intervalles',
        'default_sched'   => 'Par défaut',
        'use_preset'      => 'Utiliser un préréglage',
        'custom'          => 'Personnalisé',
        'builtin_sched'   => 'Intégré : J+1 → J+3 → J+7 → J+14 → J+30',
        'select_preset'   => 'Sélectionner un préréglage…',
        'custom_hint'     => 'Jours depuis aujourd\'hui, séparés par des virgules. Entiers positifs uniquement.',
        'custom_placeholder'=> 'ex. 1, 3, 7, 14, 30',
        'add_to_schedule' => 'Ajouter au planning',
        'edit_session'    => 'Modifier la session',
        'keep_custom'     => '— conserver les étapes personnalisées —',
        'save_changes'    => 'Enregistrer',
        'recalc_hint'     => 'Recalcule la prochaine révision depuis le début (étape 1).',
        'apply_preset'    => 'Appliquer un préréglage',

        // Flash
        'item_added'        => 'Élément ajouté au planning de révision.',
        'session_updated'   => 'Session mise à jour.',
        'session_removed'   => 'Session de révision supprimée.',
        'already_tracked'   => 'Cet élément est déjà suivi.',
        'invalid_item'      => 'Veuillez sélectionner un élément valide.',
        'invalid_intervals' => 'Intervalles invalides. Saisissez des entiers positifs séparés par des virgules (ex. 1, 3, 7).',
        'invalid_date'      => 'Date de départ invalide.',
        'invalid_steps'     => 'Ajoutez au moins une étape avec un jour valide (entier ≥ 0).',
        'preset_not_found'  => 'Préréglage introuvable.',
    ],

    // ── Revision settings ─────────────────────────────────────────────
    'revision_settings' => [
        'title'           => 'Paramètres de révision',
        'your_presets'    => 'Vos préréglages',
        'no_presets'      => 'Aucun préréglage. Créez-en un ci-dessous.',
        'default_badge'   => 'Défaut',
        'new_preset'      => 'Nouveau préréglage',
        'edit_preset'     => 'Modifier le préréglage',
        'preset_name'     => 'Nom du préréglage',
        'preset_placeholder' => 'ex. Standard, Intensif, Léger',
        'steps'           => 'Étapes',
        'col_day'         => 'Jour (J+)',
        'col_action'      => 'Libellé d\'action (facultatif)',
        'step_hint'       => 'Jour 0 = aujourd\'hui, jour 1 = demain, etc. Les étapes sont suivies dans l\'ordre.',
        'create_preset'   => 'Créer le préréglage',
        'save_changes'    => 'Enregistrer',
        'remove_step'     => 'Supprimer l\'étape',
        'step_placeholder'=> 'ex. Relire les notes',

        // Errors
        'name_required'   => 'Le nom du préréglage est obligatoire.',
        'name_too_long'   => 'Le nom est trop long (max 100 caractères).',
        'step_required'   => 'Ajoutez au moins une étape.',
        'step_invalid'    => 'Chaque étape doit avoir un jour valide (entier ≥ 0).',
        'min_step'        => 'Ajoutez au moins une étape avec un jour valide (entier positif).',
        'name_duplicate'  => 'Un préréglage avec ce nom existe déjà.',

        // Flash
        'preset_created'  => 'Préréglage créé.',
        'preset_updated'  => 'Préréglage mis à jour.',
        'preset_deleted'  => 'Préréglage supprimé.',

        // Confirm
        'delete_confirm'  => 'Supprimer le préréglage «%s» ? Les sessions existantes ne sont pas affectées.',
    ],

    // ── Academic year ─────────────────────────────────────────────────
    'academic_year' => [
        'title'            => 'Années scolaires',
        'new'              => 'Nouvelle année scolaire',
        'name_placeholder' => 'ex. 2024-2025, L1 Droit, Terminale…',
        'rename_placeholder'=> 'Nouveau nom…',
        'active'           => 'Active',
        'set_active'       => 'Définir comme active',
        'setup_hint'       => 'Créez une année scolaire pour commencer à utiliser EduSync.',
        'none'             => 'Aucune année scolaire pour l\'instant.',
        'required'         => 'Veuillez d\'abord créer une année scolaire.',
        'has_subjects'     => 'Cette année contient des matières et ne peut pas être supprimée.',
        'name_required'    => 'Veuillez saisir un nom.',
        'name_too_long'    => 'Le nom est trop long (max 100 caractères).',
        'created'          => 'Année scolaire créée.',
        'renamed'          => 'Année scolaire renommée.',
        'deleted'          => 'Année scolaire supprimée.',
        'switched'         => 'Année active changée.',
        'delete_confirm'   => 'Supprimer cette année scolaire ?',
        'manage'           => 'Gérer les années',
        'no_year'          => 'Aucune année active',
        'rename_title'     => 'Renommer l\'année',
        'new_name'         => 'Nouveau nom',
        'delete_data_title'  => 'Cette année contient des données',
        'delete_data_warning'=> 'Téléchargez vos données avant de supprimer. Cette action est irréversible.',
        'subjects_count'   => '%d matière(s)',
        'themes_count'     => '%d thème(s)',
        'chapters_count'   => '%d chapitre(s)',
        'documents_count'  => '%d document(s)',
        'grades_count'     => '%d note(s)',
        'download_zip'     => 'Télécharger le ZIP',
        'confirm_password' => 'Saisissez votre mot de passe pour confirmer la suppression',
        'wrong_password'   => 'Mot de passe incorrect.',
        'force_delete'     => 'Supprimer définitivement',
        'deleting'         => 'Suppression…',
    ],

    // ── Date/time arrays ─────────────────────────────────────────────
    'months' => [
        'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
        'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre',
    ],
    'months_short' => [
        'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun',
        'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc',
    ],
    'days_short' => ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
];
