<style>
.breadcrumb{font-size:.85rem;color:#6b7280;margin-bottom:1.25rem}
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
</style>

<p class="breadcrumb"><a href="/courses">Subjects</a> › <?= $subject ? 'Edit' : 'New subject' ?></p>

<div class="form-card">
    <h1><?= $subject ? 'Edit subject' : 'New subject' ?></h1>
    <form method="post" action="<?= $subject ? '/courses/edit' : '/courses/create' ?>">
        <?php if ($subject): ?>
            <input type="hidden" name="id" value="<?= (int)$subject['id'] ?>">
        <?php endif; ?>
        <div class="field">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" maxlength="150" required autofocus
                   value="<?= htmlspecialchars($subject['name'] ?? '', ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label>Color</label>
            <?php
                $colorPickerName  = 'color';
                $colorPickerValue = $subject['color'] ?? '#6366f1';
                include __DIR__ . '/_color_picker.php';
            ?>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="/courses" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
