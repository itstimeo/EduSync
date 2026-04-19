<?php
$iconEdit = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.5-6.5a2.121 2.121 0 013 3L12 14l-4 1 1-4z"/></svg>';
$iconDel  = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16M10 3h4a1 1 0 011 1v3H9V4a1 1 0 011-1z"/></svg>';

$monthNames = array_values(__arr('months'));
$dowNames   = array_values(__arr('days_short'));

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
/* Tabs */
.tabs{display:flex;gap:0;border-bottom:2px solid var(--border);margin-bottom:1.5rem}
.tab-btn{padding:.6rem 1.25rem;font-size:.875rem;font-weight:500;color:var(--text-muted);background:none;border:none;cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px}
.tab-btn.active{color:#6366f1;border-bottom-color:#6366f1;font-weight:600}
.tab-panel{display:none}.tab-panel.active{display:block}
/* Calendar */
.cal-nav{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem}
.cal-nav-btn{background:var(--bg-subtle);border:none;border-radius:6px;padding:.35rem .65rem;cursor:pointer;font-size:1rem;color:var(--text);text-decoration:none;line-height:1}
.cal-nav-btn:hover{background:var(--border)}
.cal-month{font-size:1rem;font-weight:700;color:var(--text)}
.cal-picker-wrap{position:relative}
.cal-picker-btn{font-size:.95rem;font-weight:700;color:var(--text);background:transparent;border:none;border-radius:6px;padding:.3rem .75rem;cursor:pointer;font-family:inherit;display:flex;align-items:center;gap:.4rem}
.cal-picker-btn:hover{background:var(--border)}
.cal-picker-btn svg{flex-shrink:0;color:var(--text-muted);transition:transform .18s}
.cal-picker-btn.open svg{transform:rotate(180deg)}
.cal-picker-drop{display:none;position:absolute;top:calc(100% + 6px);left:50%;transform:translateX(-50%);background:var(--surface);border:1px solid var(--border);border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.13);z-index:200;padding:.75rem;min-width:220px}
.cal-picker-drop.open{display:block}
.cal-picker-year{display:flex;align-items:center;justify-content:space-between;margin-bottom:.65rem}
.cal-picker-year span{font-size:.9rem;font-weight:700;color:var(--text)}
.cal-picker-year button{background:none;border:none;cursor:pointer;color:var(--text-muted);border-radius:6px;width:28px;height:28px;display:flex;align-items:center;justify-content:center;font-size:1rem}
.cal-picker-year button:hover{background:var(--bg-subtle);color:var(--text)}
.cal-picker-months{display:grid;grid-template-columns:repeat(3,1fr);gap:.3rem}
.cal-picker-month{padding:.4rem 0;text-align:center;font-size:.8rem;font-weight:500;border-radius:6px;cursor:pointer;color:var(--text);background:none;border:none;font-family:inherit}
.cal-picker-month:hover{background:var(--purple-tint);color:#6366f1}
.cal-picker-month.active{background:#6366f1;color:#fff;font-weight:700}
.cal-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:3px}
.cal-dow{text-align:center;font-size:.72rem;font-weight:600;color:var(--text-subtle);padding:.3rem 0}
.cal-cell{background:var(--surface);border:1px solid var(--border);border-radius:6px;min-height:80px;padding:.35rem .4rem;cursor:pointer;transition:background .1s;min-width:0;overflow:hidden}
.cal-cell:hover{background:var(--purple-tint)}
.cal-cell.other-month{background:var(--bg-hover);opacity:.5;cursor:default}
.cal-cell.other-month:hover{background:var(--bg-hover)}
.cal-cell.today{border-color:#6366f1;border-width:2px}
.cal-day-num{font-size:.78rem;font-weight:600;color:var(--text);margin-bottom:.25rem}
.cal-cell.today .cal-day-num{color:#6366f1}
.cal-event{display:flex;align-items:center;gap:.25rem;font-size:.7rem;margin-bottom:2px;border-radius:3px;padding:1px 3px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:100%}
.cal-event-dot{width:6px;height:6px;border-radius:50%;flex-shrink:0}
.cal-event-title{overflow:hidden;text-overflow:ellipsis;color:var(--text)}
.cal-more{font-size:.68rem;color:#6366f1;font-weight:600;margin-top:1px}
/* List */
.event-row{background:var(--surface);border:1px solid var(--border);border-radius:8px;display:flex;align-items:center;margin-bottom:.55rem;overflow:hidden}
.event-strip{width:5px;align-self:stretch;flex-shrink:0}
.event-body{flex:1;padding:.65rem 1rem;min-width:0}
.event-top{display:flex;align-items:center;gap:.5rem;flex-wrap:wrap}
.event-title{font-weight:600;font-size:.9rem;color:var(--text)}
.event-badge{font-size:.7rem;font-weight:600;padding:.15rem .5rem;border-radius:999px;white-space:nowrap}
.event-dates{font-size:.78rem;color:var(--text-subtle);margin-top:.15rem}
.event-desc{font-size:.78rem;color:var(--text-muted);margin-top:.15rem}
.event-actions{padding:.4rem .75rem;display:flex;gap:.3rem;flex-shrink:0}
.empty{color:var(--text-subtle);font-size:.9rem;padding:3rem 0;text-align:center}
@media (max-width: 640px) {
    .hd-right { gap: .4rem; }
    .cal-grid { gap: 2px; }
    .cal-cell { min-height: 44px; padding: .2rem .2rem; }
    .cal-day-num { font-size: .68rem; margin-bottom: .1rem; }
    .cal-event-title, .cal-more { display: none; }
    .cal-event { padding: 0; background: none; gap: 1px; margin-bottom: 1px; }
    .cal-event-dot { width: 6px; height: 6px; }
    .page-hd h1 { font-size: 1.1rem; }
}
</style>

<div class="page-hd">
    <h1><?= __('planning.title') ?></h1>
    <div class="hd-right">
        <a href="/planning/settings" class="btn-icon btn-edit" title="<?= __('planning.settings') ?>" style="background:var(--border-soft);color:var(--text)"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg></a>
        <a href="/planning/create" class="btn btn-primary"><?= __('planning.new_event') ?></a>
    </div>
</div>

<div class="tabs">
    <button class="tab-btn" id="tab-calendar" onclick="switchTab('calendar')"><?= __('planning.calendar') ?></button>
    <button class="tab-btn" id="tab-list"     onclick="switchTab('list')"><?= __('planning.list') ?></button>
</div>

<!-- ── Calendar tab ─────────────────────────────────────────────── -->
<div class="tab-panel" id="panel-calendar">
    <div class="cal-nav">
        <a href="/planning?month=<?= htmlspecialchars($prevMonth, ENT_QUOTES) ?>" class="cal-nav-btn">&#8249;</a>
        <div class="cal-picker-wrap">
            <button class="cal-picker-btn" id="cal-picker-btn" type="button">
                <?= $monthNames[$monthNum - 1] ?> <?= $yearNum ?>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
            </button>
            <div class="cal-picker-drop" id="cal-picker-drop">
                <div class="cal-picker-year">
                    <button type="button" id="cal-year-prev">&#8249;</button>
                    <span id="cal-year-label"><?= $yearNum ?></span>
                    <button type="button" id="cal-year-next">&#8250;</button>
                </div>
                <div class="cal-picker-months" id="cal-picker-months"></div>
            </div>
        </div>
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
                    <div class="cal-more"><?= sprintf(__('planning.more'), $extraCount) ?></div>
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
        <p class="empty"><?= __('planning.no_events') ?></p>
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
                                onclick="esConfirm('<?= htmlspecialchars(sprintf(__('planning.delete_confirm'), addslashes($e['title'])), ENT_QUOTES) ?>',()=>this.closest('form').submit())"><?= $iconDel ?></button>
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

<!-- Mobile day detail popup -->
<div id="day-popup" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:400;align-items:flex-end;justify-content:center;">
    <div style="background:var(--surface);border-radius:16px 16px 0 0;padding:1.25rem;width:100%;max-width:500px;max-height:70vh;overflow-y:auto;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
            <span id="day-popup-title" style="font-weight:700;font-size:1rem;color:var(--text);"></span>
            <button id="day-popup-close" style="background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:1.1rem;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px;">✕</button>
        </div>
        <div id="day-popup-events"></div>
        <a id="day-popup-add" href="#" style="display:flex;align-items:center;justify-content:center;margin-top:.75rem;padding:.55rem;background:#6366f1;color:#fff;border-radius:8px;text-decoration:none;font-weight:600;font-size:.875rem;"><?= __('planning.new_event') ?></a>
    </div>
</div>

<script>
(function () {
    var dayMapData = <?= json_encode($dayMap, JSON_HEX_TAG) ?>;
    var monthNames = <?= json_encode(array_values(__arr('months'))) ?>;
    var yearNum  = <?= (int)$yearNum ?>;
    var monthNum = <?= (int)$monthNum ?>;

    var popup    = document.getElementById('day-popup');
    var titleEl  = document.getElementById('day-popup-title');
    var eventsEl = document.getElementById('day-popup-events');
    var addLink  = document.getElementById('day-popup-add');
    var closeBtn = document.getElementById('day-popup-close');

    function esc(s) { return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

    function showPopup(dateStr, createHref) {
        var day = parseInt(dateStr.split('-')[2], 10);
        titleEl.textContent = day + ' ' + monthNames[monthNum - 1] + ' ' + yearNum;
        addLink.href = createHref;
        var evs = dayMapData[dateStr] || [];
        if (evs.length === 0) {
            eventsEl.innerHTML = '<p style="color:var(--text-subtle);font-size:.875rem;padding:.25rem 0 .5rem;"><?= __('planning.no_day_events') ?></p>';
        } else {
            eventsEl.innerHTML = evs.map(function (ev) {
                return '<a href="/planning/edit?id=' + ev.id + '" style="display:flex;align-items:center;gap:.65rem;padding:.6rem 0;border-bottom:1px solid var(--bg-subtle);text-decoration:none;">'
                     + '<span style="width:10px;height:10px;border-radius:50%;background:' + esc(ev.color) + ';flex-shrink:0;"></span>'
                     + '<span style="font-size:.875rem;font-weight:500;color:var(--text);">' + esc(ev.title) + '</span>'
                     + '</a>';
            }).join('');
        }
        popup.style.display = 'flex';
    }

    document.querySelectorAll('.cal-cell:not(.other-month)').forEach(function (cell) {
        var oc = cell.getAttribute('onclick') || '';
        var m = oc.match(/'([^']+)'/);
        var createHref = m ? m[1] : null;
        if (!createHref) return;
        var dm = createHref.match(/date=(\d{4}-\d{2}-\d{2})/);
        if (!dm) return;
        var dateStr = dm[1];
        cell.removeAttribute('onclick');
        cell.addEventListener('click', function () {
            if (window.innerWidth >= 640) { location.href = createHref; return; }
            showPopup(dateStr, createHref);
        });
    });

    document.querySelectorAll('.cal-event').forEach(function (ev) {
        var oc = ev.getAttribute('onclick') || '';
        ev.removeAttribute('onclick');
        ev.addEventListener('click', function (e) {
            if (window.innerWidth >= 640) {
                e.stopPropagation();
                var m = oc.match(/'([^']+)'/);
                if (m) location.href = m[1];
            }
            // Mobile: don't stopPropagation — let the cell click show the popup
        });
    });

    closeBtn.addEventListener('click', function () { popup.style.display = 'none'; });
    popup.addEventListener('click', function (e) { if (e.target === popup) popup.style.display = 'none'; });

    // ── Month/year picker dropdown ──
    var MONTHS = <?= json_encode(array_values(__arr('months'))) ?>;
    var pickerBtn   = document.getElementById('cal-picker-btn');
    var pickerDrop  = document.getElementById('cal-picker-drop');
    var yearLabel   = document.getElementById('cal-year-label');
    var monthsGrid  = document.getElementById('cal-picker-months');
    var curYear     = <?= (int)$yearNum ?>;
    var curMonth    = <?= (int)$monthNum ?>;
    var pickerYear  = curYear;

    function renderMonths() {
        yearLabel.textContent = pickerYear;
        monthsGrid.innerHTML = '';
        MONTHS.forEach(function (name, i) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'cal-picker-month' + (pickerYear === curYear && i + 1 === curMonth ? ' active' : '');
            btn.textContent = name.slice(0, 3);
            btn.addEventListener('click', function () {
                var m = i + 1;
                location.href = '/planning?month=' + pickerYear + '-' + (m < 10 ? '0' + m : m);
            });
            monthsGrid.appendChild(btn);
        });
    }

    pickerBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = pickerDrop.classList.toggle('open');
        pickerBtn.classList.toggle('open', isOpen);
        if (isOpen) { pickerYear = curYear; renderMonths(); }
    });

    document.getElementById('cal-year-prev').addEventListener('click', function (e) {
        e.stopPropagation(); pickerYear--; renderMonths();
    });
    document.getElementById('cal-year-next').addEventListener('click', function (e) {
        e.stopPropagation(); pickerYear++; renderMonths();
    });

    document.addEventListener('click', function (e) {
        if (!pickerDrop.contains(e.target) && e.target !== pickerBtn) {
            pickerDrop.classList.remove('open');
            pickerBtn.classList.remove('open');
        }
    });
})();
</script>
