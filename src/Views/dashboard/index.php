<style>
    .dashboard-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    .card { background: #fff; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.07); padding: 1.5rem; }
    .card h2 { font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: #374151; }
    .card ul { list-style: none; }
    .card ul li { padding: .5rem 0; border-bottom: 1px solid #f3f4f6; font-size: .875rem; display: flex; justify-content: space-between; }
    .card ul li:last-child { border-bottom: none; }
    .average-row { margin-top: .75rem; padding-top: .75rem; border-top: 2px solid #e5e7eb; display: flex; justify-content: space-between; font-size: .875rem; }
    .average-row .label { color: #6b7280; font-weight: 600; }
    .average-row .value { font-weight: 700; color: #6366f1; }
    .card ul li .subject { color: #6b7280; font-size: .8rem; }
    .card ul li .grade { font-weight: 600; color: #1a1a1a; }
    .card ul li .date { font-size: .78rem; color: #9ca3af; }
    .card ul li .event-title { flex: 1; }
    .card ul li .event-date { font-size: .78rem; color: #9ca3af; white-space: nowrap; margin-left: .5rem; }
    .empty { color: #9ca3af; font-size: .875rem; text-align: center; padding: 1rem 0; }
    @media (max-width: 700px) { .dashboard-grid { grid-template-columns: 1fr; } }
</style>

<div class="dashboard-grid">

    <!-- Notes récentes -->
    <div class="card">
        <h2>Recent grades</h2>
        <?php if (empty($grades)): ?>
            <p class="empty">No grades yet.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($grades as $g): ?>
                    <li>
                        <span>
                            <?= htmlspecialchars($g['name']) ?>
                            <br><span class="subject"><?= htmlspecialchars($g['subject_name']) ?></span>
                        </span>
                        <span>
                            <span class="grade"><?= htmlspecialchars($g['value']) ?>/<?= htmlspecialchars($g['max_value']) ?></span>
                            <br><span class="date"><?= $g['graded_at'] ? date('d/m/Y', strtotime($g['graded_at'])) : '' ?></span>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
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
                <?php foreach ($events as $e): ?>
                    <li>
                        <span class="event-title"><?= htmlspecialchars($e['title']) ?></span>
                        <span class="event-date"><?= htmlspecialchars(date('D d/m', strtotime($e['start_date']))) ?></span>
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
