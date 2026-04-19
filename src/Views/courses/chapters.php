<?php
$iconEdit = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.5-6.5a2.121 2.121 0 013 3L12 14l-4 1 1-4z"/></svg>';
$iconDel  = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16M10 3h4a1 1 0 011 1v3H9V4a1 1 0 011-1z"/></svg>';
$iconExp  = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 4v11m0 0l-3.5-3.5M12 15l3.5-3.5"/></svg>';
?>
<style>
.breadcrumb{font-size:.85rem;color:var(--text-muted)}.breadcrumb a{color:#6366f1;text-decoration:none}
.page-hd{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem}
.page-hd h1{font-size:1.25rem;font-weight:700;display:flex;align-items:center;gap:.55rem}
.subj-dot{width:12px;height:12px;border-radius:50%;display:inline-block;flex-shrink:0}
.hd-right{display:flex;align-items:center;gap:.75rem}
.view-toggle{display:flex;gap:2px}
.view-toggle button{padding:.35rem .55rem;border:1px solid var(--border-soft);border-radius:5px;background:var(--surface);cursor:pointer;font-size:.85rem;color:var(--text-muted);line-height:1}
.view-toggle button.active{background:#6366f1;color:#fff;border-color:#6366f1}
.empty{color:var(--text-subtle);font-size:.9rem;padding:3rem 0;text-align:center}
.card-list{display:flex;flex-direction:column;gap:.55rem}
.card{background:var(--surface);border:1px solid var(--border);border-radius:8px;cursor:pointer;transition:box-shadow .15s;overflow:hidden}
.card:hover{box-shadow:0 2px 12px rgba(0,0,0,.08)}
.card-list .card{display:flex;align-items:center}
.card-list .card-strip{width:6px;align-self:stretch;flex-shrink:0}
.card-list .card-body{flex:1;padding:.8rem 1rem}
.card-name{font-weight:600;font-size:.9rem}
.card-list .card-actions{padding:.4rem 1rem .4rem 0;display:flex;gap:.35rem;align-items:center;flex-shrink:0}
.card-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(175px,1fr));gap:.75rem}
.card-grid .card{display:flex;flex-direction:column}
.card-grid .card-strip{height:54px}
.card-grid .card-body{flex:1;padding:.7rem .9rem .4rem}
.card-grid .card-actions{padding:.45rem .75rem .6rem;display:flex;flex-wrap:wrap;gap:.35rem;border-top:1px solid var(--bg-subtle)}
</style>

<div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;">
    <a href="/themes?subject_id=<?= (int)$theme['subject_id'] ?>" class="btn-back" title="Back"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
    <p class="breadcrumb" style="margin:0;"><a href="/courses"><?= __('courses.subjects') ?></a> › <a href="/themes?subject_id=<?= (int)$theme['subject_id'] ?>"><?= htmlspecialchars($theme['subject_name'], ENT_QUOTES) ?></a> › <?= htmlspecialchars($theme['name'], ENT_QUOTES) ?></p>
</div>
<div class="page-hd">
    <h1>
        <span class="subj-dot" style="background:<?= htmlspecialchars($theme['color'], ENT_QUOTES) ?>"></span>
        <?= htmlspecialchars($theme['name'], ENT_QUOTES) ?>
    </h1>
    <div class="hd-right">
        <div class="view-toggle">
            <button id="btn-list" type="button" title="List">☰</button>
            <button id="btn-grid" type="button" title="Grid">⊞</button>
        </div>
        <a href="/courses/export?theme_id=<?= (int)$theme['id'] ?>" class="btn btn-secondary"><?= $iconExp ?> <?= __('courses.export') ?></a>
        <a href="/chapters/create?theme_id=<?= (int)$theme['id'] ?>" class="btn btn-primary"><?= __('courses.new_chapter') ?></a>
    </div>
</div>

<?php if (empty($chapters)): ?>
    <p class="empty"><?= __('courses.no_chapters') ?></p>
<?php else: ?>
    <div id="items">
        <?php foreach ($chapters as $c): ?>
            <div class="card" onclick="location.href='/documents?chapter_id=<?= (int)$c['id'] ?>'">
                <div class="card-strip" style="background:<?= htmlspecialchars($c['color'], ENT_QUOTES) ?>"></div>
                <div class="card-body">
                    <div class="card-name"><?= htmlspecialchars($c['name'], ENT_QUOTES) ?></div>
                </div>
                <div class="card-actions" onclick="event.stopPropagation()">
                    <a href="/courses/export?chapter_id=<?= (int)$c['id'] ?>" class="btn-icon btn-download" title="Export"><?= $iconExp ?></a>
                    <a href="/chapters/edit?id=<?= (int)$c['id'] ?>" class="btn-icon btn-edit" title="Edit"><?= $iconEdit ?></a>
                    <form method="post" action="/chapters/delete">
                        <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                        <input type="hidden" name="theme_id" value="<?= (int)$theme['id'] ?>">
                        <button type="button" class="btn-icon btn-delete" title="Delete"
                                onclick="esConfirm('<?= htmlspecialchars(sprintf(__('courses.delete_confirm'), addslashes($c['name'])), ENT_QUOTES) ?>',()=>this.closest('form').submit())"><?= $iconDel ?></button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
(function(){
    var key='es_view_chapters', v=localStorage.getItem(key)||'list';
    apply(v);
    document.getElementById('btn-list').onclick=function(){apply('list')};
    document.getElementById('btn-grid').onclick=function(){apply('grid')};
    function apply(v){
        localStorage.setItem(key,v);
        var el=document.getElementById('items');
        if(el)el.className=v==='grid'?'card-grid':'card-list';
        document.getElementById('btn-list').classList.toggle('active',v==='list');
        document.getElementById('btn-grid').classList.toggle('active',v==='grid');
    }
})();
</script>
