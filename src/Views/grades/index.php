<?php
$iconEdit = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.5-6.5a2.121 2.121 0 013 3L12 14l-4 1 1-4z"/></svg>';
$iconDel  = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16M10 3h4a1 1 0 011 1v3H9V4a1 1 0 011-1z"/></svg>';
?>
<style>
.page-hd{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem}
.page-hd h1{font-size:1.25rem;font-weight:700}
.btn{display:inline-flex;align-items:center;gap:.3rem;padding:.45rem .9rem;border-radius:6px;font-size:.85rem;font-weight:500;text-decoration:none;cursor:pointer;border:none}
.btn-primary{background:#6366f1;color:#fff}.btn-primary:hover{background:#4f46e5}
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
})();
</script>
