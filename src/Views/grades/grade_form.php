<style>
.breadcrumb{font-size:.85rem;color:#6b7280;max-width:520px;margin:0 auto 1.25rem}
.breadcrumb a{color:#6366f1;text-decoration:none}
.form-card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:1.5rem;max-width:520px;margin:0 auto}
.form-card h1{font-size:1.1rem;font-weight:700;margin-bottom:1.25rem}
.field{margin-bottom:1.1rem}
.field label{display:block;font-size:.875rem;font-weight:500;margin-bottom:.35rem;color:#374151}
.field input[type="text"],.field input[type="number"],.field textarea{width:100%;padding:.5rem .75rem;border:1px solid #d1d5db;border-radius:6px;font-size:.9rem;font-family:inherit}
.field input:focus,.field textarea:focus{outline:none;border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.field textarea{resize:vertical;min-height:80px}
.row-2{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}
.form-actions{display:flex;gap:.75rem;margin-top:1.4rem}
.btn{display:inline-flex;align-items:center;padding:.5rem 1.1rem;border-radius:6px;font-size:.875rem;font-weight:500;text-decoration:none;cursor:pointer;border:none}
.btn-primary{background:#6366f1;color:#fff}.btn-primary:hover{background:#4f46e5}
.btn-secondary{background:#f3f4f6;color:#374151}.btn-secondary:hover{background:#e5e7eb}

/* Validation */
.req{color:#ef4444;margin-left:2px}
.field-err{display:none;font-size:.78rem;color:#ef4444;margin-top:.3rem}
.field-err.show{display:block}
.field-invalid{border-color:#ef4444!important;box-shadow:0 0 0 3px rgba(239,68,68,.1)!important}
.cs-invalid .cs-trigger{border-color:#ef4444!important;box-shadow:0 0 0 3px rgba(239,68,68,.1)!important}
.req-note{font-size:.78rem;color:#9ca3af;margin-top:1.25rem}

/* Custom select */
.cs-wrap{position:relative;user-select:none}
.cs-trigger{display:flex;align-items:center;gap:.6rem;padding:.5rem .75rem;border:1px solid #d1d5db;border-radius:6px;background:#fff;cursor:pointer;font-size:.9rem;min-height:2.15rem}
.cs-trigger:focus{outline:none;border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.cs-wrap.open .cs-trigger{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.cs-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;background:#d1d5db}
.cs-label{flex:1;color:#1a1a1a}
.cs-label.placeholder{color:#9ca3af}
.cs-arrow{color:#9ca3af;font-size:.75rem;transition:transform .15s}
.cs-wrap.open .cs-arrow{transform:rotate(180deg)}
.cs-dropdown{position:absolute;top:calc(100% + 4px);left:0;right:0;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,.1);z-index:100;max-height:220px;overflow-y:auto;display:none}
.cs-wrap.open .cs-dropdown{display:block}
.cs-option{display:flex;align-items:center;gap:.6rem;padding:.55rem .75rem;cursor:pointer;font-size:.875rem}
.cs-option:hover{background:#f5f3ff}
.cs-option.selected{background:#ede9fe;font-weight:600}

/* Custom date picker */
.dp-wrap{position:relative}
.dp-trigger{display:flex;align-items:center;border:1px solid #d1d5db;border-radius:6px;background:#fff;overflow:hidden;cursor:pointer}
.dp-trigger:focus-within{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.dp-wrap.open .dp-trigger{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.dp-display{flex:1;padding:.5rem .75rem;border:none;font-size:.9rem;background:transparent;cursor:pointer;color:#1a1a1a;caret-color:transparent;outline:none}
.dp-display::placeholder{color:#9ca3af}
.dp-icon{padding:.5rem .75rem;color:#9ca3af;font-size:.95rem;border-left:1px solid #e5e7eb;display:flex;align-items:center}
.dp-clear{padding:.5rem .5rem;color:#9ca3af;font-size:.8rem;display:flex;align-items:center;cursor:pointer}
.dp-clear:hover{color:#ef4444}
.dp-calendar{position:absolute;top:calc(100% + 4px);left:0;background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 4px 20px rgba(0,0,0,.1);z-index:101;padding:.75rem;width:260px;display:none}
.dp-wrap.open .dp-calendar{display:block}
.dp-nav{display:flex;align-items:center;justify-content:space-between;margin-bottom:.6rem}
.dp-nav-btn{background:none;border:none;cursor:pointer;padding:.25rem .4rem;border-radius:5px;color:#374151;font-size:.95rem;line-height:1}
.dp-nav-btn:hover{background:#f3f4f6}
.dp-month-label{font-size:.875rem;font-weight:600;color:#1a1a1a}
.dp-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:2px}
.dp-dow{font-size:.7rem;color:#9ca3af;text-align:center;font-weight:600;padding:.25rem 0}
.dp-day{font-size:.8rem;text-align:center;padding:.3rem .1rem;border-radius:5px;cursor:pointer;color:#374151}
.dp-day:hover{background:#f3f4f6}
.dp-day.today{color:#6366f1;font-weight:700}
.dp-day.selected{background:#6366f1;color:#fff;font-weight:700}
.dp-day.other-month{color:#d1d5db}
</style>

<p class="breadcrumb"><a href="/grades">Grades</a> › <?= $grade ? 'Edit' : 'New grade' ?></p>

<div class="form-card">
    <h1><?= $grade ? 'Edit grade' : 'New grade' ?></h1>
    <form method="post" action="<?= $grade ? '/grades/edit' : '/grades/create' ?>" id="grade-form" novalidate>
        <?php if ($grade): ?>
            <input type="hidden" name="id" value="<?= (int)$grade['id'] ?>">
        <?php endif; ?>

        <?php
            $selectedSubjectId    = (int) ($grade['subject_id'] ?? 0);
            $selectedSubjectName  = '';
            $selectedSubjectColor = '';
            foreach ($subjects as $s) {
                if ((int)$s['id'] === $selectedSubjectId) {
                    $selectedSubjectName  = $s['name'];
                    $selectedSubjectColor = $s['color'];
                    break;
                }
            }
        ?>

        <div class="field">
            <label>Subject <span class="req">*</span></label>
            <input type="hidden" name="subject_id" id="cs-value" value="<?= $selectedSubjectId ?: '' ?>">
            <div class="cs-wrap" id="cs-wrap">
                <div class="cs-trigger" tabindex="0" id="cs-trigger" role="combobox" aria-expanded="false">
                    <span class="cs-dot" id="cs-dot" style="<?= $selectedSubjectColor ? 'background:' . htmlspecialchars($selectedSubjectColor, ENT_QUOTES) : '' ?>"></span>
                    <span class="cs-label<?= $selectedSubjectName ? '' : ' placeholder' ?>" id="cs-label"><?= $selectedSubjectName ? htmlspecialchars($selectedSubjectName, ENT_QUOTES) : '— select —' ?></span>
                    <span class="cs-arrow">▾</span>
                </div>
                <div class="cs-dropdown" id="cs-dropdown" role="listbox">
                    <?php foreach ($subjects as $s): ?>
                        <div class="cs-option<?= (int)$s['id'] === $selectedSubjectId ? ' selected' : '' ?>"
                             data-value="<?= (int)$s['id'] ?>"
                             data-color="<?= htmlspecialchars($s['color'], ENT_QUOTES) ?>"
                             data-label="<?= htmlspecialchars($s['name'], ENT_QUOTES) ?>"
                             role="option">
                            <span class="cs-dot" style="background:<?= htmlspecialchars($s['color'], ENT_QUOTES) ?>"></span>
                            <span><?= htmlspecialchars($s['name'], ENT_QUOTES) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <span class="field-err" id="err-subject">Please select a subject.</span>
        </div>

        <div class="field">
            <label for="name">Name <span class="req">*</span></label>
            <input type="text" id="name" name="name" maxlength="200" autofocus
                   value="<?= htmlspecialchars($grade['name'] ?? '', ENT_QUOTES) ?>">
            <span class="field-err" id="err-name">Please enter a name.</span>
        </div>

        <div class="row-2">
            <div class="field">
                <label for="value">Grade <span class="req">*</span></label>
                <input type="number" id="value" name="value" step="0.01" min="0"
                       value="<?= htmlspecialchars($grade['value'] ?? '', ENT_QUOTES) ?>">
                <span class="field-err" id="err-value">Please enter a grade.</span>
            </div>
            <div class="field">
                <label for="max_value">Out of <span class="req">*</span></label>
                <input type="number" id="max_value" name="max_value" step="0.01" min="0.01"
                       value="<?= htmlspecialchars($grade['max_value'] ?? '20', ENT_QUOTES) ?>">
                <span class="field-err" id="err-max_value">Please enter a max value.</span>
            </div>
        </div>

        <div class="row-2">
            <div class="field">
                <label for="coefficient">Coefficient <span class="req">*</span></label>
                <input type="number" id="coefficient" name="coefficient" step="0.1" min="0.1"
                       value="<?= htmlspecialchars($grade['coefficient'] ?? '1', ENT_QUOTES) ?>">
                <span class="field-err" id="err-coefficient">Please enter a coefficient.</span>
            </div>
            <div class="field">
                <label>Date</label>
                <input type="hidden" name="graded_at" id="dp-value" value="<?= htmlspecialchars($grade['graded_at'] ?? '', ENT_QUOTES) ?>">
                <div class="dp-wrap" id="dp-wrap">
                    <div class="dp-trigger" id="dp-trigger">
                        <input type="text" class="dp-display" id="dp-display" placeholder="dd/mm/yyyy" readonly>
                        <span class="dp-clear" id="dp-clear" title="Clear" style="display:<?= !empty($grade['graded_at']) ? 'flex' : 'none' ?>">✕</span>
                        <span class="dp-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </span>
                    </div>
                    <div class="dp-calendar" id="dp-calendar">
                        <div class="dp-nav">
                            <button type="button" class="dp-nav-btn" id="dp-prev">&#8249;</button>
                            <span class="dp-month-label" id="dp-month-label"></span>
                            <button type="button" class="dp-nav-btn" id="dp-next">&#8250;</button>
                        </div>
                        <div class="dp-grid" id="dp-grid"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="field">
            <label for="comment">Comment</label>
            <textarea id="comment" name="comment" maxlength="1000"><?= htmlspecialchars($grade['comment'] ?? '', ENT_QUOTES) ?></textarea>
        </div>

        <p class="req-note"><span class="req">*</span> Required</p>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="/grades" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
(function () {
    // ── Custom select ──────────────────────────────────────────
    var csWrap    = document.getElementById('cs-wrap');
    var csTrigger = document.getElementById('cs-trigger');
    var csDot     = document.getElementById('cs-dot');
    var csLabel   = document.getElementById('cs-label');
    var csValue   = document.getElementById('cs-value');
    var options   = csWrap.querySelectorAll('.cs-option');

    function csOpen()  { csWrap.classList.add('open'); csTrigger.setAttribute('aria-expanded','true'); }
    function csClose() { csWrap.classList.remove('open'); csTrigger.setAttribute('aria-expanded','false'); }
    function csToggle(){ csWrap.classList.contains('open') ? csClose() : csOpen(); }

    csTrigger.addEventListener('click', csToggle);
    csTrigger.addEventListener('keydown', function(e){
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); csToggle(); }
        if (e.key === 'Escape') csClose();
    });

    options.forEach(function(opt) {
        opt.addEventListener('click', function() {
            csValue.value = opt.dataset.value;
            csDot.style.background = opt.dataset.color;
            csLabel.textContent = opt.dataset.label;
            csLabel.classList.remove('placeholder');
            options.forEach(function(o){ o.classList.toggle('selected', o === opt); });
            clearErr('cs-wrap', 'err-subject', true);
            csClose();
        });
    });

    document.addEventListener('click', function(e){
        if (!csWrap.contains(e.target)) csClose();
    });

    // ── Custom date picker ─────────────────────────────────────
    var dpWrap    = document.getElementById('dp-wrap');
    var dpDisplay = document.getElementById('dp-display');
    var dpValue   = document.getElementById('dp-value');
    var dpClear   = document.getElementById('dp-clear');
    var dpLabel   = document.getElementById('dp-month-label');
    var dpGrid    = document.getElementById('dp-grid');

    var months = ['January','February','March','April','May','June',
                  'July','August','September','October','November','December'];
    var dows   = ['Mo','Tu','We','Th','Fr','Sa','Su'];
    var today  = new Date(); today.setHours(0,0,0,0);
    var selected = null, viewYear, viewMonth;

    var initVal = dpValue.value;
    if (initVal) {
        var parts = initVal.split('-');
        selected  = new Date(+parts[0], +parts[1]-1, +parts[2]);
        viewYear  = selected.getFullYear();
        viewMonth = selected.getMonth();
        dpDisplay.value = pad(selected.getDate()) + '/' + pad(selected.getMonth()+1) + '/' + selected.getFullYear();
    } else {
        viewYear  = today.getFullYear();
        viewMonth = today.getMonth();
    }

    function pad(n){ return n < 10 ? '0'+n : ''+n; }

    function renderCalendar() {
        dpLabel.textContent = months[viewMonth] + ' ' + viewYear;
        dpGrid.innerHTML = '';
        dows.forEach(function(d){ var el=document.createElement('div'); el.className='dp-dow'; el.textContent=d; dpGrid.appendChild(el); });
        var startDow = (new Date(viewYear, viewMonth, 1).getDay() + 6) % 7;
        var prevDays = new Date(viewYear, viewMonth, 0).getDate();
        for (var i = startDow-1; i >= 0; i--) { var el=document.createElement('div'); el.className='dp-day other-month'; el.textContent=prevDays-i; dpGrid.appendChild(el); }
        var dim = new Date(viewYear, viewMonth+1, 0).getDate();
        for (var d = 1; d <= dim; d++) {
            var el = document.createElement('div'); el.className='dp-day'; el.textContent=d;
            var date = new Date(viewYear, viewMonth, d);
            if (date.getTime()===today.getTime()) el.classList.add('today');
            if (selected && date.getTime()===selected.getTime()) el.classList.add('selected');
            (function(date,el){ el.addEventListener('click', function(){
                selected=date;
                dpValue.value=date.getFullYear()+'-'+pad(date.getMonth()+1)+'-'+pad(date.getDate());
                dpDisplay.value=pad(date.getDate())+'/'+pad(date.getMonth()+1)+'/'+date.getFullYear();
                dpClear.style.display='flex'; dpClose();
            }); })(date,el);
            dpGrid.appendChild(el);
        }
        var filled=startDow+dim, rem=filled%7===0?0:7-(filled%7);
        for (var n=1; n<=rem; n++) { var el=document.createElement('div'); el.className='dp-day other-month'; el.textContent=n; dpGrid.appendChild(el); }
    }

    function dpOpen()  { dpWrap.classList.add('open'); renderCalendar(); }
    function dpClose() { dpWrap.classList.remove('open'); }

    document.getElementById('dp-trigger').addEventListener('click', function(e){
        if (e.target===dpClear||dpClear.contains(e.target)) return;
        dpWrap.classList.contains('open') ? dpClose() : dpOpen();
    });
    dpDisplay.addEventListener('keydown', function(e){
        if(e.key==='Enter'||e.key===' '){ e.preventDefault(); dpWrap.classList.contains('open')?dpClose():dpOpen(); }
        if(e.key==='Escape') dpClose();
    });
    document.getElementById('dp-prev').addEventListener('click', function(){ viewMonth--; if(viewMonth<0){viewMonth=11;viewYear--;} renderCalendar(); });
    document.getElementById('dp-next').addEventListener('click', function(){ viewMonth++; if(viewMonth>11){viewMonth=0;viewYear++;} renderCalendar(); });
    dpClear.addEventListener('click', function(e){ e.stopPropagation(); selected=null; dpValue.value=''; dpDisplay.value=''; dpClear.style.display='none'; dpClose(); });
    document.addEventListener('click', function(e){ if(!dpWrap.contains(e.target)) dpClose(); });

    // ── Validation ─────────────────────────────────────────────
    function showErr(inputId, errId, isCustom) {
        if (!isCustom) document.getElementById(inputId).classList.add('field-invalid');
        else document.getElementById(inputId).classList.add('cs-invalid');
        document.getElementById(errId).classList.add('show');
    }
    function clearErr(inputId, errId, isCustom) {
        if (!isCustom) document.getElementById(inputId).classList.remove('field-invalid');
        else document.getElementById(inputId).classList.remove('cs-invalid');
        document.getElementById(errId).classList.remove('show');
    }

    // Clear errors on input
    ['name','value','max_value','coefficient'].forEach(function(id) {
        document.getElementById(id).addEventListener('input', function(){ clearErr(id,'err-'+id,false); });
    });

    document.getElementById('grade-form').addEventListener('submit', function(e) {
        var valid = true;

        if (!csValue.value) { showErr('cs-wrap','err-subject',true); valid=false; }
        else clearErr('cs-wrap','err-subject',true);

        var nameEl = document.getElementById('name');
        if (!nameEl.value.trim()) { showErr('name','err-name',false); valid=false; }
        else clearErr('name','err-name',false);

        var valEl = document.getElementById('value');
        if (valEl.value === '') { showErr('value','err-value',false); valid=false; }
        else clearErr('value','err-value',false);

        var maxEl = document.getElementById('max_value');
        if (!maxEl.value || +maxEl.value <= 0) { showErr('max_value','err-max_value',false); valid=false; }
        else clearErr('max_value','err-max_value',false);

        var coeffEl = document.getElementById('coefficient');
        if (!coeffEl.value || +coeffEl.value <= 0) { showErr('coefficient','err-coefficient',false); valid=false; }
        else clearErr('coefficient','err-coefficient',false);

        if (!valid) {
            e.preventDefault();
            var first = document.querySelector('.field-err.show, .cs-invalid');
            if (first) first.scrollIntoView({behavior:'smooth', block:'center'});
        }
    });
})();
</script>
