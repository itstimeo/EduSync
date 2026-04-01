<style>
    .dashboard-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    .card { background: var(--surface); border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.07); padding: 1.5rem; }
    .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
    .card-header h2 { font-size: 1rem; font-weight: 600; color: var(--text); }
    .card-header a.see-all { font-size: .75rem; font-weight: 500; color: #6366f1; text-decoration: none; display: inline-flex; align-items: center; gap: .2rem; opacity: .8; }
    .card-header a.see-all:hover { opacity: 1; }
    .card ul { list-style: none; }
    .card ul li { border-bottom: 1px solid var(--bg-subtle); font-size: .875rem; }
    .card ul li:last-child { border-bottom: none; }
    /* Revision items */
    .rev-item-body { flex: 1; min-width: 0; }
    .rev-item-name { font-weight: 500; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: .875rem; }
    .rev-item-name.reviewed { text-decoration: line-through; color: var(--text-subtle); }
    .rev-item-next { font-size: .72rem; color: #15803d; font-weight: 500; margin-top: .1rem; }
    .rev-toggle-sm { width: 20px; height: 20px; flex-shrink: 0; border-radius: 50%; border: 2px solid var(--border-soft); background: transparent; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; color: transparent; padding: 0; margin-top: 2px; }
    .rev-toggle-sm:hover { border-color: #22c55e; }
    .rev-toggle-sm.checked { background: #dcfce7; border-color: #22c55e; color: #22c55e; }
    html.dark .rev-toggle-sm.checked { background: rgba(34,197,94,.15); border-color: #4ade80; color: #4ade80; }
    .subj-dot-sm { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 5px; }
    .rev-row { display: flex; align-items: flex-start; gap: .5rem; padding: .5rem 0; }
    a.rev-item-link { flex: 1; min-width: 0; text-decoration: none; display: block; }
    /* Grade items */
    .average-row { margin-top: .85rem; padding-top: .75rem; border-top: 2px solid var(--border); display: flex; justify-content: space-between; align-items: baseline; }
    .average-row .label { color: var(--text-muted); font-size: .875rem; font-weight: 600; }
    .average-row .value { font-size: 1.4rem; font-weight: 800; color: #6366f1; }
    .grade-list { display: flex; flex-direction: column; gap: .5rem; }
    a.grade-card { display: flex; align-items: center; border: 1px solid var(--bg-subtle); border-radius: 7px; overflow: hidden; background: var(--bg-hover); text-decoration: none; transition: box-shadow .15s, border-color .15s; }
    a.grade-card:hover { box-shadow: 0 2px 8px rgba(99,102,241,.12); border-color: var(--purple-tint-3); }
    .grade-card-strip { width: 5px; align-self: stretch; flex-shrink: 0; }
    .grade-card-body { flex: 1; padding: .5rem .75rem; min-width: 0; }
    .grade-card-name { font-size: .875rem; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .grade-card-sub { font-size: .75rem; color: var(--text-subtle); margin-top: .05rem; }
    .grade-card-right { display: flex; flex-direction: column; align-items: flex-end; padding: .5rem .75rem; flex-shrink: 0; gap: .1rem; }
    .grade-card-val { font-size: .95rem; font-weight: 700; color: var(--text); }
    .grade-card-max { font-size: .75rem; font-weight: 400; color: var(--text-subtle); }
    .grade-card-date { font-size: .72rem; color: var(--text-subtle); }
    /* Event items */
    a.event-row { display: flex; align-items: flex-start; padding: .5rem 0; text-decoration: none; border-radius: 5px; transition: background .1s; }
    a.event-row:hover { background: var(--bg-hover); }
    .event-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-right: .4rem; margin-top: 4px; }
    .event-content { flex: 1; min-width: 0; }
    .event-name-row { display: flex; align-items: center; gap: .35rem; }
    .event-title { font-weight: 600; font-size: .875rem; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1; }
    .event-date { font-size: .75rem; color: var(--text-subtle); white-space: nowrap; flex-shrink: 0; }
    .event-type-label { font-size: .72rem; color: var(--text-subtle); margin-top: .1rem; padding-left: 12px; }
    .empty { color: var(--text-subtle); font-size: .875rem; text-align: center; padding: 1rem 0; }
    .btn-see-all { display: inline-flex; align-items: center; gap: .2rem; font-size: .75rem; font-weight: 500; color: #6366f1; text-decoration: none; opacity: .85; }
    .btn-see-all:hover { opacity: 1; }
    @media (max-width: 900px) { .dashboard-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .dashboard-grid { grid-template-columns: 1fr; } }
</style>

<div class="dashboard-grid">

    <!-- Notes récentes -->
    <div class="card">
        <div class="card-header">
            <h2>Recent grades</h2>
            <?php if (!empty($grades)): ?>
                <a href="/grades" class="see-all">All grades ›</a>
            <?php endif; ?>
        </div>
        <?php if (empty($grades)): ?>
            <p class="empty">No grades yet.</p>
        <?php else: ?>
            <div class="grade-list">
                <?php foreach ($grades as $g): ?>
                    <a href="/grades/edit?id=<?= (int)$g['id'] ?>" class="grade-card">
                        <div class="grade-card-strip" style="background:<?= htmlspecialchars($g['subject_color'] ?? '#d1d5db', ENT_QUOTES) ?>"></div>
                        <div class="grade-card-body">
                            <div class="grade-card-name"><?= htmlspecialchars($g['name'], ENT_QUOTES) ?></div>
                            <div class="grade-card-sub"><?= htmlspecialchars($g['subject_name'], ENT_QUOTES) ?></div>
                        </div>
                        <div class="grade-card-right">
                            <span class="grade-card-val"><?= htmlspecialchars($g['value'], ENT_QUOTES) ?><span class="grade-card-max">/<?= htmlspecialchars($g['max_value'], ENT_QUOTES) ?></span></span>
                            <?php if ($g['graded_at']): ?>
                                <span class="grade-card-date"><?= date('d/m/Y', strtotime($g['graded_at'])) ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php if ($average !== null): ?>
                <div class="average-row">
                    <span class="label">Overall average</span>
                    <span class="value"><?= number_format($average, 2) ?>/20</span>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Événements de la semaine -->
    <div class="card">
        <div class="card-header">
            <h2>This week's events</h2>
            <?php if (!empty($events)): ?>
                <a href="/planning" class="see-all">All events ›</a>
            <?php endif; ?>
        </div>
        <?php if (empty($events)): ?>
            <p class="empty">No events this week.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($events as $e):
                    $eTypeLabel = $typeColors[$e['type']]['label'] ?? ucfirst($e['type'] ?? '');
                    $eDateStr   = date('d/m', strtotime($e['start_date']));
                    if (!empty($e['end_date']) && $e['end_date'] !== $e['start_date']) {
                        $eDateStr .= ' → ' . date('d/m', strtotime($e['end_date']));
                    }
                ?>
                    <li>
                        <a href="/planning/edit?id=<?= (int)$e['id'] ?>" class="event-row">
                            <span class="event-dot" style="background:<?= htmlspecialchars($e['color'] ?? '#6366f1', ENT_QUOTES) ?>"></span>
                            <div class="event-content">
                                <div class="event-name-row">
                                    <span class="event-title"><?= htmlspecialchars($e['title']) ?></span>
                                    <span class="event-date"><?= htmlspecialchars($eDateStr) ?></span>
                                </div>
                                <div class="event-type-label"><?= htmlspecialchars($eTypeLabel, ENT_QUOTES) ?></div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- Révisions du jour -->
    <div class="card">
        <div class="card-header">
            <h2>Today's revisions</h2>
            <a href="/revision" class="btn-see-all">
                All Revisions
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <?php if (empty($revisions)): ?>
            <p class="empty">Nothing to revise today.</p>
        <?php else: ?>
            <?php $dbToday = date('Y-m-d'); ?>
            <ul>
                <?php foreach ($revisions as $r):
                    $intv        = json_decode($r['intervals'] ?? '[]', true) ?: [];
                    $idx         = (int) ($r['interval_index'] ?? 0);
                    $isReviewed  = ($r['reviewed_today'] ?? '') === $dbToday;
                    $displayIdx  = $isReviewed ? max(0, $idx - 1) : $idx;
                    $currentStep = $intv[$displayIdx] ?? ['day' => '?', 'action' => ''];
                    $nextIdx     = $isReviewed ? $idx : ($idx + 1);
                    $isLast      = $nextIdx >= count($intv);
                    $nextStep    = !$isLast ? ($intv[$nextIdx] ?? null) : null;
                    $subjColor   = htmlspecialchars($r['subject_color'] ?? '#d1d5db', ENT_QUOTES);
                    $itemName    = htmlspecialchars($r['item_name'] ?? ($r['item_type'] . ' #' . $r['item_id']), ENT_QUOTES);
                ?>
                    <li>
                        <div class="rev-row">
                            <!-- Toggle -->
                            <form method="POST" action="/revision/toggle" style="display:inline-flex;flex-shrink:0">
                                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                                <input type="hidden" name="from" value="dashboard">
                                <button type="submit" class="rev-toggle-sm<?= $isReviewed ? ' checked' : '' ?>"
                                        title="<?= $isReviewed ? 'Uncheck' : 'Mark reviewed' ?>">
                                    <?php if ($isReviewed): ?>
                                        <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <?php endif; ?>
                                </button>
                            </form>
                            <!-- Color dot -->
                            <span class="subj-dot-sm" style="background:<?= $subjColor ?>"></span>
                            <!-- Body — clickable link to revision page -->
                            <a href="/revision" class="rev-item-link">
                                <div class="rev-item-name<?= $isReviewed ? ' reviewed' : '' ?>"><?= $itemName ?></div>
                                <?php if ($isReviewed && $nextStep): ?>
                                    <div class="rev-item-next">Next: <?= date('d/m', strtotime($r['next_revision_date'])) ?> · J+<?= (int)$nextStep['day'] ?></div>
                                <?php elseif ($isReviewed && $isLast): ?>
                                    <div class="rev-item-next">Last step done — mastered</div>
                                <?php endif; ?>
                            </a>
                            <!-- Badge -->
                            <span style="padding:.15rem .4rem;border-radius:99px;font-size:.68rem;font-weight:700;background:var(--purple-tint-2);color:#6d28d9;flex-shrink:0;">J+<?= htmlspecialchars((string)$currentStep['day'], ENT_QUOTES) ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

</div>
