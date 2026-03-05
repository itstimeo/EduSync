<?php
$iconBack     = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>';
$iconEdit     = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.5-6.5a2.121 2.121 0 013 3L12 14l-4 1 1-4z"/></svg>';
$iconDel      = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16M10 3h4a1 1 0 011 1v3H9V4a1 1 0 011-1z"/></svg>';
$iconStar     = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>';
$iconStarFill = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>';
$iconPlus     = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>';
$iconClose    = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
?>
<style>
    .settings-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.75rem; }
    .settings-header h1 { font-size: 1.4rem; font-weight: 700; color: #1a1a1a; flex: 1; }
    .btn { display: inline-flex; align-items: center; justify-content: center; padding: .5rem 1rem; border-radius: 6px; font-size: .875rem; font-weight: 500; cursor: pointer; text-decoration: none; border: none; }
    .btn-primary { background: #6366f1; color: #fff; }
    .btn-primary:hover { background: #4f46e5; }
    .btn-ghost { background: transparent; color: #6b7280; border: 1px solid #e5e7eb; }
    .btn-ghost:hover { background: #f3f4f6; color: #1a1a1a; }
    .btn-sm { padding: .35rem .75rem; font-size: .8rem; }
    .btn-icon-star:hover { background: #fef9c3; color: #b45309; border-color: #fde68a; }
    .btn-icon-plus { border-style: dashed; border-color: #a5b4fc; color: #6366f1; background: #f5f3ff; }
    .btn-icon-plus:hover { background: #ede9fe; }

    .section-title { font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #9ca3af; margin-bottom: .75rem; }

    .preset-list { background: #fff; border-radius: 8px; box-shadow: 0 1px 6px rgba(0,0,0,.07); overflow: hidden; margin-bottom: 2rem; }
    .preset-row { display: flex; align-items: flex-start; gap: .75rem; padding: .85rem 1.25rem; border-bottom: 1px solid #f3f4f6; }
    .preset-row:last-child { border-bottom: none; }
    .preset-name { font-weight: 600; font-size: .9rem; color: #1a1a1a; min-width: 130px; padding-top: .25rem; }
    .preset-steps { flex: 1; display: flex; flex-wrap: wrap; gap: .35rem; padding-top: .1rem; }
    .step-pill { display: inline-flex; align-items: center; gap: .3rem; padding: .2rem .6rem; border-radius: 99px; font-size: .75rem; background: #f3f4f6; color: #374151; }
    .step-pill .step-day { font-weight: 700; color: #6366f1; }
    .preset-actions { display: flex; gap: .35rem; flex-shrink: 0; align-items: center; }
    .badge-default { display: inline-block; padding: .15rem .5rem; border-radius: 99px; font-size: .7rem; font-weight: 700; background: #ede9fe; color: #6d28d9; margin-left: .4rem; }

    .card { background: #fff; border-radius: 8px; box-shadow: 0 1px 6px rgba(0,0,0,.07); padding: 1.5rem; }
    .form-group { display: flex; flex-direction: column; gap: .35rem; margin-bottom: 1rem; }
    .form-group label { font-size: .8rem; font-weight: 600; color: #374151; }
    .form-group input[type="text"] { padding: .5rem .75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: .875rem; color: #1a1a1a; background: #fff; }
    .form-group input[type="text"]:focus, .form-group input[type="number"]:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99,102,241,.15); }
    .hint { font-size: .75rem; color: #9ca3af; }
    .empty { color: #9ca3af; font-size: .875rem; text-align: center; padding: 1.5rem 0; }
    .form-actions { display: flex; gap: .75rem; margin-top: 1.25rem; }

    .steps-editor { display: flex; flex-direction: column; gap: .5rem; margin-bottom: .75rem; }
    .step-row { display: flex; align-items: center; gap: .5rem; }
    .step-row .step-index { font-size: .75rem; font-weight: 700; color: #9ca3af; width: 1.5rem; text-align: right; flex-shrink: 0; }
    .step-row input[type="number"] { width: 80px; padding: .45rem .6rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: .875rem; color: #1a1a1a; background: #fff; flex-shrink: 0; }
    .step-invalid{border-color:#ef4444!important;box-shadow:0 0 0 3px rgba(239,68,68,.1)!important}
    .step-row input[type="text"] { flex: 1; padding: .45rem .6rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: .875rem; color: #1a1a1a; background: #fff; }
    .step-header { display: flex; align-items: center; gap: .5rem; font-size: .75rem; font-weight: 600; color: #9ca3af; padding-bottom: .25rem; }
    .step-header .col-day   { width: 80px; margin-left: 2rem; flex-shrink: 0; }
    .step-header .col-action { flex: 1; }
</style>

<div class="settings-header">
    <a href="/revision" class="btn-back" title="Back"><?= $iconBack ?></a>
    <h1>Revision settings</h1>
</div>

<!-- Preset list -->
<div class="section-title">Your presets</div>
<?php if (empty($presets)): ?>
    <p class="empty" style="background:#fff;border-radius:8px;box-shadow:0 1px 6px rgba(0,0,0,.07);padding:1.5rem;margin-bottom:2rem;">No presets yet. Create one below.</p>
<?php else: ?>
    <div class="preset-list" style="margin-bottom:2rem;">
        <?php foreach ($presets as $p):
            $steps = json_decode($p['intervals'], true) ?: [];
        ?>
            <div class="preset-row">
                <span class="preset-name">
                    <?= htmlspecialchars($p['name'], ENT_QUOTES) ?>
                    <?php if ($p['is_default']): ?>
                        <span class="badge-default">Default</span>
                    <?php endif; ?>
                </span>
                <div class="preset-steps">
                    <?php foreach ($steps as $s): ?>
                        <span class="step-pill">
                            <span class="step-day">J+<?= (int)$s['day'] ?></span>
                            <?php if (!empty($s['action'])): ?>
                                <span><?= htmlspecialchars($s['action'], ENT_QUOTES) ?></span>
                            <?php endif; ?>
                        </span>
                    <?php endforeach; ?>
                </div>
                <div class="preset-actions">
                    <?php if ($p['is_default']): ?>
                        <form method="POST" action="/revision/settings/unset-default" style="display:inline">
                            <button type="submit" class="btn-icon" title="Remove default" style="background:#fef9c3;color:#b45309;border-color:#fde68a;"><?= $iconStarFill ?></button>
                        </form>
                    <?php else: ?>
                        <form method="POST" action="/revision/settings/set-default" style="display:inline">
                            <input type="hidden" name="preset_id" value="<?= (int)$p['id'] ?>">
                            <button type="submit" class="btn-icon btn-icon-star" title="Set as default"><?= $iconStar ?></button>
                        </form>
                    <?php endif; ?>
                    <button type="button" class="btn-icon btn-edit" title="Edit"
                        data-id="<?= (int)$p['id'] ?>"
                        data-name="<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>"
                        data-intervals="<?= htmlspecialchars($p['intervals'], ENT_QUOTES) ?>"
                        onclick="loadEditFormFromEl(this)">
                        <?= $iconEdit ?>
                    </button>
                    <form method="POST" action="/revision/settings/delete" style="display:inline">
                        <input type="hidden" name="preset_id" value="<?= (int)$p['id'] ?>">
                        <button type="button" class="btn-icon btn-delete" title="Delete"
                            onclick="esConfirm('Delete preset &quot;<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>&quot;? Existing sessions are not affected.', () => this.closest('form').submit())">
                            <?= $iconDel ?>
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Create / Edit preset form -->
<div class="section-title" id="form-title">New preset</div>
<div class="card">
    <form method="POST" action="/revision/settings/save" id="preset-form" novalidate>
        <input type="hidden" name="preset_id" id="preset_id" value="0">

        <div class="form-group">
            <label for="name">Preset name <span style="color:#ef4444">*</span></label>
            <input type="text" id="name" name="name" placeholder="e.g. Standard, Intensive, Light" maxlength="100">
            <span id="err-name" style="display:none;font-size:.75rem;color:#ef4444;margin-top:.2rem;"></span>
        </div>

        <div class="form-group">
            <label>Steps <span style="color:#ef4444">*</span></label>
            <div class="step-header">
                <span class="col-day">Day (J+)</span>
                <span class="col-action">Action label (optional)</span>
            </div>
            <div class="steps-editor" id="steps-editor"></div>
            <button type="button" class="btn-icon btn-icon-plus" onclick="addStep()" title="Add step"><?= $iconPlus ?></button>
            <span id="err-steps" style="display:none;font-size:.75rem;color:#ef4444;margin-top:.4rem;"></span>
            <span class="hint" style="margin-top:.4rem;">Day 0 = today, day 1 = tomorrow, etc. Steps are followed in order.</span>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary" id="form-submit-btn">Create preset</button>
            <button type="button" class="btn btn-ghost" id="form-cancel-btn" style="display:none" onclick="resetForm()">Cancel</button>
        </div>
    </form>
</div>

<script>
var SVG_CLOSE = <?= json_encode($iconClose) ?>;

function addStep(day, action) {
    var editor = document.getElementById('steps-editor');
    var idx = editor.children.length;
    var row = document.createElement('div');
    row.className = 'step-row';
    row.innerHTML =
        '<span class="step-index">' + (idx + 1) + '</span>' +
        '<input type="number" name="steps[' + idx + '][day]" min="0" placeholder="Day" value="' + (day !== undefined ? day : '') + '">' +
        '<input type="text" name="steps[' + idx + '][action]" placeholder="e.g. Re-read notes" value="' + (action !== undefined ? escHtml(action) : '') + '">' +
        '<button type="button" class="btn-icon btn-delete" onclick="removeStep(this)" title="Remove step" style="width:28px;height:28px;">' + SVG_CLOSE + '</button>';
    row.querySelector('input[type="number"]').addEventListener('input', function () {
        this.classList.remove('step-invalid');
        document.getElementById('err-steps').style.display = 'none';
    });
    editor.appendChild(row);
    reindexSteps();
}

function removeStep(btn) {
    btn.closest('.step-row').remove();
    reindexSteps();
}

function reindexSteps() {
    var rows = document.querySelectorAll('#steps-editor .step-row');
    rows.forEach(function(row, i) {
        row.querySelector('.step-index').textContent = (i + 1);
        row.querySelector('input[type="number"]').name = 'steps[' + i + '][day]';
        row.querySelector('input[type="text"]').name   = 'steps[' + i + '][action]';
    });
}

function escHtml(s) {
    return String(s).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function loadEditFormFromEl(btn) {
    var steps = JSON.parse(btn.dataset.intervals);
    loadEditForm(parseInt(btn.dataset.id), btn.dataset.name, steps);
}

function loadEditForm(id, name, steps) {
    resetForm();
    document.getElementById('preset_id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('form-title').textContent = 'Edit preset';
    document.getElementById('form-submit-btn').textContent = 'Save changes';
    document.getElementById('form-cancel-btn').style.display = '';
    steps.forEach(function(s) { addStep(s.day, s.action || ''); });
    document.getElementById('form-title').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function resetForm() {
    document.getElementById('preset_id').value = '0';
    document.getElementById('name').value = '';
    document.getElementById('steps-editor').innerHTML = '';
    document.getElementById('form-title').textContent = 'New preset';
    document.getElementById('form-submit-btn').textContent = 'Create preset';
    document.getElementById('form-cancel-btn').style.display = 'none';
    document.getElementById('err-name').style.display = 'none';
    document.getElementById('err-steps').style.display = 'none';
    document.getElementById('name').classList.remove('step-invalid');
}

document.getElementById('name').addEventListener('input', function () {
    this.classList.remove('step-invalid');
    document.getElementById('err-name').style.display = 'none';
});

document.getElementById('preset-form').addEventListener('submit', function(e) {
    var ok = true;
    var nameEl  = document.getElementById('name');
    var errName = document.getElementById('err-name');
    var errSteps = document.getElementById('err-steps');

    if (!nameEl.value.trim()) {
        errName.textContent = 'Preset name is required.';
        errName.style.display = 'block';
        nameEl.classList.add('step-invalid');
        ok = false;
    } else {
        errName.style.display = 'none';
        nameEl.classList.remove('step-invalid');
    }

    var rows = document.querySelectorAll('#steps-editor .step-row');
    if (rows.length === 0) {
        errSteps.textContent = 'Add at least one step.';
        errSteps.style.display = 'block';
        ok = false;
    } else {
        var invalid = false;
        rows.forEach(function(row) {
            var inp = row.querySelector('input[type="number"]');
            var v   = inp.value.trim();
            if (v === '' || isNaN(parseInt(v)) || parseInt(v) < 0) {
                inp.classList.add('step-invalid');
                invalid = true;
            } else {
                inp.classList.remove('step-invalid');
            }
        });
        if (invalid) {
            errSteps.textContent = 'Each step must have a valid day (integer \u2265 0).';
            errSteps.style.display = 'block';
            ok = false;
        } else {
            errSteps.style.display = 'none';
        }
    }

    if (!ok) e.preventDefault();
});

addStep(1, '');
addStep(3, '');
addStep(7, '');
addStep(14, '');
addStep(30, '');
</script>
