<style>
.breadcrumb{font-size:.85rem;color:var(--text-muted);max-width:460px;margin:0 auto 1.25rem}
.breadcrumb a{color:#6366f1;text-decoration:none}
.form-card{background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:1.5rem;max-width:460px;margin:0 auto}
.form-card h1{font-size:1.1rem;font-weight:700;margin-bottom:1.25rem}
.field{margin-bottom:1.1rem}
.field label{display:block;font-size:.875rem;font-weight:500;margin-bottom:.35rem;color:var(--text)}
.field input[type="text"]{width:100%;padding:.5rem .75rem;border:1px solid var(--border-soft);border-radius:6px;font-size:.9rem;background:var(--input-bg);color:var(--text)}
.field input[type="text"]:focus{outline:none;border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.form-actions{display:flex;gap:.75rem;margin-top:1.4rem}
.req{color:#ef4444;margin-left:2px}
.field-err{display:none;font-size:.78rem;color:#ef4444;margin-top:.3rem}
.field-err.show{display:block}
.field-invalid{border-color:#ef4444!important;box-shadow:0 0 0 3px rgba(239,68,68,.1)!important}
.req-note{font-size:.78rem;color:var(--text-subtle);margin-top:1.25rem}
</style>

<div style="display:flex;align-items:center;gap:.75rem;max-width:460px;margin:0 auto 1.25rem;">
    <a href="/chapters?theme_id=<?= (int)$theme['id'] ?>" class="btn-back" title="Back"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
    <p class="breadcrumb" style="margin:0;max-width:none;">
        <a href="/courses">Subjects</a> ›
        <a href="/themes?subject_id=<?= (int)$theme['subject_id'] ?>"><?= htmlspecialchars($theme['subject_name'], ENT_QUOTES) ?></a> ›
        <a href="/chapters?theme_id=<?= (int)$theme['id'] ?>"><?= htmlspecialchars($theme['name'], ENT_QUOTES) ?></a> ›
        <?= $chapter ? 'Edit chapter' : 'New chapter' ?>
    </p>
</div>

<div class="form-card">
    <h1><?= $chapter ? 'Edit chapter' : 'New chapter' ?></h1>
    <form method="post" action="<?= $chapter ? '/chapters/edit' : '/chapters/create' ?>" novalidate>
        <?php if ($chapter): ?>
            <input type="hidden" name="id" value="<?= (int)$chapter['id'] ?>">
        <?php endif; ?>
        <input type="hidden" name="theme_id" value="<?= (int)$theme['id'] ?>">
        <div class="field">
            <label for="name">Name <span class="req">*</span></label>
            <input type="text" id="name" name="name" maxlength="150" autofocus
                   value="<?= htmlspecialchars($chapter['name'] ?? '', ENT_QUOTES) ?>">
            <span class="field-err" id="err-name">Please enter a name.</span>
        </div>
        <div class="field">
            <label>Color</label>
            <?php
                $colorPickerName  = 'color';
                $colorPickerValue = $chapter['color'] ?? $theme['color'] ?? '#6366f1';
                include __DIR__ . '/_color_picker.php';
            ?>
        </div>
        <p class="req-note"><span class="req">*</span> Required</p>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
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
