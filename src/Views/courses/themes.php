<?php
$iconEdit = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.5-6.5a2.121 2.121 0 013 3L12 14l-4 1 1-4z"/></svg>';
$iconDel  = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16M10 3h4a1 1 0 011 1v3H9V4a1 1 0 011-1z"/></svg>';
?>
<style>
.breadcrumb{font-size:.85rem;color:#6b7280}.breadcrumb a{color:#6366f1;text-decoration:none}
.page-hd{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem}
.page-hd h1{font-size:1.25rem;font-weight:700;display:flex;align-items:center;gap:.55rem}
.subj-dot{width:12px;height:12px;border-radius:50%;display:inline-block;flex-shrink:0}
.hd-right{display:flex;align-items:center;gap:.75rem}
.view-toggle{display:flex;gap:2px}
.view-toggle button{padding:.35rem .55rem;border:1px solid #d1d5db;border-radius:5px;background:#fff;cursor:pointer;font-size:.85rem;color:#6b7280;line-height:1}
.view-toggle button.active{background:#6366f1;color:#fff;border-color:#6366f1}
.btn{display:inline-flex;align-items:center;gap:.3rem;padding:.45rem .9rem;border-radius:6px;font-size:.85rem;font-weight:500;text-decoration:none;cursor:pointer;border:none}
.btn-primary{background:#6366f1;color:#fff}.btn-primary:hover{background:#4f46e5}
.empty{color:#9ca3af;font-size:.9rem;padding:3rem 0;text-align:center}
.card-list{display:flex;flex-direction:column;gap:.55rem}
.card{background:#fff;border:1px solid #e5e7eb;border-radius:8px;cursor:pointer;transition:box-shadow .15s;overflow:hidden}
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
.card-grid .card-actions{padding:.45rem .75rem .6rem;display:flex;flex-wrap:wrap;gap:.35rem;border-top:1px solid #f3f4f6}
</style>

<div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;">
    <a href="/courses" class="btn-back" title="Back"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
    <p class="breadcrumb" style="margin:0;"><a href="/courses">Subjects</a> › <?= htmlspecialchars($subject['name'], ENT_QUOTES) ?></p>
</div>
<div class="page-hd">
    <h1>
        <span class="subj-dot" style="background:<?= htmlspecialchars($subject['color'], ENT_QUOTES) ?>"></span>
        <?= htmlspecialchars($subject['name'], ENT_QUOTES) ?>
    </h1>
    <div class="hd-right">
        <div class="view-toggle">
            <button id="btn-list" type="button" title="List">☰</button>
            <button id="btn-grid" type="button" title="Grid">⊞</button>
        </div>
        <a href="/themes/create?subject_id=<?= (int)$subject['id'] ?>" class="btn btn-primary">+ New theme</a>
    </div>
</div>

<?php if (empty($themes)): ?>
    <p class="empty">No themes yet.</p>
<?php else: ?>
    <div id="items">
        <?php foreach ($themes as $t): ?>
            <div class="card" onclick="location.href='/chapters?theme_id=<?= (int)$t['id'] ?>'">
                <div class="card-strip" style="background:<?= htmlspecialchars($t['color'], ENT_QUOTES) ?>"></div>
                <div class="card-body">
                    <div class="card-name"><?= htmlspecialchars($t['name'], ENT_QUOTES) ?></div>
                </div>
                <div class="card-actions" onclick="event.stopPropagation()">
                    <a href="/themes/edit?id=<?= (int)$t['id'] ?>" class="btn-icon btn-edit" title="Edit"><?= $iconEdit ?></a>
                    <form method="post" action="/themes/delete">
                        <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                        <input type="hidden" name="subject_id" value="<?= (int)$subject['id'] ?>">
                        <button type="button" class="btn-icon btn-delete" title="Delete"
                                onclick="esConfirm('Delete «<?= htmlspecialchars(addslashes($t['name']), ENT_QUOTES) ?>» and all its content?',()=>this.closest('form').submit())"><?= $iconDel ?></button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
(function(){
    var key='es_view_themes', v=localStorage.getItem(key)||'list';
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
