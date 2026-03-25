<style>
.breadcrumb{font-size:.85rem;color:var(--text-muted);max-width:500px;margin:0 auto 1.25rem}
.breadcrumb a{color:#6366f1;text-decoration:none}
.form-card{background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:1.5rem;max-width:500px;margin:0 auto 1.5rem}
.form-card h1{font-size:1.1rem;font-weight:700;margin-bottom:.35rem}
.form-card h2{font-size:.95rem;font-weight:700;margin-bottom:1rem;color:var(--text)}
.form-card .subtitle{font-size:.85rem;color:var(--text-subtle);margin-bottom:1.5rem}
.type-row{display:flex;align-items:center;gap:.75rem;padding:.65rem 0;border-bottom:1px solid var(--bg-subtle)}
.type-row:last-of-type{border-bottom:none}
.type-label-input{flex:1;padding:.4rem .6rem;border:1px solid var(--border-soft);border-radius:6px;font-size:.875rem}
.type-label-input:focus{outline:none;border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.type-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0}
.form-actions{display:flex;gap:.75rem;margin-top:1.25rem}
.btn{display:inline-flex;align-items:center;padding:.5rem 1.1rem;border-radius:6px;font-size:.875rem;font-weight:500;text-decoration:none;cursor:pointer;border:none}
.btn-primary{background:#6366f1;color:#fff}.btn-primary:hover{background:#4f46e5}
.btn-secondary{background:var(--bg-subtle);color:var(--text)}.btn-secondary:hover{background:var(--border)}
.btn-add{background:#6366f1;color:#fff;padding:.45rem .9rem;font-size:.85rem}.btn-add:hover{background:#4f46e5}
.add-row{display:flex;align-items:center;gap:.75rem;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border)}
.add-label-input{flex:1;padding:.4rem .6rem;border:1px solid var(--border-soft);border-radius:6px;font-size:.875rem}
.add-label-input:focus{outline:none;border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
</style>

<div style="display:flex;align-items:center;gap:.75rem;max-width:500px;margin:0 auto 1.25rem;">
    <a href="/planning" class="btn-back" title="Back"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
    <p class="breadcrumb" style="margin:0;max-width:none;"><a href="/planning">Planning</a> › Settings</p>
</div>

<div class="form-card">
    <h1>Event types</h1>
    <p class="subtitle">Manage your event types and their colors.</p>

    <form method="post" action="/planning/settings" id="settings-form">
        <?php foreach ($typeList as $row):
            $colorPickerName  = 'color_' . $row['id'];
            $colorPickerValue = $row['color'];
        ?>
            <div class="type-row">
                <span class="type-dot" style="background:<?= htmlspecialchars($colorPickerValue, ENT_QUOTES) ?>" id="dot-<?= (int)$row['id'] ?>"></span>
                <input type="text" class="type-label-input" name="label_<?= (int)$row['id'] ?>"
                       value="<?= htmlspecialchars($row['label'], ENT_QUOTES) ?>" maxlength="100" required>
                <?php include __DIR__ . '/../courses/_color_picker.php'; ?>
                <button type="submit" name="delete_type" value="<?= (int)$row['id'] ?>"
                        class="btn-icon btn-delete" title="Delete">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16M10 3h4a1 1 0 011 1v3H9V4a1 1 0 011-1z"/></svg>
                </button>
            </div>
        <?php endforeach; ?>

        <div class="form-actions">
            <button type="submit" name="save_types" value="1" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

<div class="form-card">
    <h2>Add a type <span style="color:#ef4444">*</span></h2>
    <form method="post" action="/planning/settings/add-type" novalidate id="add-type-form">
        <div class="add-row">
            <input type="text" class="add-label-input" name="new_label" placeholder="Type name (e.g. Lab Work)"
                   maxlength="50" id="new-label-input">
            <?php
                $colorPickerName  = 'new_color';
                $colorPickerValue = '#6366f1';
                include __DIR__ . '/../courses/_color_picker.php';
            ?>
            <button type="submit" class="btn btn-add">Add</button>
        </div>
        <span id="err-new-label" style="display:none;font-size:.78rem;color:#ef4444;margin-top:.3rem;display:none">Please enter a type name.</span>
    </form>
</div>

<script>
(function () {
    // Sync type dots with color picker changes
    var typeList = <?= json_encode(array_column($typeList, 'id')) ?>;
    typeList.forEach(function (id) {
        var input = document.getElementById('cp_color_' + id + '_in');
        if (!input) return;
        var dot = document.getElementById('dot-' + id);
        input.addEventListener('change', function () { if (dot) dot.style.background = this.value; });
        var obs = new MutationObserver(function () { if (dot) dot.style.background = input.value; });
        obs.observe(input, { attributes: true, attributeFilter: ['value'] });
    });

    // Patch cpPick to update dots
    var origCpPick = window.cpPick;
    if (origCpPick && !window._cpPickPatched) {
        window._cpPickPatched = true;
        window.cpPick = function (id, hex) {
            origCpPick(id, hex);
            typeList.forEach(function (tid) {
                var d = document.getElementById('dot-' + tid);
                var inp = document.getElementById('cp_color_' + tid + '_in');
                if (d && inp) d.style.background = inp.value;
            });
        };
    }

    // Add type validation
    document.getElementById('add-type-form').addEventListener('submit', function (e) {
        var val = document.getElementById('new-label-input').value.trim();
        var err = document.getElementById('err-new-label');
        if (!val) {
            e.preventDefault();
            err.style.display = 'block';
        } else {
            err.style.display = 'none';
        }
    });
    document.getElementById('new-label-input').addEventListener('input', function () {
        document.getElementById('err-new-label').style.display = 'none';
    });

    // Delete confirmation via esConfirm
    document.querySelectorAll('button[name="delete_type"]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var label = btn.closest('.type-row').querySelector('.type-label-input').value || 'this type';
            esConfirm('Delete type «' + label + '»?', function () {
                var hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'delete_type';
                hidden.value = btn.value;
                btn.form.appendChild(hidden);
                btn.form.submit();
            });
        });
    });
})();
</script>
