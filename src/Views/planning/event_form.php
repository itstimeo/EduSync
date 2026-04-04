<style>
.breadcrumb{font-size:.85rem;color:var(--text-muted);max-width:520px;margin:0 auto 1.25rem}
.breadcrumb a{color:#6366f1;text-decoration:none}
.form-card{background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:1.5rem;max-width:520px;margin:0 auto}
.form-card h1{font-size:1.1rem;font-weight:700;margin-bottom:1.25rem}
.field{margin-bottom:1.1rem}
.field label{display:block;font-size:.875rem;font-weight:500;margin-bottom:.35rem;color:var(--text)}
.field input[type="text"],.field select,.field textarea{width:100%;padding:.5rem .75rem;border:1px solid var(--border-soft);border-radius:6px;font-size:.9rem;font-family:inherit}
.field input:focus,.field select:focus,.field textarea:focus{outline:none;border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.field textarea{resize:vertical;min-height:80px}
.row-2{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}
.form-actions{display:flex;gap:.75rem;margin-top:1.4rem}
.req{color:#ef4444;margin-left:2px}
.field-err{display:none;font-size:.78rem;color:#ef4444;margin-top:.3rem}
.field-err.show{display:block}
.field-invalid{border-color:#ef4444!important;box-shadow:0 0 0 3px rgba(239,68,68,.1)!important}
.req-note{font-size:.78rem;color:var(--text-subtle);margin-top:1.25rem}
/* Custom type dropdown */
.cd-wrap{position:relative}
.cd-btn{display:flex;align-items:center;gap:.55rem;padding:.5rem .75rem;border:1px solid var(--border-soft);border-radius:6px;background:var(--input-bg);cursor:pointer;font-size:.9rem;color:var(--text);user-select:none}
.cd-btn:focus{outline:none;border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.cd-wrap.open .cd-btn{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.cd-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0}
.cd-label{flex:1}
.cd-arrow{margin-left:auto;font-size:.7rem;color:var(--text-subtle)}
.cd-list{position:absolute;top:calc(100% + 4px);left:0;right:0;background:var(--surface);border:1px solid var(--border);border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,.1);z-index:100;padding:.3rem;display:none;max-height:200px;overflow-y:auto}
.cd-wrap.open .cd-list{display:block}
.cd-item{display:flex;align-items:center;gap:.55rem;padding:.45rem .65rem;border-radius:5px;cursor:pointer;font-size:.875rem;color:var(--text)}
.cd-item:hover,.cd-item.selected{background:var(--purple-tint);color:#6366f1}
/* Date picker */
.dp-wrap{position:relative}
.dp-trigger{display:flex;align-items:center;border:1px solid var(--border-soft);border-radius:6px;background:var(--input-bg);overflow:hidden;cursor:pointer}
.dp-trigger:focus-within,.dp-wrap.open .dp-trigger{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.dp-trigger.dp-invalid{border-color:#ef4444!important;box-shadow:0 0 0 3px rgba(239,68,68,.1)!important}
.dp-display{flex:1;padding:.5rem .75rem;border:none;font-size:.9rem;background:transparent;cursor:pointer;color:var(--text);caret-color:transparent;outline:none}
.dp-display::placeholder{color:var(--text-subtle)}
.dp-icon{padding:.5rem .75rem;color:var(--text-subtle);border-left:1px solid var(--border);display:flex;align-items:center}
.dp-clear{padding:.5rem .5rem;color:var(--text-subtle);font-size:.8rem;display:flex;align-items:center;cursor:pointer}
.dp-clear:hover{color:#ef4444}
.dp-calendar{position:absolute;top:calc(100% + 4px);left:0;background:var(--surface);border:1px solid var(--border);border-radius:10px;box-shadow:0 4px 20px rgba(0,0,0,.1);z-index:101;padding:.75rem;width:260px;display:none}
.dp-wrap.open .dp-calendar{display:block}
.dp-nav{display:flex;align-items:center;justify-content:space-between;margin-bottom:.6rem}
.dp-nav-btn{background:none;border:none;cursor:pointer;padding:.25rem .4rem;border-radius:5px;color:var(--text);font-size:.95rem;line-height:1}
.dp-nav-btn:hover{background:var(--bg-subtle)}
.dp-month-label{font-size:.875rem;font-weight:600;color:var(--text)}
.dp-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:2px}
.dp-dow{font-size:.7rem;color:var(--text-subtle);text-align:center;font-weight:600;padding:.25rem 0}
.dp-day{font-size:.8rem;text-align:center;padding:.3rem .1rem;border-radius:5px;cursor:pointer;color:var(--text)}
.dp-day:hover{background:var(--bg-subtle)}
.dp-day.today{color:#6366f1;font-weight:700}
.dp-day.selected{background:#6366f1;color:#fff;font-weight:700}
.dp-day.other-month{color:var(--border-soft)}
@media (max-width: 640px) {
    .row-2 { grid-template-columns: 1fr; }
    .dp-calendar { width: min(260px, calc(100vw - 2rem)); }
}
</style>

<?php
$typeColors   = $typeColors ?? [];
$currentType  = $event['type'] ?? 'other';
$currentColor = $event['color'] ?? ($typeColors[$currentType]['color'] ?? '#6366f1');
?>

<div style="display:flex;align-items:center;gap:.75rem;max-width:520px;margin:0 auto 1.25rem;">
    <a href="/planning" class="btn-back" title="Back"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
    <p class="breadcrumb" style="margin:0;max-width:none;"><a href="/planning">Planning</a> › <?= $event ? 'Edit' : 'New event' ?></p>
</div>

<div class="form-card">
    <h1><?= $event ? 'Edit event' : 'New event' ?></h1>
    <form method="post" action="<?= $event ? '/planning/edit' : '/planning/create' ?>" id="event-form" novalidate>
        <?php if ($event): ?>
            <input type="hidden" name="id" value="<?= (int)$event['id'] ?>">
        <?php endif; ?>

        <div class="field">
            <label for="title">Title <span class="req">*</span></label>
            <input type="text" id="title" name="title" maxlength="200" autofocus
                   value="<?= htmlspecialchars($event['title'] ?? '', ENT_QUOTES) ?>">
            <span class="field-err" id="err-title">Please enter a title.</span>
        </div>

        <div class="row-2">
            <div class="field">
                <label>Type <span class="req">*</span></label>
                <input type="hidden" name="type" id="type-hidden" value="<?= htmlspecialchars($currentType, ENT_QUOTES) ?>">
                <div class="cd-wrap" id="cd-type-wrap">
                    <div class="cd-btn" id="cd-type-btn" tabindex="0">
                        <span class="cd-dot" id="cd-type-dot" style="background:<?= htmlspecialchars($currentColor, ENT_QUOTES) ?>"></span>
                        <span class="cd-label" id="cd-type-label"><?= htmlspecialchars($typeColors[$currentType]['label'] ?? ucfirst($currentType), ENT_QUOTES) ?></span>
                        <span class="cd-arrow">▼</span>
                    </div>
                    <div class="cd-list" id="cd-type-list">
                        <?php foreach ($typeColors as $val => $info): ?>
                            <div class="cd-item<?= $currentType === $val ? ' selected' : '' ?>"
                                 data-value="<?= htmlspecialchars($val, ENT_QUOTES) ?>"
                                 data-color="<?= htmlspecialchars($info['color'], ENT_QUOTES) ?>"
                                 data-label="<?= htmlspecialchars($info['label'], ENT_QUOTES) ?>">
                                <span class="cd-dot" style="background:<?= htmlspecialchars($info['color'], ENT_QUOTES) ?>"></span>
                                <?= htmlspecialchars($info['label'], ENT_QUOTES) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <label>Color</label>
                <?php
                    $colorPickerName  = 'color';
                    $colorPickerValue = $currentColor;
                    include __DIR__ . '/../courses/_color_picker.php';
                ?>
            </div>
        </div>

        <div class="row-2">
            <div class="field">
                <label>Start date <span class="req">*</span></label>
                <input type="hidden" name="start_date" id="dp-start-value" value="<?= htmlspecialchars($event['start_date'] ?? $prefillDate ?? '', ENT_QUOTES) ?>">
                <div class="dp-wrap" id="dp-start-wrap">
                    <div class="dp-trigger" id="dp-start-trigger">
                        <input type="text" class="dp-display" id="dp-start-display" placeholder="dd/mm/yyyy" readonly>
                        <span class="dp-clear" id="dp-start-clear" title="Clear" style="display:none">✕</span>
                        <span class="dp-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
                    </div>
                    <div class="dp-calendar" id="dp-start-cal">
                        <div class="dp-nav">
                            <button type="button" class="dp-nav-btn" id="dp-start-prev">&#8249;</button>
                            <span class="dp-month-label" id="dp-start-label"></span>
                            <button type="button" class="dp-nav-btn" id="dp-start-next">&#8250;</button>
                        </div>
                        <div class="dp-grid" id="dp-start-grid"></div>
                    </div>
                </div>
                <span class="field-err" id="err-start">Please select a start date.</span>
            </div>
            <div class="field">
                <label>End date <span style="font-weight:400;color:#9ca3af">(optional)</span></label>
                <input type="hidden" name="end_date" id="dp-end-value" value="<?= htmlspecialchars($event['end_date'] ?? '', ENT_QUOTES) ?>">
                <div class="dp-wrap" id="dp-end-wrap">
                    <div class="dp-trigger" id="dp-end-trigger">
                        <input type="text" class="dp-display" id="dp-end-display" placeholder="dd/mm/yyyy" readonly>
                        <span class="dp-clear" id="dp-end-clear" title="Clear" style="display:none">✕</span>
                        <span class="dp-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
                    </div>
                    <div class="dp-calendar" id="dp-end-cal">
                        <div class="dp-nav">
                            <button type="button" class="dp-nav-btn" id="dp-end-prev">&#8249;</button>
                            <span class="dp-month-label" id="dp-end-label"></span>
                            <button type="button" class="dp-nav-btn" id="dp-end-next">&#8250;</button>
                        </div>
                        <div class="dp-grid" id="dp-end-grid"></div>
                    </div>
                </div>
                <span class="field-err" id="err-end">End date must be on or after start date.</span>
            </div>
        </div>

        <div class="field">
            <label for="description">Description <span style="font-weight:400;color:#9ca3af">(optional)</span></label>
            <textarea id="description" name="description" maxlength="1000"><?= htmlspecialchars($event['description'] ?? '', ENT_QUOTES) ?></textarea>
        </div>

        <p class="req-note"><span class="req">*</span> Required</p>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

<script>
(function () {
    // PHP-injected initial dates — substr(0,10) strips time part from DATETIME columns
    var _dpStartVal = <?= json_encode(
        $event && !empty($event['start_date'])
            ? substr($event['start_date'], 0, 10)
            : ($prefillDate ?: null)
    ) ?>;
    var _dpEndVal = <?= json_encode(
        $event && !empty($event['end_date']) && $event['end_date'] !== '0000-00-00'
            ? substr($event['end_date'], 0, 10)
            : null
    ) ?>;

    // Sync hidden inputs in case the attribute was not properly read
    (function () {
        var hs = document.getElementById('dp-start-value');
        var he = document.getElementById('dp-end-value');
        if (hs && !hs.value && _dpStartVal) hs.value = _dpStartVal;
        if (he && !he.value && _dpEndVal)   he.value = _dpEndVal;
    })();

    // ── Custom type dropdown ────────────────────────────────────
    var typeColors = <?= json_encode(array_map(fn($t) => $t['color'], $typeColors)) ?>;
    (function () {
        var wrap   = document.getElementById('cd-type-wrap');
        var btn    = document.getElementById('cd-type-btn');
        var dot    = document.getElementById('cd-type-dot');
        var lbl    = document.getElementById('cd-type-label');
        var hidden = document.getElementById('type-hidden');
        var list   = document.getElementById('cd-type-list');

        function open()  { wrap.classList.add('open'); }
        function close() { wrap.classList.remove('open'); }

        btn.addEventListener('click', function () {
            wrap.classList.contains('open') ? close() : open();
        });
        btn.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); wrap.classList.contains('open') ? close() : open(); }
            if (e.key === 'Escape') close();
        });
        document.addEventListener('click', function (e) {
            if (!wrap.contains(e.target)) close();
        });

        list.querySelectorAll('.cd-item').forEach(function (item) {
            item.addEventListener('click', function () {
                var val   = this.dataset.value;
                var color = this.dataset.color;
                var label = this.dataset.label;
                hidden.value = val;
                dot.style.background = color;
                lbl.textContent = label;
                list.querySelectorAll('.cd-item').forEach(function (i) { i.classList.remove('selected'); });
                this.classList.add('selected');
                if (typeof cpPick === 'function') cpPick('cp_color', color);
                close();
            });
        });
    })();

    // ── Date picker factory ────────────────────────────────────
    var months = ['January','February','March','April','May','June',
                  'July','August','September','October','November','December'];
    var dows   = ['Mo','Tu','We','Th','Fr','Sa','Su'];
    var today  = new Date(); today.setHours(0,0,0,0);

    function pad(n) { return n < 10 ? '0' + n : '' + n; }

    function makePicker(cfg) {
        var wrap    = document.getElementById(cfg.wrap);
        var trigger = document.getElementById(cfg.trigger);
        var display = document.getElementById(cfg.display);
        var hidden  = document.getElementById(cfg.hidden);
        var clear   = document.getElementById(cfg.clear);
        var label   = document.getElementById(cfg.label);
        var grid    = document.getElementById(cfg.grid);
        var prevBtn = document.getElementById(cfg.prev);
        var nextBtn = document.getElementById(cfg.next);

        var selected = null, viewYear, viewMonth;
        // Use PHP-injected value as primary source, hidden.value as fallback
        var phpVal = cfg.phpInitVal !== undefined ? cfg.phpInitVal : null;
        var init   = phpVal || hidden.value || '';
        if (init && hidden.value !== init) hidden.value = init; // sync
        if (init && /^\d{4}-\d{2}-\d{2}$/.test(init)) {
            var p = init.split('-');
            selected = new Date(+p[0], +p[1]-1, +p[2]);
            if (!isNaN(selected.getTime())) {
                viewYear  = selected.getFullYear();
                viewMonth = selected.getMonth();
                display.value = pad(selected.getDate()) + '/' + pad(selected.getMonth()+1) + '/' + selected.getFullYear();
                clear.style.display = 'flex';
            } else {
                selected = null;
                viewYear = today.getFullYear();
                viewMonth = today.getMonth();
            }
        } else {
            viewYear  = today.getFullYear();
            viewMonth = today.getMonth();
        }

        function render() {
            label.textContent = months[viewMonth] + ' ' + viewYear;
            grid.innerHTML = '';
            dows.forEach(function(d){ var el=document.createElement('div'); el.className='dp-dow'; el.textContent=d; grid.appendChild(el); });
            var startDow = (new Date(viewYear, viewMonth, 1).getDay() + 6) % 7;
            var prevDays = new Date(viewYear, viewMonth, 0).getDate();
            for (var i=startDow-1; i>=0; i--) { var el=document.createElement('div'); el.className='dp-day other-month'; el.textContent=prevDays-i; grid.appendChild(el); }
            var dim = new Date(viewYear, viewMonth+1, 0).getDate();
            for (var d=1; d<=dim; d++) {
                var el = document.createElement('div'); el.className='dp-day'; el.textContent=d;
                var date = new Date(viewYear, viewMonth, d);
                if (date.getTime()===today.getTime()) el.classList.add('today');
                if (selected && date.getTime()===selected.getTime()) el.classList.add('selected');
                (function(date,el){ el.addEventListener('click', function(){
                    selected = date;
                    hidden.value = date.getFullYear()+'-'+pad(date.getMonth()+1)+'-'+pad(date.getDate());
                    display.value = pad(date.getDate())+'/'+pad(date.getMonth()+1)+'/'+date.getFullYear();
                    clear.style.display='flex';
                    trigger.classList.remove('dp-invalid');
                    document.getElementById(cfg.err).classList.remove('show');
                    close();
                }); })(date,el);
                grid.appendChild(el);
            }
            var filled=startDow+dim, rem=filled%7===0?0:7-(filled%7);
            for (var n=1; n<=rem; n++) { var el=document.createElement('div'); el.className='dp-day other-month'; el.textContent=n; grid.appendChild(el); }
        }

        function open()  { wrap.classList.add('open'); render(); }
        function close() { wrap.classList.remove('open'); }

        trigger.addEventListener('click', function(e){
            if (e.target===clear||clear.contains(e.target)) return;
            wrap.classList.contains('open') ? close() : open();
        });
        prevBtn.addEventListener('click', function(){ viewMonth--; if(viewMonth<0){viewMonth=11;viewYear--;} render(); });
        nextBtn.addEventListener('click', function(){ viewMonth++; if(viewMonth>11){viewMonth=0;viewYear++;} render(); });
        clear.addEventListener('click', function(e){
            e.stopPropagation();
            selected=null; hidden.value=''; display.value=''; clear.style.display='none'; close();
        });
        document.addEventListener('click', function(e){ if(!wrap.contains(e.target)) close(); });

        return { getValue: function(){ return hidden.value; } };
    }

    var dpStart = makePicker({
        wrap:'dp-start-wrap', trigger:'dp-start-trigger', display:'dp-start-display',
        hidden:'dp-start-value', clear:'dp-start-clear', label:'dp-start-label',
        grid:'dp-start-grid', prev:'dp-start-prev', next:'dp-start-next', err:'err-start',
        phpInitVal: _dpStartVal
    });
    var dpEnd = makePicker({
        wrap:'dp-end-wrap', trigger:'dp-end-trigger', display:'dp-end-display',
        hidden:'dp-end-value', clear:'dp-end-clear', label:'dp-end-label',
        grid:'dp-end-grid', prev:'dp-end-prev', next:'dp-end-next', err:'err-end',
        phpInitVal: _dpEndVal
    });

    // ── Validation ─────────────────────────────────────────────
    var titleEl = document.getElementById('title');
    titleEl.addEventListener('input', function(){
        titleEl.classList.remove('field-invalid');
        document.getElementById('err-title').classList.remove('show');
    });

    document.getElementById('event-form').addEventListener('submit', function(e) {
        var valid = true;

        if (!titleEl.value.trim()) {
            titleEl.classList.add('field-invalid');
            document.getElementById('err-title').classList.add('show');
            valid = false;
        }

        var startVal = document.getElementById('dp-start-value').value;
        if (!startVal) {
            document.getElementById('dp-start-trigger').classList.add('dp-invalid');
            document.getElementById('err-start').classList.add('show');
            valid = false;
        }

        var endVal = document.getElementById('dp-end-value').value;
        if (endVal && startVal && endVal < startVal) {
            document.getElementById('dp-end-trigger').classList.add('dp-invalid');
            document.getElementById('err-end').classList.add('show');
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
            var first = document.querySelector('.field-invalid, .dp-invalid, .field-err.show');
            if (first) first.scrollIntoView({behavior:'smooth', block:'center'});
        }
    });
})();
</script>
