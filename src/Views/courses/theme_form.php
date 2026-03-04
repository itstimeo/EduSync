<style>
.breadcrumb{font-size:.85rem;color:#6b7280;max-width:460px;margin:0 auto 1.25rem}
.breadcrumb a{color:#6366f1;text-decoration:none}
.form-card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:1.5rem;max-width:460px;margin:0 auto}
.form-card h1{font-size:1.1rem;font-weight:700;margin-bottom:1.25rem}
.field{margin-bottom:1.1rem}
.field label{display:block;font-size:.875rem;font-weight:500;margin-bottom:.35rem;color:#374151}
.field input[type="text"]{width:100%;padding:.5rem .75rem;border:1px solid #d1d5db;border-radius:6px;font-size:.9rem}
.field input[type="text"]:focus{outline:none;border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.form-actions{display:flex;gap:.75rem;margin-top:1.4rem}
.btn{display:inline-flex;align-items:center;padding:.5rem 1.1rem;border-radius:6px;font-size:.875rem;font-weight:500;text-decoration:none;cursor:pointer;border:none}
.btn-primary{background:#6366f1;color:#fff}.btn-primary:hover{background:#4f46e5}
.btn-secondary{background:#f3f4f6;color:#374151}.btn-secondary:hover{background:#e5e7eb}
.req{color:#ef4444;margin-left:2px}
.field-err{display:none;font-size:.78rem;color:#ef4444;margin-top:.3rem}
.field-err.show{display:block}
.field-invalid{border-color:#ef4444!important;box-shadow:0 0 0 3px rgba(239,68,68,.1)!important}
.req-note{font-size:.78rem;color:#9ca3af;margin-top:1.25rem}
</style>

<p class="breadcrumb">
    <a href="/courses">Subjects</a> ›
    <a href="/themes?subject_id=<?= (int)$subject['id'] ?>"><?= htmlspecialchars($subject['name'], ENT_QUOTES) ?></a> ›
    <?= $theme ? 'Edit theme' : 'New theme' ?>
</p>

<div class="form-card">
    <h1><?= $theme ? 'Edit theme' : 'New theme' ?></h1>
    <form method="post" action="<?= $theme ? '/themes/edit' : '/themes/create' ?>" novalidate>
        <?php if ($theme): ?>
            <input type="hidden" name="id" value="<?= (int)$theme['id'] ?>">
        <?php endif; ?>
        <input type="hidden" name="subject_id" value="<?= (int)$subject['id'] ?>">
        <div class="field">
            <label for="name">Name <span class="req">*</span></label>
            <input type="text" id="name" name="name" maxlength="150" autofocus
                   value="<?= htmlspecialchars($theme['name'] ?? '', ENT_QUOTES) ?>">
            <span class="field-err" id="err-name">Please enter a name.</span>
        </div>
        <div class="field">
            <label>Color</label>
            <?php
                $colorPickerName  = 'color';
                $colorPickerValue = $theme['color'] ?? $subject['color'] ?? '#6366f1';
                include __DIR__ . '/_color_picker.php';
            ?>
        </div>
        <p class="req-note"><span class="req">*</span> Required</p>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="/themes?subject_id=<?= (int)$subject['id'] ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
(function(){
    var nameEl = document.getElementById('name');
    var errEl  = document.getElementById('err-name');
    nameEl.addEventListener('input', function(){ nameEl.classList.remove('field-invalid'); errEl.classList.remove('show'); });
    nameEl.closest('form').addEventListener('submit', function(e){
        if (!nameEl.value.trim()) {
            e.preventDefault();
            nameEl.classList.add('field-invalid');
            errEl.classList.add('show');
            nameEl.focus();
        }
    });
})();
</script>
