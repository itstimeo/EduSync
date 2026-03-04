<style>
    .dashboard-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    .card { background: #fff; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.07); padding: 1.5rem; }
    .card h2 { font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: #374151; }
    .card ul { list-style: none; }
    .card ul li { padding: .5rem 0; border-bottom: 1px solid #f3f4f6; font-size: .875rem; display: flex; justify-content: space-between; }
    .card ul li:last-child { border-bottom: none; }
    .average-row { margin-top: .85rem; padding-top: .75rem; border-top: 2px solid #e5e7eb; display: flex; justify-content: space-between; align-items: baseline; }
    .average-row .label { color: #6b7280; font-size: .875rem; font-weight: 600; }
    .average-row .value { font-size: 1.4rem; font-weight: 800; color: #6366f1; }
    .card ul li .subject { color: #6b7280; font-size: .8rem; }
    .card ul li .grade { font-weight: 600; color: #1a1a1a; }
    .card ul li .date { font-size: .78rem; color: #9ca3af; }
    .event-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-right: .4rem; }
    .event-content { flex: 1; min-width: 0; }
    .event-name-row { display: flex; align-items: center; gap: .35rem; }
    .card ul li .event-title { font-weight: 600; font-size: .875rem; color: #1a1a1a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1; }
    .card ul li .event-date { font-size: .75rem; color: #9ca3af; white-space: nowrap; flex-shrink: 0; }
    .event-type-label { font-size: .72rem; color: #9ca3af; margin-top: .1rem; padding-left: 12px; }
    .empty { color: #9ca3af; font-size: .875rem; text-align: center; padding: 1rem 0; }
    .grade-list { display: flex; flex-direction: column; gap: .5rem; }
    .grade-card { display: flex; align-items: center; border: 1px solid #f3f4f6; border-radius: 7px; overflow: hidden; background: #fafafa; }
    .grade-card-strip { width: 5px; align-self: stretch; flex-shrink: 0; }
    .grade-card-body { flex: 1; padding: .5rem .75rem; min-width: 0; }
    .grade-card-name { font-size: .875rem; font-weight: 600; color: #1a1a1a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .grade-card-sub { font-size: .75rem; color: #9ca3af; margin-top: .05rem; }
    .grade-card-right { display: flex; flex-direction: column; align-items: flex-end; padding: .5rem .75rem; flex-shrink: 0; gap: .1rem; }
    .grade-card-val { font-size: .95rem; font-weight: 700; color: #1a1a1a; }
    .grade-card-max { font-size: .75rem; font-weight: 400; color: #9ca3af; }
    .grade-card-date { font-size: .72rem; color: #9ca3af; }
    @media (max-width: 700px) { .dashboard-grid { grid-template-columns: 1fr; } }
</style>

<div class="dashboard-grid">

    <!-- Notes récentes -->
    <div class="card">
        <h2>Recent grades</h2>
        <?php if (empty($grades)): ?>
            <p class="empty">No grades yet.</p>
        <?php else: ?>
            <div class="grade-list">
                <?php foreach ($grades as $g): ?>
                    <div class="grade-card">
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
                    </div>
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
        <h2>This week's events</h2>
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
                        <div class="event-content">
                            <div class="event-name-row">
                                <span class="event-dot" style="background:<?= htmlspecialchars($e['color'] ?? '#6366f1', ENT_QUOTES) ?>"></span>
                                <span class="event-title"><?= htmlspecialchars($e['title']) ?></span>
                                <span class="event-date"><?= htmlspecialchars($eDateStr) ?></span>
                            </div>
                            <div class="event-type-label"><?= htmlspecialchars($eTypeLabel, ENT_QUOTES) ?></div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- Révisions du jour -->
    <div class="card">
        <h2>Today's revisions</h2>
        <?php if (empty($revisions)): ?>
            <p class="empty">Nothing to revise today.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($revisions as $r): ?>
                    <li>
                        <span><?= htmlspecialchars($r['item_name'] ?? $r['item_type'] . ' #' . $r['item_id']) ?></span>
                        <span class="date"><?= htmlspecialchars($r['next_revision_date'] ?? '') ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

</div>
