<?php
$iconSettings  = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>';
$iconPlus      = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>';
$iconDel       = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16M10 3h4a1 1 0 011 1v3H9V4a1 1 0 011-1z"/></svg>';
$iconEdit      = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.5-6.5a2.121 2.121 0 013 3L12 14l-4 1 1-4z"/></svg>';
$iconCheckFill = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
$iconClose     = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
$iconArrow     = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>';
$iconChapter   = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>';
$iconDocument  = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';

// Build JSON data for JS dropdowns
$chaptersJson  = json_encode($chapters);
$documentsJson = json_encode($documents);
$presetsJson   = json_encode($presets);
?>
<style>
    .rev-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; gap: 1rem; }
    .rev-header h1 { font-size: 1.4rem; font-weight: 700; color: var(--text); }
    .rev-header-actions { display: flex; gap: .5rem; align-items: center; }

    .btn-sm { padding: .35rem .75rem; font-size: .8rem; }
    .btn-danger { background: transparent; color: #dc2626; border: 1px solid #fca5a5; }
    .btn-danger:hover { background: #fee2e2; }
    .btn-icon-primary { background: #6366f1; color: #fff; border-color: #6366f1; }
    .btn-icon-primary:hover { background: #4f46e5; border-color: #4f46e5; }
    .btn-icon-settings { background: var(--border-soft); color: var(--text); border-color: var(--border-soft); }
    .btn-icon-settings:hover { background: var(--text-subtle); }

    .section-title { font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--text-subtle); margin-bottom: .75rem; }

    .rev-card { background: var(--surface); border-radius: 8px; box-shadow: 0 1px 6px rgba(0,0,0,.07); padding: 1rem 1.25rem; display: flex; align-items: center; gap: 1rem; margin-bottom: .6rem; }
    .rev-card-body { flex: 1; min-width: 0; }
    .rev-card-name { font-size: .925rem; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .rev-card-meta { font-size: .78rem; color: var(--text-subtle); margin-top: .15rem; }
    .rev-card-actions { display: flex; gap: .4rem; flex-shrink: 0; }
    .badge { display: inline-block; padding: .2rem .55rem; border-radius: 99px; font-size: .72rem; font-weight: 700; }
    .badge-interval { background: var(--purple-tint-2); color: #6d28d9; }
    .badge-type { background: var(--bg-subtle); color: var(--text-muted); }

    .btn-advance { display: inline-flex; align-items: center; justify-content: center; width: 20px; height: 20px; border-radius: 4px; border: 1px solid #fca5a5; background: transparent; color: #dc2626; cursor: pointer; vertical-align: middle; padding: 0; flex-shrink: 0; }
    .btn-advance:hover { background: #fee2e2; }
    .upcoming-list { background: var(--surface); border-radius: 8px; box-shadow: 0 1px 6px rgba(0,0,0,.07); overflow: hidden; }
    .upcoming-row { display: flex; align-items: center; gap: .75rem; padding: .7rem 1.25rem; border-bottom: 1px solid var(--bg-subtle); font-size: .875rem; }
    .upcoming-row:last-child { border-bottom: none; }
    .upcoming-name { flex: 1; color: var(--text); font-weight: 500; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .upcoming-date { font-size: .78rem; color: var(--text-subtle); flex-shrink: 0; }

    .add-panel { background: var(--surface); border-radius: 8px; box-shadow: 0 1px 6px rgba(0,0,0,.07); padding: 1.25rem; margin-top: 2rem; display: none; }
    .add-panel.open { display: block; }
    .add-panel h2 { font-size: 1rem; font-weight: 600; margin-bottom: 1.25rem; color: var(--text); }
    .form-row { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem; }
    .form-group { display: flex; flex-direction: column; gap: .35rem; flex: 1; min-width: 160px; }
    .form-group label { font-size: .8rem; font-weight: 600; color: var(--text); }
    .hint { font-size: .75rem; color: var(--text-subtle); margin-top: .2rem; }
    .empty { color: var(--text-subtle); font-size: .875rem; text-align: center; padding: 1.5rem 0; }
    .section { margin-bottom: 2rem; }
    @media (max-width: 640px) {
        .rev-header { flex-wrap: wrap; }
        .rev-card { gap: .5rem; padding: .75rem 1rem; }
        .rev-card-name { white-space: normal; }
        .badge-type { display: none; }
        .upcoming-row { flex-wrap: wrap; gap: .25rem; }
        .form-row { flex-direction: column; }
    }

    /* Custom select */
    .cs-wrap { position: relative; user-select: none; }
    .cs-trigger { display: flex; align-items: center; gap: .6rem; padding: .5rem .75rem; border: 1px solid var(--border-soft); border-radius: 6px; background: var(--input-bg); cursor: pointer; font-size: .875rem; min-height: 2.15rem; }
    .cs-trigger:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.12); }
    .cs-wrap.open .cs-trigger { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.12); }
    .cs-wrap.error .cs-trigger { border-color: #ef4444; }
    .cs-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; background: var(--border-soft); }
    .cs-type-icon { width: 18px; height: 18px; border-radius: 4px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: .7rem; font-weight: 700; background: var(--purple-tint-3); color: #4338ca; }
    .cs-label { flex: 1; color: var(--text); }
    .cs-label.placeholder { color: var(--text-subtle); }
    .cs-arrow { color: var(--text-subtle); font-size: .7rem; transition: transform .15s; flex-shrink: 0; }
    .cs-wrap.open .cs-arrow { transform: rotate(180deg); }
    .cs-dropdown { position: absolute; top: calc(100% + 4px); left: 0; right: 0; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; box-shadow: 0 4px 16px rgba(0,0,0,.1); z-index: 100; max-height: 220px; overflow-y: auto; display: none; }
    .cs-wrap.open .cs-dropdown { display: block; }
    .cs-group { padding: .35rem .75rem .1rem; font-size: .7rem; font-weight: 700; color: var(--text-subtle); text-transform: uppercase; letter-spacing: .06em; border-top: 1px solid var(--bg-subtle); }
    .cs-group:first-child { border-top: none; }
    .cs-option { display: flex; align-items: center; gap: .6rem; padding: .5rem .75rem; cursor: pointer; font-size: .875rem; color: var(--text); }
    .cs-option:hover { background: var(--purple-tint); }
    .cs-option.selected { background: var(--purple-tint-2); font-weight: 600; }

    /* Custom date picker */
    .dp-wrap { position: relative; user-select: none; }
    .dp-trigger { display: flex; align-items: center; gap: .6rem; padding: .5rem .75rem; border: 1px solid var(--border-soft); border-radius: 6px; background: var(--input-bg); cursor: pointer; font-size: .875rem; min-height: 2.15rem; }
    .dp-trigger:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.12); }
    .dp-wrap.open .dp-trigger { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.12); }
    .dp-wrap.error .dp-trigger { border-color: #ef4444; }
    .dp-label { flex: 1; }
    .dp-label.placeholder { color: var(--text-subtle); }
    .dp-arrow { color: var(--text-subtle); font-size: .7rem; }
    .dp-calendar { position: absolute; top: calc(100% + 4px); left: 0; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; box-shadow: 0 4px 16px rgba(0,0,0,.12); z-index: 300; padding: .85rem; display: none; min-width: 240px; }
    .dp-wrap.open .dp-calendar { display: block; }
    .dp-nav { display: flex; align-items: center; justify-content: space-between; margin-bottom: .6rem; }
    .dp-nav-btn { background: var(--bg-subtle); border: none; border-radius: 5px; padding: .25rem .55rem; cursor: pointer; font-size: .95rem; color: var(--text); line-height: 1; }
    .dp-nav-btn:hover { background: var(--border); }
    .dp-month-lbl { font-size: .875rem; font-weight: 700; color: var(--text); }
    .dp-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
    .dp-dow { text-align: center; font-size: .65rem; font-weight: 600; color: var(--text-subtle); padding: .15rem 0; }
    .dp-day { text-align: center; font-size: .78rem; padding: .3rem .1rem; border-radius: 4px; cursor: pointer; color: var(--text); border: none; background: transparent; }
    .dp-day:hover:not(.other-month) { background: var(--purple-tint); }
    .dp-day.today { color: #6366f1; font-weight: 700; }
    .dp-day.selected { background: #6366f1 !important; color: #fff !important; border-radius: 4px; }
    .dp-day.other-month { color: var(--border); cursor: default; }

    /* Toggle checkbox button */
    .rev-toggle { width: 26px; height: 26px; flex-shrink: 0; border-radius: 50%; border: 2px solid var(--border-soft); background: transparent; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; color: transparent; }
    .rev-toggle:hover { border-color: #22c55e; }
    .rev-toggle.checked { background: #dcfce7; border-color: #22c55e; color: #22c55e; }
    html.dark .rev-toggle.checked { background: rgba(34,197,94,.15); border-color: #4ade80; color: #4ade80; }
    .rev-card-reviewed .rev-card-name { text-decoration: line-through; color: var(--text-subtle); }
    .rev-card-next { font-size: .75rem; color: #15803d; margin-top: .25rem; font-weight: 500; }

    /* Steps editor (edit panel) */
    .ep-steps-editor { display: flex; flex-direction: column; gap: .5rem; margin-bottom: .75rem; }
    .ep-step-row { display: flex; align-items: center; gap: .5rem; }
    .ep-step-row .ep-step-index { font-size: .75rem; font-weight: 700; color: var(--text-subtle); width: 1.5rem; text-align: right; flex-shrink: 0; }
    .ep-step-row input[type="number"] { width: 80px; padding: .45rem .6rem; border: 1px solid var(--border-soft); border-radius: 6px; font-size: .875rem; flex-shrink: 0; }
    .ep-step-row input[type="text"]   { flex: 1; padding: .45rem .6rem; border: 1px solid var(--border-soft); border-radius: 6px; font-size: .875rem; }
    .ep-step-header { display: flex; align-items: center; gap: .5rem; font-size: .75rem; font-weight: 600; color: var(--text-subtle); padding-bottom: .25rem; }
    .ep-step-header .col-day { width: 80px; margin-left: 2rem; flex-shrink: 0; }
    .ep-step-header .col-action { flex: 1; }
    .btn-icon-plus { border-style: dashed; border-color: #a5b4fc; color: #6366f1; background: #f5f3ff; }
    .btn-icon-plus:hover { background: #ede9fe; }

    /* Interval mode segmented control */
    .seg-control { display: flex; gap: 0; border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden; width: fit-content; margin-bottom: .75rem; }
    .seg-btn { padding: .4rem .85rem; font-size: .8rem; font-weight: 500; color: #6b7280; background: #fff; border: none; border-right: 1px solid #e5e7eb; cursor: pointer; }
    .seg-btn:last-child { border-right: none; }
    .seg-btn.active { background: #6366f1; color: #fff; }
    .seg-btn:hover:not(.active) { background: #f3f4f6; }
    .seg-panel { display: none; }
    .seg-panel.active { display: block; }
</style>

<div class="rev-header">
    <h1><?= __('revision.title') ?></h1>
    <div class="rev-header-actions">
        <a href="/revision/settings" class="btn-icon btn-icon-settings" title="<?= __('common.settings') ?>"><?= $iconSettings ?></a>
        <button class="btn-icon btn-icon-primary" onclick="toggleAddPanel()" title="<?= __('revision.track_new') ?>"><?= $iconPlus ?></button>
    </div>
</div>

<!-- Due today -->
<div class="section">
    <div class="section-title"><?= sprintf(__('revision.due_today'), count($due)) ?></div>
    <?php if (empty($due)): ?>
        <p class="empty"><?= __('revision.nothing_today') ?></p>
    <?php else: ?>
        <?php
        $today = date('Y-m-d');
        foreach ($due as $r):
            $allSteps     = json_decode($r['intervals'] ?? '[]', true) ?: [];
            $currentIndex = (int) ($r['interval_index'] ?? 0);
            $isReviewed   = ($r['reviewed_today'] ?? '') === $today;
            $totalSteps   = count($allSteps);
            $displayIndex = $isReviewed ? max(0, $currentIndex - 1) : $currentIndex;
            $currentStep  = $allSteps[$displayIndex] ?? ['day' => '?', 'action' => ''];
            $stepLabel    = ($displayIndex + 1) . '/' . $totalSteps;
            $nextIdx      = $isReviewed ? $currentIndex : ($currentIndex + 1);
            $isLast       = $nextIdx >= $totalSteps;
            $nextStep     = !$isLast ? ($allSteps[$nextIdx] ?? null) : null;
            $nextRevDate  = $r['next_revision_date'] ?? '';
        ?>
            <div class="rev-card<?= $isReviewed ? ' rev-card-reviewed' : '' ?>">
                <form method="POST" action="/revision/toggle" style="display:inline-flex;flex-shrink:0;align-items:center;">
                    <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                    <button type="submit" class="rev-toggle<?= $isReviewed ? ' checked' : '' ?>">
                        <?php if ($isReviewed): ?><?= $iconCheckFill ?><?php endif; ?>
                    </button>
                </form>
                <div class="rev-card-body">
                    <div class="rev-card-name"><?= htmlspecialchars($r['item_name'] ?? ($r['item_type'] . ' #' . $r['item_id']), ENT_QUOTES) ?></div>
                    <div class="rev-card-meta">
                        <span class="badge badge-type"><?= htmlspecialchars(ucfirst($r['item_type']), ENT_QUOTES) ?></span>
                        &nbsp;
                        <span class="badge badge-interval">J+<?= htmlspecialchars((string)$currentStep['day'], ENT_QUOTES) ?></span>
                        <?php if (!empty($currentStep['action'])): ?>
                            &nbsp;<span style="color:#374151;font-weight:500;"><?= htmlspecialchars($currentStep['action'], ENT_QUOTES) ?></span>
                        <?php endif; ?>
                        &nbsp;· <?= sprintf(__('revision.repetition'), $displayIndex + 1, $totalSteps) ?>
                        <?php if (!$isReviewed && strtotime($nextRevDate) < strtotime($today)): ?>
                            &nbsp;· <span style="color:#dc2626;"><?= __('revision.overdue') ?> <?= date('d/m', strtotime($nextRevDate)) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($isReviewed && $nextStep): ?>
                        <div class="rev-card-next" style="display:flex;align-items:center;gap:.4rem;flex-wrap:wrap;">
                            <?php if (strtotime($nextRevDate) < strtotime($today)): ?>
                                <span style="color:#dc2626;"><?= __('revision.overdue') ?> <?= date('d/m', strtotime($nextRevDate)) ?> (J+<?= (int)$nextStep['day'] ?>)</span>
                                <form method="POST" action="/revision/done" style="display:inline-flex;align-items:center;">
                                    <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                                    <button type="submit" class="btn-advance" title="<?= htmlspecialchars(__('revision.next_overdue'), ENT_QUOTES) ?>"><?= $iconArrow ?></button>
                                </form>
                            <?php else: ?>
                                <?= __('revision.reviewed_next') ?> <?= date('d/m/Y', strtotime($nextRevDate)) ?> (J+<?= (int)$nextStep['day'] ?>)
                            <?php endif; ?>
                        </div>
                    <?php elseif ($isReviewed && $isLast): ?>
                        <div class="rev-card-next"><?= __('revision.last_step') ?></div>
                    <?php endif; ?>
                </div>
                <div class="rev-card-actions">
                    <button type="button" class="btn-icon btn-edit" title="<?= __('revision.edit_session') ?>"
                        onclick="openEditPanel(<?= (int)$r['id'] ?>, <?= htmlspecialchars(json_encode($r['start_date'] ?? $today), ENT_QUOTES) ?>, <?= htmlspecialchars($r['intervals'] ?? '[]', ENT_QUOTES) ?>)"><?= $iconEdit ?></button>
                    <form method="POST" action="/revision/delete" style="display:inline">
                        <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                        <button type="button" class="btn-icon btn-delete"
                            onclick="esConfirm(MSG_STOP_TRACKING, () => this.closest('form').submit())"><?= $iconDel ?></button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Upcoming -->
<div class="section">
    <div class="section-title"><?= sprintf(__('revision.upcoming'), count($upcoming)) ?></div>
    <?php if (empty($upcoming)): ?>
        <p class="empty"><?= __('revision.no_upcoming') ?></p>
    <?php else: ?>
        <div class="upcoming-list">
            <?php foreach ($upcoming as $r):
                $allSteps     = json_decode($r['intervals'] ?? '[]', true) ?: [];
                $currentIndex = (int) ($r['interval_index'] ?? 0);
                $currentStep  = $allSteps[$currentIndex] ?? ['day' => '?', 'action' => ''];
                $totalSteps   = count($allSteps);
                $stepLabel    = ($currentIndex + 1) . '/' . $totalSteps;
            ?>
                <div class="upcoming-row">
                    <span class="badge badge-type"><?= htmlspecialchars(ucfirst($r['item_type']), ENT_QUOTES) ?></span>
                    <span class="upcoming-name"><?= htmlspecialchars($r['item_name'] ?? ($r['item_type'] . ' #' . $r['item_id']), ENT_QUOTES) ?></span>
                    <span class="badge badge-interval">J+<?= htmlspecialchars((string)$currentStep['day'], ENT_QUOTES) ?></span>
                    <?php if (!empty($currentStep['action'])): ?>
                        <span style="font-size:.8rem;color:#374151;font-weight:500;"><?= htmlspecialchars($currentStep['action'], ENT_QUOTES) ?></span>
                    <?php endif; ?>
                    <span style="font-size:.72rem;color:#9ca3af;"><?= htmlspecialchars($stepLabel, ENT_QUOTES) ?></span>
                    <span class="upcoming-date"><?= date('d/m/Y', strtotime($r['next_revision_date'])) ?></span>
                    <button type="button" class="btn-icon btn-edit" title="<?= __('revision.edit_session') ?>"
                        onclick="openEditPanel(<?= (int)$r['id'] ?>, <?= htmlspecialchars(json_encode($r['start_date'] ?? date('Y-m-d')), ENT_QUOTES) ?>, <?= htmlspecialchars($r['intervals'] ?? '[]', ENT_QUOTES) ?>)"><?= $iconEdit ?></button>
                    <form method="POST" action="/revision/delete" style="margin:0">
                        <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                        <button type="button" class="btn-icon btn-delete"
                            onclick="esConfirm(MSG_STOP_TRACKING, () => this.closest('form').submit())"><?= $iconDel ?></button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Add item panel -->
<div class="add-panel" id="add-panel">
    <h2><?= __('revision.track_new') ?></h2>
    <form method="POST" action="/revision/add" id="add-form">

        <div class="form-row">
            <!-- Item type custom dropdown -->
            <div class="form-group" style="max-width:160px;">
                <label><?= __('revision.item_type') ?></label>
                <input type="hidden" name="item_type" id="item-type-value" value="chapter">
                <div class="cs-wrap" id="cs-type-wrap">
                    <div class="cs-trigger" tabindex="0" id="cs-type-trigger">
                        <span class="cs-type-icon" id="cs-type-icon"><?= $iconChapter ?></span>
                        <span class="cs-label" id="cs-type-label"><?= __('revision.chapter') ?></span>
                        <span class="cs-arrow">▾</span>
                    </div>
                    <div class="cs-dropdown" id="cs-type-dropdown">
                        <div class="cs-option selected" data-value="chapter" data-icon="<?= htmlspecialchars($iconChapter, ENT_QUOTES) ?>" data-label="<?= htmlspecialchars(__('revision.chapter'), ENT_QUOTES) ?>">
                            <span class="cs-type-icon"><?= $iconChapter ?></span> <?= __('revision.chapter') ?>
                        </div>
                        <div class="cs-option" data-value="document" data-icon="<?= htmlspecialchars($iconDocument, ENT_QUOTES) ?>" data-label="<?= htmlspecialchars(__('revision.document'), ENT_QUOTES) ?>">
                            <span class="cs-type-icon"><?= $iconDocument ?></span> <?= __('revision.document') ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item custom dropdown -->
            <div class="form-group">
                <label><?= __('revision.item_label') ?> <span style="color:#ef4444">*</span></label>
                <input type="hidden" name="item_id" id="item-id-value">
                <div class="cs-wrap" id="cs-item-wrap">
                    <div class="cs-trigger" tabindex="0" id="cs-item-trigger">
                        <span class="cs-dot" id="cs-item-dot"></span>
                        <span class="cs-label placeholder" id="cs-item-label"><?= __('revision.select_item') ?></span>
                        <span class="cs-arrow">▾</span>
                    </div>
                    <div class="cs-dropdown" id="cs-item-dropdown"></div>
                </div>
                <span id="add-item-err" style="display:none;font-size:.75rem;color:#ef4444;margin-top:.25rem;"><?= __('revision.select_item_err') ?></span>
            </div>
        </div>

        <!-- Start date (J0) -->
        <div class="form-row">
            <div class="form-group" style="max-width:220px;">
                <label><?= __('revision.start_date') ?> <span style="color:#ef4444">*</span></label>
                <input type="hidden" name="start_date" id="add-start-date-value" value="<?= date('Y-m-d') ?>">
                <div class="dp-wrap" id="add-dp">
                    <div class="dp-trigger" tabindex="0" id="add-dp-trigger">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;color:#9ca3af"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <span class="dp-label" id="add-dp-label"><?= date('d/m/Y') ?></span>
                        <span class="dp-arrow">▾</span>
                    </div>
                    <div class="dp-calendar" id="add-dp-calendar"></div>
                </div>
                <span id="add-dp-err" style="display:none;font-size:.75rem;color:#ef4444;margin-top:.25rem;"><?= __('revision.start_date_err') ?></span>
                <div class="hint"><?= __('revision.first_rev_hint') ?></div>
            </div>
        </div>

        <!-- Interval mode -->
        <div class="form-group" style="margin-bottom:1.25rem;">
            <label><?= __('revision.interval_sched') ?></label>
            <div class="seg-control">
                <button type="button" class="seg-btn active" onclick="setSegMode('default', this)"><?= __('revision.default_sched') ?></button>
                <?php if (!empty($presets)): ?>
                <button type="button" class="seg-btn" onclick="setSegMode('preset', this)"><?= __('revision.use_preset') ?></button>
                <?php endif; ?>
                <button type="button" class="seg-btn" onclick="setSegMode('custom', this)"><?= __('revision.custom') ?></button>
            </div>
            <input type="hidden" name="interval_mode" id="interval-mode-value" value="default">

            <!-- Default info -->
            <div class="seg-panel active" id="seg-default">
                <?php if ($default):
                    $dSteps = json_decode($default['intervals'], true) ?: [];
                    $dSummary = implode(' → ', array_map(fn($s) => 'J+' . $s['day'] . (!empty($s['action']) ? ' (' . $s['action'] . ')' : ''), $dSteps));
                ?>
                    <span style="font-size:.8rem;color:#6b7280;">
                        <strong><?= htmlspecialchars($default['name'], ENT_QUOTES) ?></strong>
                        — <?= htmlspecialchars($dSummary, ENT_QUOTES) ?>
                    </span>
                <?php else: ?>
                    <span style="font-size:.8rem;color:#9ca3af;"><?= __('revision.builtin_sched') ?></span>
                <?php endif; ?>
            </div>

            <!-- Preset dropdown -->
            <?php if (!empty($presets)): ?>
            <div class="seg-panel" id="seg-preset">
                <input type="hidden" name="preset_id" id="preset-id-value" value="">
                <div class="cs-wrap" id="cs-preset-wrap" style="max-width:400px;">
                    <div class="cs-trigger" tabindex="0" id="cs-preset-trigger">
                        <span class="cs-label placeholder" id="cs-preset-label"><?= __('revision.select_preset') ?></span>
                        <span class="cs-arrow">▾</span>
                    </div>
                    <div class="cs-dropdown" id="cs-preset-dropdown">
                        <?php foreach ($presets as $p):
                            $pSteps = json_decode($p['intervals'], true) ?: [];
                            $pSummary = implode(' → ', array_map(fn($s) => 'J+' . $s['day'], $pSteps));
                        ?>
                            <div class="cs-option" data-value="<?= (int)$p['id'] ?>" data-label="<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>" data-summary="<?= htmlspecialchars($pSummary, ENT_QUOTES) ?>">
                                <span style="font-weight:600;"><?= htmlspecialchars($p['name'], ENT_QUOTES) ?></span>
                                <span style="color:#9ca3af;font-size:.78rem;margin-left:.4rem;"><?= htmlspecialchars($pSummary, ENT_QUOTES) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Custom intervals -->
            <div class="seg-panel" id="seg-custom">
                <input type="text" name="custom_intervals" id="custom-intervals" placeholder="<?= htmlspecialchars(__('revision.custom_placeholder'), ENT_QUOTES) ?>"
                    style="max-width:260px;padding:.5rem .75rem;border:1px solid #d1d5db;border-radius:6px;font-size:.875rem;">
                <div class="hint"><?= __('revision.custom_hint') ?></div>
            </div>
        </div>

        <div style="display:flex;gap:.75rem;align-items:center;">
            <button type="submit" class="btn btn-primary btn-sm"><?= __('revision.add_to_schedule') ?></button>
            <button type="button" class="btn btn-ghost btn-sm" onclick="toggleAddPanel()"><?= __('common.cancel') ?></button>
        </div>

    </form>
</div>

<!-- Edit session panel -->
<div class="add-panel" id="edit-panel">
    <h2><?= __('revision.edit_session') ?></h2>
    <form method="POST" action="/revision/edit" id="edit-form">
        <input type="hidden" name="id" id="edit-id">

        <div class="form-row">
            <div class="form-group" style="max-width:220px;">
                <label><?= __('revision.start_date') ?> <span style="color:#ef4444">*</span></label>
                <input type="hidden" name="start_date" id="edit-start-date-value" value="">
                <div class="dp-wrap" id="edit-dp">
                    <div class="dp-trigger" tabindex="0" id="edit-dp-trigger">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;color:#9ca3af"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <span class="dp-label placeholder" id="edit-dp-label"><?= __('revision.start_date') ?></span>
                        <span class="dp-arrow">▾</span>
                    </div>
                    <div class="dp-calendar" id="edit-dp-calendar"></div>
                </div>
                <span id="edit-dp-err" style="display:none;font-size:.75rem;color:#ef4444;margin-top:.25rem;"><?= __('revision.start_date_err') ?></span>
                <div class="hint"><?= __('revision.recalc_hint') ?></div>
            </div>
            <?php if (!empty($presets)): ?>
            <div class="form-group" style="max-width:260px;">
                <label><?= __('revision.apply_preset') ?></label>
                <input type="hidden" name="preset_id" id="edit-preset-id" value="0">
                <div class="cs-wrap" id="edit-preset-wrap">
                    <div class="cs-trigger" tabindex="0" id="edit-preset-trigger">
                        <span class="cs-label placeholder" id="edit-preset-label"><?= __('revision.keep_custom') ?></span>
                        <span class="cs-arrow">▾</span>
                    </div>
                    <div class="cs-dropdown" id="edit-preset-dropdown">
                        <div class="cs-option selected" data-value="0" data-steps=""><?= __('revision.keep_custom') ?></div>
                        <?php foreach ($presets as $ep):
                            $epSteps = json_decode($ep['intervals'], true) ?: [];
                            $epSum   = implode(' · ', array_map(fn($s) => 'J+' . $s['day'], $epSteps));
                        ?>
                        <div class="cs-option"
                             data-value="<?= (int)$ep['id'] ?>"
                             data-steps="<?= htmlspecialchars($ep['intervals'], ENT_QUOTES) ?>">
                            <span style="font-weight:600"><?= htmlspecialchars($ep['name'], ENT_QUOTES) ?></span>
                            <span style="font-size:.75rem;color:#9ca3af;margin-left:.4rem;"><?= htmlspecialchars($epSum, ENT_QUOTES) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label><?= __('revision_settings.steps') ?> <span style="color:#ef4444">*</span></label>
            <input type="hidden" name="interval_mode" id="edit-interval-mode" value="steps">
            <div class="ep-step-header">
                <span class="col-day"><?= __('revision_settings.col_day') ?></span>
                <span class="col-action"><?= __('revision_settings.col_action') ?></span>
            </div>
            <div class="ep-steps-editor" id="ep-steps-editor"></div>
            <button type="button" class="btn-icon btn-icon-plus" style="margin-top:.4rem"
                    onclick="epAddStep()" title="<?= __('common.add') ?>"><?= $iconPlus ?></button>
            <span id="ep-err-steps" style="display:none;font-size:.75rem;color:#ef4444;margin-top:.4rem;display:block"></span>
        </div>

        <div style="display:flex;gap:.75rem;align-items:center;margin-top:1rem;">
            <button type="submit" class="btn btn-primary btn-sm"><?= __('revision.save_changes') ?></button>
            <button type="button" class="btn btn-ghost btn-sm" onclick="closeEditPanel()"><?= __('common.cancel') ?></button>
        </div>
    </form>
</div>

<script>
// Data from PHP
var DATA_CHAPTERS  = <?= $chaptersJson ?>;
var DATA_DOCUMENTS = <?= $documentsJson ?>;
var SVG_EP_CLOSE   = <?= json_encode($iconClose) ?>;
var MSG_STOP_TRACKING   = <?= json_encode(__('revision.stop_tracking')) ?>;
var MSG_SELECT_ITEM     = <?= json_encode(__('revision.select_item')) ?>;
var MSG_SELECT_ITEM_ERR = <?= json_encode(__('revision.select_item_err')) ?>;
var MSG_START_DATE_ERR  = <?= json_encode(__('revision.start_date_err')) ?>;
var MSG_STEP_REQUIRED   = <?= json_encode(__('revision_settings.step_required')) ?>;
var MSG_STEP_INVALID    = <?= json_encode(__('revision_settings.step_invalid')) ?>;
var MSG_KEEP_CUSTOM     = <?= json_encode(__('revision.keep_custom')) ?>;
var STEP_PLACEHOLDER    = <?= json_encode(__('revision_settings.step_placeholder')) ?>;

// ─── Custom select helper ────────────────────────────────────────────
function initCustomSelect(wrapId, triggerId, dropdownId, onSelect) {
    var wrap    = document.getElementById(wrapId);
    var trigger = document.getElementById(triggerId);
    var dropdown = document.getElementById(dropdownId);
    if (!wrap) return;

    trigger.addEventListener('click', function() { wrap.classList.toggle('open'); });
    trigger.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); wrap.classList.toggle('open'); }
        if (e.key === 'Escape') wrap.classList.remove('open');
    });
    document.addEventListener('click', function(e) {
        if (!wrap.contains(e.target)) wrap.classList.remove('open');
    });
    dropdown.addEventListener('click', function(e) {
        var opt = e.target.closest('.cs-option');
        if (!opt) return;
        dropdown.querySelectorAll('.cs-option').forEach(function(o) { o.classList.remove('selected'); });
        opt.classList.add('selected');
        wrap.classList.remove('open');
        if (onSelect) onSelect(opt);
    });
}

// ─── Item type dropdown ──────────────────────────────────────────────
initCustomSelect('cs-type-wrap', 'cs-type-trigger', 'cs-type-dropdown', function(opt) {
    document.getElementById('item-type-value').value = opt.dataset.value;
    document.getElementById('cs-type-label').textContent = opt.dataset.label;
    var icon = document.getElementById('cs-type-icon');
    icon.innerHTML = opt.dataset.icon;
    icon.style.cssText = opt.querySelector('.cs-type-icon').getAttribute('style') || '';
    populateItemDropdown(opt.dataset.value);
});

// ─── Item dropdown ───────────────────────────────────────────────────
function populateItemDropdown(type) {
    var dd      = document.getElementById('cs-item-dropdown');
    var label   = document.getElementById('cs-item-label');
    var dot     = document.getElementById('cs-item-dot');
    var idInput = document.getElementById('item-id-value');

    dd.innerHTML = '';
    label.textContent = MSG_SELECT_ITEM;
    label.classList.add('placeholder');
    dot.style.background = '#d1d5db';
    idInput.value = '';

    var items = type === 'chapter' ? DATA_CHAPTERS : DATA_DOCUMENTS;
    if (!items || items.length === 0) {
        dd.innerHTML = '<div style="padding:.75rem;font-size:.875rem;color:#9ca3af;">No items available</div>';
        return;
    }

    var lastSubject = null;
    items.forEach(function(item) {
        var subject = item.subject_name;
        if (subject !== lastSubject) {
            lastSubject = subject;
            var g = document.createElement('div');
            g.className = 'cs-group';
            g.textContent = subject;
            dd.appendChild(g);
        }
        var name  = type === 'chapter' ? item.chapter_name : item.document_title;
        var color = item.subject_color || '#d1d5db';

        var opt = document.createElement('div');
        opt.className = 'cs-option';
        opt.dataset.value = item.id;
        opt.dataset.color = color;
        opt.dataset.label = name;
        opt.innerHTML = '<span class="cs-dot" style="background:' + color + '"></span>' + escHtml(name);
        dd.appendChild(opt);
    });
}

initCustomSelect('cs-item-wrap', 'cs-item-trigger', 'cs-item-dropdown', function(opt) {
    document.getElementById('item-id-value').value = opt.dataset.value;
    document.getElementById('cs-item-dot').style.background = opt.dataset.color;
    document.getElementById('cs-item-label').textContent = opt.dataset.label;
    document.getElementById('cs-item-label').classList.remove('placeholder');
});

// ─── Preset dropdown ─────────────────────────────────────────────────
initCustomSelect('cs-preset-wrap', 'cs-preset-trigger', 'cs-preset-dropdown', function(opt) {
    document.getElementById('preset-id-value').value = opt.dataset.value;
    var lbl = document.getElementById('cs-preset-label');
    lbl.textContent = opt.dataset.label + ' — ' + opt.dataset.summary;
    lbl.classList.remove('placeholder');
});

// ─── Interval mode segmented control ─────────────────────────────────
function setSegMode(mode, btn) {
    document.querySelectorAll('.seg-btn').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
    document.querySelectorAll('.seg-panel').forEach(function(p) { p.classList.remove('active'); });
    var panel = document.getElementById('seg-' + mode);
    if (panel) panel.classList.add('active');
    document.getElementById('interval-mode-value').value = mode;
}

// ─── Custom date picker ───────────────────────────────────────────────
var MONTHS = <?= json_encode(array_values(__arr('months'))) ?>;
var DOWS   = <?= json_encode(array_values(__arr('days_short'))) ?>;

function createDatePicker(wrapperId, triggerId, calendarId, hiddenId, labelId) {
    var wrap    = document.getElementById(wrapperId);
    var trigger = document.getElementById(triggerId);
    var cal     = document.getElementById(calendarId);
    var hidden  = document.getElementById(hiddenId);
    var label   = document.getElementById(labelId);
    if (!wrap) return null;

    var todayDate = new Date();
    todayDate.setHours(0,0,0,0);

    var cur = hidden.value ? new Date(hidden.value + 'T00:00:00') : new Date(todayDate);
    cur.setHours(0,0,0,0);

    var viewYear  = cur.getFullYear();
    var viewMonth = cur.getMonth();
    var selected  = hidden.value ? new Date(cur) : null;

    function fmt(d) {
        var dd = String(d.getDate()).padStart(2,'0');
        var mm = String(d.getMonth()+1).padStart(2,'0');
        return dd + '/' + mm + '/' + d.getFullYear();
    }
    function fmtISO(d) {
        return d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
    }

    function render() {
        var first = new Date(viewYear, viewMonth, 1);
        var dow   = (first.getDay() + 6) % 7; // 0=Mon
        var days  = new Date(viewYear, viewMonth + 1, 0).getDate();

        var html = '<div class="dp-nav">'
            + '<button type="button" class="dp-nav-btn" onclick="dpNav(\'' + wrapperId + '\',-1)">&#8249;</button>'
            + '<span class="dp-month-lbl">' + MONTHS[viewMonth] + ' ' + viewYear + '</span>'
            + '<button type="button" class="dp-nav-btn" onclick="dpNav(\'' + wrapperId + '\',1)">&#8250;</button>'
            + '</div><div class="dp-grid">';
        DOWS.forEach(function(d){ html += '<div class="dp-dow">' + d + '</div>'; });
        for (var i = 0; i < dow; i++) html += '<div class="dp-day other-month"></div>';
        for (var d = 1; d <= days; d++) {
            var dt = new Date(viewYear, viewMonth, d);
            dt.setHours(0,0,0,0);
            var cls = 'dp-day';
            if (dt.getTime() === todayDate.getTime()) cls += ' today';
            if (selected && dt.getTime() === selected.getTime()) cls += ' selected';
            html += '<div class="' + cls + '" onclick="dpSelect(\'' + wrapperId + '\',' + viewYear + ',' + viewMonth + ',' + d + ')">' + d + '</div>';
        }
        html += '</div>';
        cal.innerHTML = html;
    }

    function open() { wrap.classList.add('open'); render(); }
    function close() { wrap.classList.remove('open'); }

    trigger.addEventListener('click', function(e) { e.stopPropagation(); wrap.classList.contains('open') ? close() : open(); });
    trigger.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); wrap.classList.contains('open') ? close() : open(); }
        if (e.key === 'Escape') close();
    });
    document.addEventListener('click', function(e) { if (!wrap.contains(e.target)) close(); });

    return {
        getYear: function() { return viewYear; },
        getMonth: function() { return viewMonth; },
        setNav: function(y, m) { viewYear = y; viewMonth = m; render(); },
        setSelected: function(y, m, d) {
            selected = new Date(y, m, d);
            selected.setHours(0,0,0,0);
            hidden.value = fmtISO(selected);
            label.textContent = fmt(selected);
            label.classList.remove('placeholder');
            wrap.classList.remove('error');
            close();
        },
        getValue: function() { return hidden.value; },
        setDate: function(iso) {
            if (!iso) { selected = null; hidden.value = ''; label.textContent = MSG_SELECT_ITEM; label.classList.add('placeholder'); return; }
            selected = new Date(iso + 'T00:00:00');
            selected.setHours(0,0,0,0);
            viewYear  = selected.getFullYear();
            viewMonth = selected.getMonth();
            hidden.value = iso;
            label.textContent = fmt(selected);
            label.classList.remove('placeholder');
        }
    };
}

var dpInstances = {};

function dpNav(id, dir) {
    var dp = dpInstances[id];
    if (!dp) return;
    var m = dp.getMonth() + dir;
    var y = dp.getYear();
    if (m < 0) { m = 11; y--; }
    if (m > 11) { m = 0; y++; }
    dp.setNav(y, m);
}

function dpSelect(id, y, m, d) {
    var dp = dpInstances[id];
    if (dp) dp.setSelected(y, m, d);
}

dpInstances['add-dp'] = createDatePicker('add-dp','add-dp-trigger','add-dp-calendar','add-start-date-value','add-dp-label');
dpInstances['edit-dp'] = createDatePicker('edit-dp','edit-dp-trigger','edit-dp-calendar','edit-start-date-value','edit-dp-label');

// ─── Add panel toggle ─────────────────────────────────────────────────
function toggleAddPanel() {
    var p = document.getElementById('add-panel');
    closeEditPanel();
    p.classList.toggle('open');
    if (p.classList.contains('open')) {
        populateItemDropdown('chapter');
        p.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// ─── Edit session panel ───────────────────────────────────────────────
function epAddStep(day, action) {
    var editor = document.getElementById('ep-steps-editor');
    var idx    = editor.children.length;
    var row    = document.createElement('div');
    row.className = 'ep-step-row';
    row.innerHTML =
        '<span class="ep-step-index">' + (idx + 1) + '</span>' +
        '<input type="number" name="steps[' + idx + '][day]" min="0" placeholder="Day" value="' + (day !== undefined ? day : '') + '">' +
        '<input type="text" name="steps[' + idx + '][action]" placeholder="' + escHtml(STEP_PLACEHOLDER) + '" value="' + (action !== undefined ? escHtml(action) : '') + '">' +
        '<button type="button" class="btn-icon btn-delete" onclick="epRemoveStep(this)" title="Remove" style="width:26px;height:26px;">' + SVG_EP_CLOSE + '</button>';
    editor.appendChild(row);
    epReindex();
}

function epRemoveStep(btn) {
    btn.closest('.ep-step-row').remove();
    epReindex();
}

function epReindex() {
    document.querySelectorAll('#ep-steps-editor .ep-step-row').forEach(function(row, i) {
        row.querySelector('.ep-step-index').textContent = i + 1;
        row.querySelector('input[type="number"]').name = 'steps[' + i + '][day]';
        row.querySelector('input[type="text"]').name   = 'steps[' + i + '][action]';
    });
}

// ─── Edit preset custom dropdown ─────────────────────────────────────
(function() {
    var wrap = document.getElementById('edit-preset-wrap');
    if (!wrap) return;
    var trigger  = document.getElementById('edit-preset-trigger');
    var label    = document.getElementById('edit-preset-label');
    var hidden   = document.getElementById('edit-preset-id');
    var modeEl   = document.getElementById('edit-interval-mode');
    var options  = wrap.querySelectorAll('.cs-option');

    function close() { wrap.classList.remove('open'); }
    trigger.addEventListener('click', function() { wrap.classList.toggle('open'); });
    trigger.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); wrap.classList.toggle('open'); }
        if (e.key === 'Escape') close();
    });
    document.addEventListener('click', function(e) { if (!wrap.contains(e.target)) close(); });

    options.forEach(function(opt) {
        opt.addEventListener('click', function() {
            var val   = opt.dataset.value;
            var steps = opt.dataset.steps ? JSON.parse(opt.dataset.steps) : [];
            hidden.value = val;
            label.textContent = opt.textContent.trim();
            label.classList.toggle('placeholder', val === '0');
            options.forEach(function(o) { o.classList.toggle('selected', o === opt); });
            if (val === '0') {
                modeEl.value = 'steps';
            } else {
                modeEl.value = 'preset';
                document.getElementById('ep-steps-editor').innerHTML = '';
                steps.forEach(function(s) { epAddStep(s.day, s.action || ''); });
            }
            close();
        });
    });
})();

function resetEditPresetDropdown() {
    var wrap = document.getElementById('edit-preset-wrap');
    if (!wrap) return;
    var hidden = document.getElementById('edit-preset-id');
    var label  = document.getElementById('edit-preset-label');
    var modeEl = document.getElementById('edit-interval-mode');
    hidden.value = '0';
    modeEl.value = 'steps';
    label.textContent = MSG_KEEP_CUSTOM;
    label.classList.add('placeholder');
    wrap.querySelectorAll('.cs-option').forEach(function(o) {
        o.classList.toggle('selected', o.dataset.value === '0');
    });
}

function openEditPanel(id, startDate, intervalsJson) {
    var steps = typeof intervalsJson === 'string' ? JSON.parse(intervalsJson) : intervalsJson;
    document.getElementById('add-panel').classList.remove('open');
    document.getElementById('edit-id').value = id;
    if (dpInstances['edit-dp']) dpInstances['edit-dp'].setDate(startDate || '<?= date('Y-m-d') ?>');
    resetEditPresetDropdown();
    document.getElementById('ep-steps-editor').innerHTML = '';
    steps.forEach(function(s) { epAddStep(s.day, s.action || ''); });
    document.getElementById('edit-dp-err').style.display = 'none';
    var panel = document.getElementById('edit-panel');
    panel.classList.add('open');
    panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function closeEditPanel() {
    var panel = document.getElementById('edit-panel');
    panel.classList.remove('open');
    document.getElementById('ep-steps-editor').innerHTML = '';
}

document.getElementById('add-form').addEventListener('submit', function(e) {
    var blocked = false;

    var itemVal = document.getElementById('item-id-value').value.trim();
    var itemErrEl = document.getElementById('add-item-err');
    var itemWrap = document.getElementById('cs-item-wrap');
    if (!itemVal) {
        itemErrEl.style.display = 'block';
        itemWrap.classList.add('error');
        blocked = true;
    } else {
        itemErrEl.style.display = 'none';
        itemWrap.classList.remove('error');
    }

    var dateVal = document.getElementById('add-start-date-value').value.trim();
    var dateErrEl = document.getElementById('add-dp-err');
    var dateWrap = document.getElementById('add-dp');
    if (!dateVal) {
        dateErrEl.textContent = MSG_START_DATE_ERR;
        dateErrEl.style.display = 'block';
        dateWrap.classList.add('error');
        blocked = true;
    } else {
        dateErrEl.style.display = 'none';
        dateWrap.classList.remove('error');
    }

    if (blocked) e.preventDefault();
});

document.getElementById('edit-form').addEventListener('submit', function(e) {
    var dateVal = document.getElementById('edit-start-date-value').value.trim();
    var dateErrEl = document.getElementById('edit-dp-err');
    var wrap = document.getElementById('edit-dp');
    if (!dateVal) {
        dateErrEl.textContent = MSG_START_DATE_ERR;
        dateErrEl.style.display = 'block';
        wrap.classList.add('error');
        e.preventDefault();
        return;
    } else {
        dateErrEl.style.display = 'none';
        wrap.classList.remove('error');
    }

    var modeVal = document.getElementById('edit-interval-mode').value;
    var errEl = document.getElementById('ep-err-steps');
    if (modeVal === 'preset') {
        errEl.style.display = 'none';
        return;
    }
    var rows = document.querySelectorAll('#ep-steps-editor .ep-step-row');
    if (rows.length === 0) {
        errEl.textContent = MSG_STEP_REQUIRED;
        errEl.style.display = 'block';
        e.preventDefault();
        return;
    }
    var invalid = false;
    rows.forEach(function(row) {
        var inp = row.querySelector('input[type="number"]');
        if (inp.value.trim() === '' || parseInt(inp.value) < 0) {
            inp.style.borderColor = '#ef4444';
            invalid = true;
        } else {
            inp.style.borderColor = '';
        }
    });
    if (invalid) {
        errEl.textContent = MSG_STEP_INVALID;
        errEl.style.display = 'block';
        e.preventDefault();
    } else {
        errEl.style.display = 'none';
    }
});

function escHtml(s) {
    return String(s).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
</script>
