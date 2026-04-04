<?php
$iconEdit = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.5-6.5a2.121 2.121 0 013 3L12 14l-4 1 1-4z"/></svg>';
$iconDel  = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16M10 3h4a1 1 0 011 1v3H9V4a1 1 0 011-1z"/></svg>';
?>
<style>
.page-hd{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem}
.page-hd h1{font-size:1.25rem;font-weight:700}
.avg-banner{background:var(--surface);border:1px solid var(--border);border-radius:8px;padding:.85rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;justify-content:space-between}
.avg-banner .label{font-size:.875rem;color:var(--text-muted);font-weight:600}
.avg-banner .value{font-size:1.1rem;font-weight:700;color:#6366f1}
/* Tabs */
.tabs{display:flex;gap:0;border-bottom:2px solid var(--border);margin-bottom:1.5rem}
.tab-btn{padding:.6rem 1.25rem;font-size:.875rem;font-weight:500;color:var(--text-muted);background:none;border:none;cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px}
.tab-btn.active{color:#6366f1;border-bottom-color:#6366f1;font-weight:600}
.tab-panel{display:none}.tab-panel.active{display:block}
/* Subject group */
.subject-block{background:var(--surface);border:1px solid var(--border);border-radius:8px;overflow:hidden;margin-bottom:1rem}
.subject-header{display:flex;align-items:center;gap:.75rem;padding:.75rem 1rem;border-bottom:1px solid var(--bg-subtle)}
.subject-strip{width:10px;height:10px;border-radius:50%;flex-shrink:0}
.subject-name{font-weight:600;font-size:.95rem;flex:1}
.subject-avg{font-size:.85rem;color:var(--text-muted)}
.subject-avg strong{color:#6366f1}
.grade-row{display:flex;align-items:center;padding:.6rem 1rem;border-bottom:1px solid var(--bg-hover);font-size:.875rem}
.grade-row:last-child{border-bottom:none}
.grade-name{flex:1;font-weight:500}
.grade-comment{font-size:.78rem;color:var(--text-subtle);margin-top:.1rem}
.grade-val{font-weight:700;color:var(--text);white-space:nowrap;margin-right:.5rem}
.grade-coeff{font-size:.78rem;color:var(--text-subtle);margin-right:.75rem;white-space:nowrap}
.grade-date{font-size:.78rem;color:var(--text-subtle);white-space:nowrap;margin-right:.75rem}
.grade-actions{display:flex;gap:.3rem;flex-shrink:0}
/* Chrono */
.chrono-row{background:var(--surface);border:1px solid var(--border);border-radius:8px;display:flex;align-items:center;margin-bottom:.55rem;overflow:hidden}
.chrono-strip{width:5px;align-self:stretch;flex-shrink:0}
.chrono-body{flex:1;padding:.65rem 1rem}
.chrono-top{display:flex;align-items:center;gap:.5rem}
.chrono-name{font-weight:600;font-size:.9rem}
.chrono-subject{font-size:.78rem;color:var(--text-muted);margin-left:.25rem}
.chrono-val{font-weight:700;color:var(--text);margin-left:auto;white-space:nowrap}
.chrono-meta{font-size:.78rem;color:var(--text-subtle);margin-top:.1rem}
.chrono-actions{padding:.4rem .75rem;display:flex;gap:.3rem;flex-shrink:0}
.empty{color:var(--text-subtle);font-size:.9rem;padding:3rem 0;text-align:center}
.chart-wrap{background:var(--surface);border:1px solid var(--border);border-radius:8px;padding:1.25rem 1.25rem 1rem;margin-bottom:1rem}
.chart-label{font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-muted);margin-bottom:1rem}
.chart-empty{color:var(--text-subtle);font-size:.85rem;text-align:center;padding:1.5rem 0}
/* Pagination */
.pagination{display:flex;align-items:center;justify-content:center;gap:.3rem;margin-top:1rem;flex-wrap:wrap}
.pg-btn{padding:.3rem .65rem;border-radius:6px;border:1.5px solid var(--border-soft);background:transparent;color:var(--text-muted);font-size:.8rem;cursor:pointer;transition:all .12s}
.pg-btn.active{background:#6366f1;border-color:#6366f1;color:#fff}
.pg-btn:hover:not(.active):not(:disabled){background:var(--bg-subtle);color:var(--text)}
.pg-btn:disabled{opacity:.35;cursor:default}
.pg-info{font-size:.78rem;color:var(--text-subtle);text-align:center;margin-top:.5rem}
/* Stats pills */
.sf-pills{display:flex;flex-wrap:wrap;gap:.4rem;margin-bottom:1rem}
.sf-pill{display:inline-flex;align-items:center;gap:.35rem;padding:.28rem .75rem;border-radius:99px;border:1.5px solid var(--border-soft);cursor:pointer;user-select:none;font-size:.8rem;font-weight:500;color:var(--text-muted);background:transparent;transition:all .15s}
.sf-pill.active{color:var(--text)}
.sf-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;transition:opacity .15s}
.sf-pill:not(.active) .sf-dot{opacity:.35}
.chart-canvas-wrap{position:relative;height:380px;overflow-x:auto;-webkit-overflow-scrolling:touch}
    #chart-line{min-width:520px}
@media (max-width: 640px) {
    .tabs { overflow-x: auto; white-space: nowrap; }
    .grade-date, .grade-coeff { display: none; }
    .chrono-subject { display: none; }
    .avg-banner { flex-direction: column; align-items: flex-start; gap: .25rem; }
    .sf-pills { gap: .3rem; }
}
</style>

<div class="page-hd">
    <h1>Grades</h1>
    <a href="/grades/create" class="btn btn-primary">+ New grade</a>
</div>

<div class="avg-banner">
    <span class="label">Overall average</span>
    <span class="value">
        <?= $average !== null ? number_format($average, 2) . '/20' : '—' ?>
    </span>
</div>

<div class="tabs">
    <button class="tab-btn" id="tab-subject" onclick="switchTab('subject')">By subject</button>
    <button class="tab-btn" id="tab-chrono"  onclick="switchTab('chrono')">Chronological</button>
    <button class="tab-btn" id="tab-stats"   onclick="switchTab('stats')">Statistics</button>
</div>

<!-- Tab: By subject -->
<div class="tab-panel" id="panel-subject">
    <?php if (empty($grouped)): ?>
        <p class="empty">No grades yet.</p>
    <?php else: ?>
        <?php foreach ($grouped as $group): ?>
            <div class="subject-block">
                <div class="subject-header">
                    <span class="subject-strip" style="background:<?= htmlspecialchars($group['subject_color'], ENT_QUOTES) ?>"></span>
                    <span class="subject-name"><?= htmlspecialchars($group['subject_name'], ENT_QUOTES) ?></span>
                    <span class="subject-avg">
                        Avg: <strong><?= $group['average'] !== null ? number_format($group['average'], 2) . '/20' : '—' ?></strong>
                    </span>
                </div>
                <?php foreach ($group['grades'] as $g): ?>
                    <div class="grade-row">
                        <div style="flex:1">
                            <div class="grade-name"><?= htmlspecialchars($g['name'], ENT_QUOTES) ?></div>
                            <?php if (!empty($g['comment'])): ?>
                                <div class="grade-comment"><?= htmlspecialchars($g['comment'], ENT_QUOTES) ?></div>
                            <?php endif; ?>
                        </div>
                        <span class="grade-date"><?= $g['graded_at'] ? date('d/m/Y', strtotime($g['graded_at'])) : '' ?></span>
                        <span class="grade-coeff">×<?= htmlspecialchars($g['coefficient'], ENT_QUOTES) ?></span>
                        <span class="grade-val"><?= htmlspecialchars($g['value'], ENT_QUOTES) ?>/<?= htmlspecialchars($g['max_value'], ENT_QUOTES) ?></span>
                        <div class="grade-actions">
                            <a href="/grades/edit?id=<?= (int)$g['id'] ?>" class="btn-icon btn-edit" title="Edit"><?= $iconEdit ?></a>
                            <form method="post" action="/grades/delete">
                                <input type="hidden" name="id" value="<?= (int)$g['id'] ?>">
                                <button type="button" class="btn-icon btn-delete" title="Delete"
                                        onclick="esConfirm('Delete «<?= htmlspecialchars(addslashes($g['name']), ENT_QUOTES) ?>»?',()=>this.closest('form').submit())"><?= $iconDel ?></button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Tab: Chronological -->
<div class="tab-panel" id="panel-chrono">
    <?php if (empty($all)): ?>
        <p class="empty">No grades yet.</p>
    <?php else: ?>
        <?php foreach ($all as $g): ?>
            <div class="chrono-row">
                <div class="chrono-strip" style="background:<?= htmlspecialchars($g['subject_color'], ENT_QUOTES) ?>"></div>
                <div class="chrono-body">
                    <div class="chrono-top">
                        <span class="chrono-name"><?= htmlspecialchars($g['name'], ENT_QUOTES) ?></span>
                        <span class="chrono-subject"><?= htmlspecialchars($g['subject_name'], ENT_QUOTES) ?></span>
                        <span class="chrono-val"><?= htmlspecialchars($g['value'], ENT_QUOTES) ?>/<?= htmlspecialchars($g['max_value'], ENT_QUOTES) ?></span>
                    </div>
                    <div class="chrono-meta">
                        <?= $g['graded_at'] ? date('d/m/Y', strtotime($g['graded_at'])) : '' ?>
                        &nbsp;·&nbsp; coeff. <?= htmlspecialchars($g['coefficient'], ENT_QUOTES) ?>
                        <?php if (!empty($g['comment'])): ?>
                            &nbsp;·&nbsp; <?= htmlspecialchars($g['comment'], ENT_QUOTES) ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="chrono-actions">
                    <a href="/grades/edit?id=<?= (int)$g['id'] ?>" class="btn-icon btn-edit" title="Edit"><?= $iconEdit ?></a>
                    <form method="post" action="/grades/delete">
                        <input type="hidden" name="id" value="<?= (int)$g['id'] ?>">
                        <button type="button" class="btn-icon btn-delete" title="Delete"
                                onclick="esConfirm('Delete «<?= htmlspecialchars(addslashes($g['name']), ENT_QUOTES) ?>»?',()=>this.closest('form').submit())"><?= $iconDel ?></button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        <div id="chrono-pagination" class="pagination"></div>
        <div id="chrono-pg-info" class="pg-info"></div>
    <?php endif; ?>
</div>

<!-- Tab: Statistics -->
<div class="tab-panel" id="panel-stats">
<?php
$lineDatasets = [];
$allGradesForAvg = [];
foreach ($grouped as $group) {
    $pts = array_values(array_filter($group['grades'], fn($g) => !empty($g['graded_at'])));
    if (empty($pts)) continue;
    usort($pts, fn($a, $b) => strcmp($a['graded_at'], $b['graded_at']));
    $data = []; $sumW = 0.0; $sumC = 0.0;
    foreach ($pts as $g) {
        $coeff = (float) $g['coefficient'];
        $sumW += ($g['value'] / $g['max_value'] * 20) * $coeff;
        $sumC += $coeff;
        $data[] = ['x' => $g['graded_at'], 'y' => round($sumW / $sumC, 2), 'name' => $g['name']];
        $allGradesForAvg[] = $g;
    }
    $lineDatasets[] = [
        'label'       => $group['subject_name'],
        'data'        => $data,
        'borderColor' => $group['subject_color'],
        'borderWidth' => 2,
        'fill'        => false,
    ];
}
// Overall average dataset — average of subject averages (matches getWeightedAverage)
if (!empty($allGradesForAvg)) {
    usort($allGradesForAvg, fn($a, $b) => strcmp($a['graded_at'], $b['graded_at']));
    $avgData     = [];
    $subjSumW    = []; // subject_id => sumW
    $subjSumC    = []; // subject_id => sumC
    foreach ($allGradesForAvg as $g) {
        $sid   = $g['subject_id'];
        $coeff = (float) $g['coefficient'];
        $subjSumW[$sid] = ($subjSumW[$sid] ?? 0.0) + ($g['value'] / $g['max_value'] * 20) * $coeff;
        $subjSumC[$sid] = ($subjSumC[$sid] ?? 0.0) + $coeff;
        // Overall = simple mean of each subject's current weighted average
        $subjAvgs = [];
        foreach ($subjSumW as $s => $w) { $subjAvgs[] = $w / $subjSumC[$s]; }
        $avgData[] = ['x' => $g['graded_at'], 'y' => round(array_sum($subjAvgs) / count($subjAvgs), 2), 'name' => $g['name']];
    }
    $lineDatasets[] = [
        'label'       => 'Overall average',
        'data'        => $avgData,
        'borderColor' => '',
        'borderWidth' => 2.5,
        'borderDash'  => [6, 3],
        'fill'        => false,
        'isOverall'   => true,
    ];
}
?>
    <?php if (empty($grouped)): ?>
        <p class="empty">No grades yet.</p>
    <?php else: ?>
        <div class="sf-pills">
            <?php foreach ($grouped as $group): ?>
            <button class="sf-pill active" data-subject="<?= htmlspecialchars($group['subject_name'], ENT_QUOTES) ?>" data-color="<?= htmlspecialchars($group['subject_color'], ENT_QUOTES) ?>">
                <span class="sf-dot" style="background:<?= htmlspecialchars($group['subject_color'], ENT_QUOTES) ?>"></span>
                <?= htmlspecialchars($group['subject_name'], ENT_QUOTES) ?>
            </button>
            <?php endforeach; ?>
            <?php if (!empty($allGradesForAvg)): ?>
            <button class="sf-pill active" id="pill-overall" data-subject="Overall average" data-color="">
                <span class="sf-dot" id="dot-overall"></span>
                Overall average
            </button>
            <?php endif; ?>
        </div>
        <div class="chart-wrap">
            <div class="chart-label">Average progression</div>
            <?php if (!empty($lineDatasets)): ?>
                <div class="chart-canvas-wrap"><div id="chart-line" style="width:100%;height:100%;position:relative"></div></div>
            <?php else: ?>
                <p class="chart-empty">Add dates to your grades to see trends.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script>
(function () {
    var key = 'es_grades_tab';
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
    switchTab(localStorage.getItem(key) || 'subject');

    // Pagination — chronological tab
    (function() {
        var rows = Array.from(document.querySelectorAll('#panel-chrono .chrono-row'));
        var perPage = 50;
        var cur = 0;
        var total = Math.ceil(rows.length / perPage);
        if (total <= 1) return;

        function showPage(p) {
            cur = p;
            rows.forEach(function(r, i) {
                r.style.display = (i >= p * perPage && i < (p + 1) * perPage) ? '' : 'none';
            });
            var pg = document.getElementById('chrono-pagination');
            var html = '<button class="pg-btn" onclick="chronoGoTo(' + (cur-1) + ')"' + (cur===0?' disabled':'') + '>‹</button>';
            for (var i = 0; i < total; i++) {
                html += '<button class="pg-btn' + (i===cur?' active':'') + '" onclick="chronoGoTo(' + i + ')">' + (i+1) + '</button>';
            }
            html += '<button class="pg-btn" onclick="chronoGoTo(' + (cur+1) + ')"' + (cur===total-1?' disabled':'') + '>›</button>';
            pg.innerHTML = html;
            document.getElementById('chrono-pg-info').textContent = 'Page ' + (cur+1) + ' of ' + total;
        }

        window.chronoGoTo = function(p) {
            showPage(p);
            document.getElementById('panel-chrono').scrollIntoView({ behavior: 'smooth', block: 'start' });
        };
        showPage(0);
    })();
})();
</script>

<?php if (!empty($grouped)): ?>
<script>
(function () {
    var lineChart = null;

    function updateCharts() {
        var active = new Set();
        document.querySelectorAll('.sf-pill.active').forEach(function(p) { active.add(p.dataset.subject); });
        if (lineChart) {
            lineChart.data.datasets.forEach(function(ds) { ds.hidden = !active.has(ds.label); });
            lineChart.update();
        }
    }
    function applyPillStyle(pill) {
        var color = pill.dataset.color;
        if (pill.classList.contains('active')) {
            pill.style.borderColor = color;
            pill.style.background  = color + '22';
        } else {
            pill.style.borderColor = '';
            pill.style.background  = '';
        }
    }
    document.querySelectorAll('.sf-pill').forEach(function(pill) {
        applyPillStyle(pill);
        pill.addEventListener('click', function() {
            pill.classList.toggle('active');
            applyPillStyle(pill);
            updateCharts();
        });
    });

    <?php if (!empty($lineDatasets)): ?>
    (function () {
        var NS     = 'http://www.w3.org/2000/svg';
        var MONTHS = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        // Layout (margins fixed, W/H computed at render time)
        var ML=56, MR=20, MT=18, MB=46;
        var DAY = 86400000;

        var allDatasets = <?= json_encode(array_values($lineDatasets)) ?>;

        function overallColor() { return document.documentElement.classList.contains('dark') ? '#f1f5f9' : '#111827'; }
        function applyOverallColor() {
            var c = overallColor();
            allDatasets.forEach(function(ds) { if (ds.isOverall) ds.borderColor = c; });
            var pill = document.getElementById('pill-overall');
            if (pill) {
                pill.dataset.color = c;
                var dot = document.getElementById('dot-overall');
                if (dot) dot.style.background = c;
                // re-apply pill active style if active
                if (pill.classList.contains('active')) {
                    pill.style.borderColor = c;
                    pill.style.background  = c + '22';
                }
            }
        }
        applyOverallColor();

        new MutationObserver(function() {
            applyOverallColor();
            build();
        }).observe(document.documentElement, { attributeFilter: ['class'] });

        // --- Helpers ---
        function ts(s) { return new Date(s).getTime(); }
        function fmtFull(s) {
            var d = new Date(s);
            return d.getDate() + ' ' + MONTHS[d.getMonth()] + ' ' + d.getFullYear();
        }
        function fmtTick(t) {
            var d = new Date(t);
            return String(d.getDate()).padStart(2,'0') + '/' + String(d.getMonth()+1).padStart(2,'0');
        }

        function getXR() {
            var all = [];
            allDatasets.forEach(function(ds) {
                if (!ds.hidden) ds.data.forEach(function(p) { all.push(ts(p.x)); });
            });
            if (!all.length) return { min:0, span:1 };
            var mn=Math.min.apply(null,all), mx=Math.max.apply(null,all);
            var pad = Math.max((mx-mn)*0.05, DAY*5);
            return { min:mn-pad, span:(mx-mn)+2*pad };
        }

        function genXTicks(mn, span) {
            var mx = mn + span;
            var steps = [7,14,30,60,90,180,365].map(function(d){return d*DAY;});
            var step = steps[steps.length-1];
            for (var i=0;i<steps.length;i++) { if (span/steps[i]<=7){step=steps[i];break;} }
            var first = Math.ceil(mn/step)*step, ticks=[];
            for (var t=first;t<=mx;t+=step) ticks.push(t);
            return ticks;
        }

        // Catmull-Rom → cubic bezier (tension ~0.4, like Chart.js default)
        function smoothPath(pts) {
            if (!pts.length) return '';
            var d = 'M'+pts[0].x.toFixed(1)+','+pts[0].y.toFixed(1);
            for (var i=0;i<pts.length-1;i++) {
                var p0=pts[Math.max(0,i-1)], p1=pts[i], p2=pts[i+1], p3=pts[Math.min(pts.length-1,i+2)];
                var cp1x=(p1.x+(p2.x-p0.x)*0.4/3).toFixed(1), cp1y=(p1.y+(p2.y-p0.y)*0.4/3).toFixed(1);
                var cp2x=(p2.x-(p3.x-p1.x)*0.4/3).toFixed(1), cp2y=(p2.y-(p3.y-p1.y)*0.4/3).toFixed(1);
                d+=' C'+cp1x+','+cp1y+' '+cp2x+','+cp2y+' '+p2.x.toFixed(1)+','+p2.y.toFixed(1);
            }
            return d;
        }

        function E(tag, attrs) {
            var e = document.createElementNS(NS, tag);
            for (var k in attrs) e.setAttribute(k, attrs[k]);
            return e;
        }
        function T(tag, attrs, text) {
            var e = E(tag, attrs);
            e.textContent = text;
            return e;
        }

        // Tooltip — always dark like Chart.js
        var tipEl = document.createElement('div');
        tipEl.style.cssText = [
            'position:fixed', 'pointer-events:none', 'z-index:9999', 'display:none',
            'background:#111827', 'color:#f9fafb', 'border-radius:8px',
            'padding:.5rem .75rem', 'font-size:.78rem', 'line-height:1.7',
            'box-shadow:0 6px 24px rgba(0,0,0,.35)', 'white-space:nowrap',
            'min-width:140px'
        ].join(';');
        document.body.appendChild(tipEl);

        var svgRef = null, ptsMeta = [], crossEl = null;

        function build() {
            var container = document.getElementById('chart-line');
            if (!container) return;
            var dark   = document.documentElement.classList.contains('dark');
            var gridC  = dark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.13)';
            var axisC  = dark ? 'rgba(255,255,255,0.18)' : 'rgba(0,0,0,0.18)';
            var tickC  = dark ? '#9ca3af' : '#6b7280';
            var ptRing = dark ? '#1e293b' : '#ffffff';
            var W  = Math.max(container.clientWidth  || 600, 260);
            var H  = Math.max(container.clientHeight || 280, 160);
            var PW = W - ML - MR, PH = H - MT - MB;
            var xr = getXR();
            ptsMeta = [];

            // Dynamic Y range — guarantee minimum pixel gap between closest data points
            var allY = [];
            allDatasets.forEach(function(ds) {
                if (!ds.hidden) ds.data.forEach(function(p) { allY.push(p.y); });
            });
            var yMin, yMax, YTICKS;
            if (!allY.length) {
                yMin = 0; yMax = 20; YTICKS = [0, 5, 10, 15, 20];
            } else {
                var ymn = Math.min.apply(null, allY), ymx = Math.max.apply(null, allY);
                // Find minimum difference between distinct adjacent Y values
                var uniqY = allY.filter(function(v,i,a){return a.indexOf(v)===i;}).sort(function(a,b){return a-b;});
                var minDiff = ymx - ymn || 1;
                for (var i=1;i<uniqY.length;i++) { var d=uniqY[i]-uniqY[i-1]; if(d>0.01) minDiff=Math.min(minDiff,d); }
                // Visible range: minDiff must cover at least 14px
                var visRange = Math.min(Math.max(minDiff * PH / 14, ymx - ymn + 1.5), 20);
                var mid = (ymn + ymx) / 2;
                yMin = Math.max(0,  Math.floor(mid - visRange / 2));
                yMax = Math.min(20, Math.ceil(mid  + visRange / 2));
                if (yMax - yMin < 2) { yMin = Math.max(0, yMin - 1); yMax = Math.min(20, yMax + 1); }
                var range = yMax - yMin;
                var step  = range <= 3 ? 0.5 : range <= 6 ? 1 : range <= 12 ? 2 : range <= 16 ? 4 : 5;
                YTICKS = [];
                for (var t = Math.ceil(yMin / step) * step; t <= yMax + 0.001; t = Math.round((t + step) * 100) / 100) YTICKS.push(t);
                if (!YTICKS.length || YTICKS[0] > yMin) YTICKS.unshift(yMin);
                if (YTICKS[YTICKS.length-1] < yMax)     YTICKS.push(yMax);
            }

            function sx(s) { return xr.span===0 ? ML+PW/2 : ML+(ts(s)-xr.min)/xr.span*PW; }
            function sy(v) { return MT + (1 - (v - yMin) / (yMax - yMin)) * PH; }

            var svg = E('svg', { viewBox:'0 0 '+W+' '+H, width:'100%', height:'100%', style:'display:block' });

            // Clip path (keep lines inside plot)
            var defs = E('defs', {});
            var clip = E('clipPath', { id:'chart-clip' });
            clip.appendChild(E('rect', { x:ML, y:MT, width:PW, height:PH }));
            defs.appendChild(clip);
            svg.appendChild(defs);

            // Y gridlines + labels
            YTICKS.forEach(function(v) {
                var y = sy(v);
                svg.appendChild(E('line', { x1:ML, y1:y, x2:ML+PW, y2:y, stroke:gridC, 'stroke-width':1 }));
                svg.appendChild(T('text', { x:ML-10, y:y+4, 'text-anchor':'end', fill:tickC, 'font-size':11, 'font-family':'inherit' }, v+'/20'));
            });

            // X tick marks + labels (no vertical grid lines — cleaner)
            genXTicks(xr.min, xr.span).forEach(function(tick) {
                var x = ML+(tick-xr.min)/xr.span*PW;
                if (x<ML-1||x>ML+PW+1) return;
                svg.appendChild(E('line', { x1:x, y1:MT+PH, x2:x, y2:MT+PH+5, stroke:axisC, 'stroke-width':1 }));
                svg.appendChild(T('text', { x:x, y:MT+PH+18, 'text-anchor':'middle', fill:tickC, 'font-size':11, 'font-family':'inherit' }, fmtTick(tick)));
            });

            // Lines
            var linePaths = [];
            allDatasets.forEach(function(ds) {
                if (ds.hidden || ds.data.length < 2) return;
                var coords = ds.data.map(function(p){ return {x:sx(p.x),y:sy(p.y)}; });
                var attrs = {
                    d: smoothPath(coords), fill:'none',
                    stroke: ds.borderColor, 'stroke-width': ds.borderWidth || 2.5,
                    'stroke-linejoin':'round', 'stroke-linecap':'round',
                    'clip-path':'url(#chart-clip)'
                };
                if (ds.borderDash) attrs['stroke-dasharray'] = ds.borderDash.join(' ');
                var path = E('path', attrs);
                svg.appendChild(path);
                linePaths.push(path);
            });

            // Points (on top)
            allDatasets.forEach(function(ds) {
                if (ds.hidden) return;
                ds.data.forEach(function(p) {
                    var cx=sx(p.x), cy=sy(p.y);
                    var c = E('circle', { cx:cx.toFixed(1), cy:cy.toFixed(1), r:4, fill:ds.borderColor, stroke:ptRing, 'stroke-width':2 });
                    svg.appendChild(c);
                    ptsMeta.push({ cx:cx, cy:cy, ds:ds, pt:p, el:c });
                });
            });

            // Bottom axis
            svg.appendChild(E('line', { x1:ML, y1:MT+PH, x2:ML+PW, y2:MT+PH, stroke:axisC, 'stroke-width':1 }));

            // Hover overlay
            var ov = E('rect', { x:ML, y:MT, width:PW, height:PH, fill:'transparent', style:'cursor:default' });
            svg.appendChild(ov);

            var isTouch = false;

            function svgCoords(clientX, clientY) {
                var pt = svg.createSVGPoint();
                pt.x = clientX; pt.y = clientY;
                return pt.matrixTransform(svg.getScreenCTM().inverse());
            }
            function nearest(clientX, clientY, threshold) {
                var sp = svgCoords(clientX, clientY);
                var best = null, bestD = Infinity;
                ptsMeta.forEach(function(pm) {
                    var d = Math.sqrt(Math.pow(pm.cx - sp.x, 2) + Math.pow(pm.cy - sp.y, 2));
                    if (d < bestD) { bestD = d; best = pm; }
                });
                return bestD < threshold ? best : null;
            }
            function hideTip() {
                tipEl.style.display = 'none';
                ptsMeta.forEach(function(pm){ pm.el.setAttribute('r', 4); pm.el.setAttribute('stroke-width', 2); });
            }
            function showTip(best, clientX, clientY) {
                tipEl.innerHTML =
                    '<div style="font-size:.7rem;color:#9ca3af;margin-bottom:.1rem">' + fmtFull(best.pt.x) + '</div>' +
                    '<div style="display:flex;align-items:center;gap:.45rem;font-weight:600">' +
                        '<span style="width:10px;height:10px;border-radius:50%;background:' + best.ds.borderColor + ';flex-shrink:0"></span>' +
                        best.ds.label +
                    '</div>' +
                    '<div style="padding-left:1.45rem;color:#d1d5db;font-size:.76rem">avg&nbsp;<span style="color:#f9fafb;font-weight:700">' + best.pt.y + '/20</span></div>' +
                    (best.pt.name ? '<div style="padding-left:1.45rem;color:#6b7280;font-size:.71rem">after: ' + best.pt.name + '</div>' : '');
                tipEl.style.display = 'block';
                var tw = tipEl.offsetWidth || 180;
                var th = tipEl.offsetHeight || 70;
                var bx = clientX + 16;
                var by = clientY - 16;
                if (isTouch) { bx = clientX - tw / 2; by = clientY - th - 20; }
                if (bx + tw > window.innerWidth  - 8) bx = window.innerWidth  - tw - 8;
                if (bx < 8) bx = 8;
                if (by < 8) by = clientY + 20;
                tipEl.style.left = bx + 'px';
                tipEl.style.top  = by + 'px';
                ptsMeta.forEach(function(pm){ pm.el.setAttribute('r', 4); pm.el.setAttribute('stroke-width', 2); });
                best.el.setAttribute('r', 6);
                best.el.setAttribute('stroke-width', 2.5);
            }

            // Mouse
            ov.addEventListener('mousemove', function(e) {
                if (isTouch) return;
                var best = nearest(e.clientX, e.clientY, 28);
                if (!best) { hideTip(); return; }
                showTip(best, e.clientX, e.clientY);
            });
            ov.addEventListener('mouseleave', function() { if (!isTouch) hideTip(); });

            // Touch — larger threshold, tooltip above finger
            ov.addEventListener('touchstart', function(e) {
                isTouch = true;
                var t = e.touches[0];
                var best = nearest(t.clientX, t.clientY, 60);
                if (best) { showTip(best, t.clientX, t.clientY); e.preventDefault(); }
                else hideTip();
            }, { passive: false });
            ov.addEventListener('touchmove', function(e) {
                var t = e.touches[0];
                var best = nearest(t.clientX, t.clientY, 60);
                if (best) { showTip(best, t.clientX, t.clientY); e.preventDefault(); }
                else hideTip();
            }, { passive: false });
            ov.addEventListener('touchend', function() {
                setTimeout(hideTip, 2000);
            });

            // Render
            container.innerHTML = '';
            container.appendChild(svg);
            svgRef = svg;

            // Draw animation
            requestAnimationFrame(function() {
                linePaths.forEach(function(p) {
                    var len = p.getTotalLength();
                    p.style.strokeDasharray = len;
                    p.style.strokeDashoffset = len;
                    p.style.transition = 'none';
                    requestAnimationFrame(function() {
                        p.style.transition = 'stroke-dashoffset 0.9s cubic-bezier(0.4,0,0.2,1)';
                        p.style.strokeDashoffset = '0';
                    });
                });
            });

        }

        build();

        // Rebuild on resize
        if (typeof ResizeObserver !== 'undefined') {
            var _rto = null;
            new ResizeObserver(function() {
                clearTimeout(_rto);
                _rto = setTimeout(build, 60);
            }).observe(document.getElementById('chart-line'));
        }

        lineChart = { data: { datasets: allDatasets }, update: build };
    })();
    <?php endif; ?>

})();
</script>
<?php endif; ?>
