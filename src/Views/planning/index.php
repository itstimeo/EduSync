<?php
$iconEdit = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.5-6.5a2.121 2.121 0 013 3L12 14l-4 1 1-4z"/></svg>';
$iconDel  = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16M10 3h4a1 1 0 011 1v3H9V4a1 1 0 011-1z"/></svg>';

$monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
$dowNames   = ['Mo','Tu','We','Th','Fr','Sa','Su'];

$yearNum    = (int) substr($firstDay, 0, 4);
$monthNum   = (int) substr($firstDay, 5, 2);
$daysInMonth = (int) date('t', strtotime($firstDay));
$firstDow   = ((int) date('N', strtotime($firstDay))) - 1; // 0=Mon … 6=Sun
$today      = date('Y-m-d');

$prevMonth  = date('Y-m', strtotime($firstDay . ' -1 month'));
$nextMonth  = date('Y-m', strtotime($firstDay . ' +1 month'));

// $dayMap is pre-built by the controller
function hexBadgeBg(string $hex, float $alpha = 0.15): string {
    $hex = ltrim($hex, '#');
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return "rgba($r,$g,$b,$alpha)";
}
?>
<style>
.page-hd{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem}
.page-hd h1{font-size:1.25rem;font-weight:700}
.hd-right{display:flex;align-items:center;gap:.6rem}
.btn{display:inline-flex;align-items:center;gap:.3rem;padding:.45rem .9rem;border-radius:6px;font-size:.85rem;font-weight:500;text-decoration:none;cursor:pointer;border:none}
.btn-primary{background:#6366f1;color:#fff}.btn-primary:hover{background:#4f46e5}
.btn-ghost{background:#f3f4f6;color:#374151;padding:.4rem .7rem;font-size:.8rem}.btn-ghost:hover{background:#e5e7eb}
/* Tabs */
.tabs{display:flex;gap:0;border-bottom:2px solid #e5e7eb;margin-bottom:1.5rem}
.tab-btn{padding:.6rem 1.25rem;font-size:.875rem;font-weight:500;color:#6b7280;background:none;border:none;cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px}
.tab-btn.active{color:#6366f1;border-bottom-color:#6366f1;font-weight:600}
.tab-panel{display:none}.tab-panel.active{display:block}
/* Calendar */
.cal-nav{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem}
.cal-nav-btn{background:#f3f4f6;border:none;border-radius:6px;padding:.35rem .65rem;cursor:pointer;font-size:1rem;color:#374151;text-decoration:none;line-height:1}
.cal-nav-btn:hover{background:#e5e7eb}
.cal-month{font-size:1rem;font-weight:700;color:#1a1a1a}
.cal-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:3px}
.cal-dow{text-align:center;font-size:.72rem;font-weight:600;color:#9ca3af;padding:.3rem 0}
.cal-cell{background:#fff;border:1px solid #e5e7eb;border-radius:6px;min-height:80px;padding:.35rem .4rem;cursor:pointer;transition:background .1s;vertical-align:top}
.cal-cell:hover{background:#f5f3ff}
.cal-cell.other-month{background:#f9fafb;opacity:.5;cursor:default}
.cal-cell.other-month:hover{background:#f9fafb}
.cal-cell.today{border-color:#6366f1;border-width:2px}
.cal-day-num{font-size:.78rem;font-weight:600;color:#374151;margin-bottom:.25rem}
.cal-cell.today .cal-day-num{color:#6366f1}
.cal-event{display:flex;align-items:center;gap:.25rem;font-size:.7rem;margin-bottom:2px;border-radius:3px;padding:1px 3px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:100%}
.cal-event-dot{width:6px;height:6px;border-radius:50%;flex-shrink:0}
.cal-event-title{overflow:hidden;text-overflow:ellipsis;color:#374151}
.cal-more{font-size:.68rem;color:#6366f1;font-weight:600;margin-top:1px}
/* List */
.event-row{background:#fff;border:1px solid #e5e7eb;border-radius:8px;display:flex;align-items:center;margin-bottom:.55rem;overflow:hidden}
.event-strip{width:5px;align-self:stretch;flex-shrink:0}
.event-body{flex:1;padding:.65rem 1rem;min-width:0}
.event-top{display:flex;align-items:center;gap:.5rem;flex-wrap:wrap}
.event-title{font-weight:600;font-size:.9rem;color:#1a1a1a}
.event-badge{font-size:.7rem;font-weight:600;padding:.15rem .5rem;border-radius:999px;white-space:nowrap}
.event-dates{font-size:.78rem;color:#9ca3af;margin-top:.15rem}
.event-desc{font-size:.78rem;color:#6b7280;margin-top:.15rem}
.event-actions{padding:.4rem .75rem;display:flex;gap:.3rem;flex-shrink:0}
.empty{color:#9ca3af;font-size:.9rem;padding:3rem 0;text-align:center}
</style>

<div class="page-hd">
    <h1>Planning</h1>
    <div class="hd-right">
        <a href="/planning/settings" class="btn-icon btn-edit" title="Settings" style="background:#d1d5db;color:#374151"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg></a>
        <a href="/planning/create" class="btn btn-primary">+ New event</a>
    </div>
</div>

<div class="tabs">
    <button class="tab-btn" id="tab-calendar" onclick="switchTab('calendar')">Calendar</button>
    <button class="tab-btn" id="tab-list"     onclick="switchTab('list')">List</button>
</div>

<!-- ── Calendar tab ─────────────────────────────────────────────── -->
<div class="tab-panel" id="panel-calendar">
    <div class="cal-nav">
        <a href="/planning?month=<?= htmlspecialchars($prevMonth, ENT_QUOTES) ?>" class="cal-nav-btn">&#8249;</a>
        <span class="cal-month"><?= $monthNames[$monthNum - 1] ?> <?= $yearNum ?></span>
        <a href="/planning?month=<?= htmlspecialchars($nextMonth, ENT_QUOTES) ?>" class="cal-nav-btn">&#8250;</a>
    </div>
    <div class="cal-grid">
        <?php foreach ($dowNames as $d): ?>
            <div class="cal-dow"><?= $d ?></div>
        <?php endforeach; ?>

        <?php
        // Leading empty cells
        for ($i = 0; $i < $firstDow; $i++):
            $prevMonthDays = (int) date('t', strtotime($firstDay . ' -1 month'));
            $dayNum = $prevMonthDays - $firstDow + $i + 1;
        ?>
            <div class="cal-cell other-month">
                <div class="cal-day-num"><?= $dayNum ?></div>
            </div>
        <?php endfor; ?>

        <?php for ($d = 1; $d <= $daysInMonth; $d++):
            $dayStr    = sprintf('%04d-%02d-%02d', $yearNum, $monthNum, $d);
            $isToday   = $dayStr === $today;
            $dayEvents = $dayMap[$dayStr] ?? [];
            $extraCount = max(0, count($dayEvents) - 3);
        ?>
            <div class="cal-cell<?= $isToday ? ' today' : '' ?>"
                 onclick="location.href='/planning/create?date=<?= $dayStr ?>'">
                <div class="cal-day-num"><?= $d ?></div>
                <?php foreach (array_slice($dayEvents, 0, 3) as $e): ?>
                    <div class="cal-event" onclick="event.stopPropagation();location.href='/planning/edit?id=<?= (int)$e['id'] ?>'">
                        <span class="cal-event-dot" style="background:<?= htmlspecialchars($e['color'], ENT_QUOTES) ?>"></span>
                        <span class="cal-event-title"><?= htmlspecialchars($e['title'], ENT_QUOTES) ?></span>
                    </div>
                <?php endforeach; ?>
                <?php if ($extraCount > 0): ?>
                    <div class="cal-more">+<?= $extraCount ?> more</div>
                <?php endif; ?>
            </div>
        <?php endfor; ?>

        <?php
        $filled = $firstDow + $daysInMonth;
        $trailing = $filled % 7 === 0 ? 0 : 7 - ($filled % 7);
        for ($i = 1; $i <= $trailing; $i++):
        ?>
            <div class="cal-cell other-month">
                <div class="cal-day-num"><?= $i ?></div>
            </div>
        <?php endfor; ?>
    </div>
</div>

<!-- ── List tab ─────────────────────────────────────────────────── -->
<div class="tab-panel" id="panel-list">
    <?php if (empty($upcoming)): ?>
        <p class="empty">No events yet.</p>
    <?php else: ?>
        <?php foreach ($upcoming as $e):
            $typeLabel = $typeColors[$e['type']]['label'] ?? ucfirst($e['type']);
            $badgeBg   = hexBadgeBg($e['color']);
            $badgeText = $e['color'];
            $dateStr   = date('d/m/Y', strtotime($e['start_date']));
            if (!empty($e['end_date']) && $e['end_date'] !== $e['start_date']) {
                $dateStr .= ' → ' . date('d/m/Y', strtotime($e['end_date']));
            }
        ?>
            <div class="event-row">
                <div class="event-strip" style="background:<?= htmlspecialchars($e['color'], ENT_QUOTES) ?>"></div>
                <div class="event-body">
                    <div class="event-top">
                        <span class="event-title"><?= htmlspecialchars($e['title'], ENT_QUOTES) ?></span>
                        <span class="event-badge" style="background:<?= $badgeBg ?>;color:<?= $badgeText ?>"><?= htmlspecialchars($typeLabel, ENT_QUOTES) ?></span>
                    </div>
                    <div class="event-dates"><?= htmlspecialchars($dateStr, ENT_QUOTES) ?></div>
                    <?php if (!empty($e['description'])): ?>
                        <div class="event-desc"><?= htmlspecialchars($e['description'], ENT_QUOTES) ?></div>
                    <?php endif; ?>
                </div>
                <div class="event-actions">
                    <a href="/planning/edit?id=<?= (int)$e['id'] ?>" class="btn-icon btn-edit" title="Edit"><?= $iconEdit ?></a>
                    <form method="post" action="/planning/delete">
                        <input type="hidden" name="id" value="<?= (int)$e['id'] ?>">
                        <button type="button" class="btn-icon btn-delete" title="Delete"
                                onclick="esConfirm('Delete «<?= htmlspecialchars(addslashes($e['title']), ENT_QUOTES) ?>»?',()=>this.closest('form').submit())"><?= $iconDel ?></button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
(function () {
    var key = 'es_planning_tab';
    function switchTab(name) {
        localStorage.setItem(key, name);
        document.querySelectorAll('.tab-btn').forEach(function (b) {
            b.classList.toggle('active', b.id === 'tab-' + name);
        });
        document.querySelectorAll('.tab-panel').forEach(function (p) {
            p.classList.toggle('active', p.id === 'panel-' + name);
        });
    }
    window.switchTab = switchTab;
    switchTab(localStorage.getItem(key) || 'calendar');
})();
</script>
