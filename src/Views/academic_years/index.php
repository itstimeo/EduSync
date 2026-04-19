<style>
    .ay-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; gap:1rem; flex-wrap:wrap; }
    .ay-header h1 { font-size:1.4rem; font-weight:700; color:var(--text); }
    .ay-setup-banner { background:var(--purple-tint); border:1px solid #c7d2fe; border-radius:10px; padding:1rem 1.25rem; margin-bottom:1.5rem; font-size:.9rem; color:#4338ca; display:flex; align-items:center; gap:.75rem; }
    html.dark .ay-setup-banner { background:var(--purple-tint-2); border-color:#3730a3; color:#a5b4fc; }
    .ay-create { background:var(--surface); border-radius:10px; padding:1.25rem; box-shadow:0 1px 6px rgba(0,0,0,.07); margin-bottom:1.5rem; }
    .ay-create h2 { font-size:.9rem; font-weight:700; color:var(--text); margin-bottom:.85rem; }
    .ay-create-row { display:flex; gap:.6rem; align-items:center; flex-wrap:wrap; }
    .ay-create-row input { flex:1; min-width:180px; padding:.5rem .75rem; font-size:.875rem; border:1px solid var(--border-soft); border-radius:6px; background:var(--input-bg); color:var(--text); }
    .ay-create-row input:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.12); }
    .ay-list { display:flex; flex-direction:column; gap:.6rem; }
    .ay-row { background:var(--surface); border-radius:10px; padding:1rem 1.25rem; box-shadow:0 1px 6px rgba(0,0,0,.07); display:flex; align-items:center; gap:1rem; flex-wrap:wrap; }
    .ay-row-name { flex:1; min-width:120px; font-size:.95rem; font-weight:600; color:var(--text); display:flex; align-items:center; gap:.6rem; }
    .ay-badge-active { font-size:.7rem; font-weight:700; padding:.15rem .55rem; border-radius:99px; background:#6366f1; color:#fff; flex-shrink:0; }
    .ay-rename-form { display:flex; gap:.4rem; align-items:center; flex:1; min-width:180px; }
    .ay-rename-form input { flex:1; padding:.38rem .65rem; font-size:.825rem; border:1px solid var(--border-soft); border-radius:6px; background:var(--input-bg); color:var(--text); }
    .ay-rename-form input:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.12); }
    .ay-actions { display:flex; gap:.4rem; align-items:center; flex-shrink:0; }
    .empty { color:var(--text-subtle); font-size:.9rem; text-align:center; padding:2rem; background:var(--surface); border-radius:10px; }
</style>

<div class="ay-header">
    <h1><?= __('academic_year.title') ?></h1>
</div>

<?php if ($setup): ?>
<div class="ay-setup-banner">
    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v4m0 4h.01"/></svg>
    <?= __('academic_year.setup_hint') ?>
</div>
<?php endif; ?>

<!-- Create form -->
<div class="ay-create">
    <h2><?= __('academic_year.new') ?></h2>
    <form method="POST" action="/academic-years/create" novalidate id="form-ay-create">
        <div class="ay-create-row">
            <input type="text" name="name" id="ay-name"
                   placeholder="<?= htmlspecialchars(__('academic_year.name_placeholder'), ENT_QUOTES) ?>"
                   maxlength="100" autocomplete="off">
            <button type="submit" class="btn btn-primary btn-sm"><?= __('common.create') ?></button>
        </div>
        <div id="ay-name-err" style="font-size:.75rem;color:#ef4444;margin-top:.3rem;display:none;"></div>
    </form>
</div>

<!-- List -->
<?php if (empty($years)): ?>
    <p class="empty"><?= __('academic_year.none') ?></p>
<?php else: ?>
    <div class="ay-list">
        <?php foreach ($years as $y):
            $isActive = $active && (int)$y['id'] === (int)$active['id'];
        ?>
        <div class="ay-row">
            <div class="ay-row-name">
                <?= htmlspecialchars($y['name'], ENT_QUOTES) ?>
                <?php if ($isActive): ?>
                    <span class="ay-badge-active"><?= __('academic_year.active') ?></span>
                <?php endif; ?>
            </div>

            <!-- Rename inline form -->
            <form method="POST" action="/academic-years/rename" class="ay-rename-form" novalidate>
                <input type="hidden" name="id" value="<?= (int)$y['id'] ?>">
                <input type="text" name="name"
                       value="<?= htmlspecialchars($y['name'], ENT_QUOTES) ?>"
                       maxlength="100" autocomplete="off"
                       placeholder="<?= htmlspecialchars(__('academic_year.rename_placeholder'), ENT_QUOTES) ?>">
                <button type="submit" class="btn btn-secondary btn-sm"><?= __('common.rename') ?></button>
            </form>

            <div class="ay-actions">
                <?php if (!$isActive): ?>
                    <a href="/academic-years/switch?id=<?= (int)$y['id'] ?>" class="btn btn-ghost btn-sm">
                        <?= __('academic_year.set_active') ?>
                    </a>
                <?php endif; ?>
                <?php if (!$isActive): ?>
                    <form method="POST" action="/academic-years/delete" style="margin:0;">
                        <input type="hidden" name="id" value="<?= (int)$y['id'] ?>">
                        <button type="button" class="btn-icon btn-delete"
                            onclick="esConfirm('<?= htmlspecialchars(__('academic_year.delete_confirm'), ENT_QUOTES) ?>', () => this.closest('form').submit())">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16M10 3h4a1 1 0 011 1v3H9V4a1 1 0 011-1z"/></svg>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
(function(){
    var form  = document.getElementById('form-ay-create');
    var input = document.getElementById('ay-name');
    var err   = document.getElementById('ay-name-err');
    var REQUIRED = <?= json_encode(__('common.required')) ?>;
    form.addEventListener('submit', function(e){
        if(input.value.trim() === ''){
            e.preventDefault();
            input.style.borderColor = '#f87171';
            err.textContent = REQUIRED;
            err.style.display = 'block';
        } else {
            input.style.borderColor = '';
            err.style.display = 'none';
        }
    });
    input.addEventListener('input', function(){
        if(input.value.trim() !== ''){
            input.style.borderColor = '';
            err.style.display = 'none';
        }
    });
})();
</script>
