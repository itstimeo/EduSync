<style>
.breadcrumb{font-size:.85rem;color:#6b7280;max-width:500px;margin:0 auto 1.25rem}.breadcrumb a{color:#6366f1;text-decoration:none}
.form-card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:1.5rem;max-width:500px;margin:0 auto}
.form-card h1{font-size:1.1rem;font-weight:700;margin-bottom:1.25rem}
.field{margin-bottom:1.1rem}
.field label{display:block;font-size:.875rem;font-weight:500;margin-bottom:.35rem;color:#374151}
.field input[type="text"],.field textarea{width:100%;padding:.5rem .75rem;border:1px solid #d1d5db;border-radius:6px;font-size:.9rem}
.field input[type="text"]:focus,.field textarea:focus{outline:none;border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.field textarea{resize:vertical;min-height:72px}
.file-row{display:flex;align-items:center;gap:.75rem;flex-wrap:wrap}
.file-btn{display:inline-flex;align-items:center;gap:.4rem;padding:.45rem .9rem;border-radius:6px;border:1px solid #d1d5db;background:#f3f4f6;cursor:pointer;font-size:.85rem;color:#374151;user-select:none;white-space:nowrap}
.file-btn:hover{background:#e5e7eb;border-color:#9ca3af}
.file-btn svg{flex-shrink:0}
.file-btn.file-invalid{border-color:#ef4444;background:#fee2e2;color:#b91c1c}
.file-name-lbl{font-size:.85rem;color:#6b7280;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.field-hint{font-size:.78rem;color:#9ca3af;margin-top:.3rem}
.form-actions{display:flex;gap:.75rem;margin-top:1.4rem}
.btn{display:inline-flex;align-items:center;padding:.5rem 1.1rem;border-radius:6px;font-size:.875rem;font-weight:500;text-decoration:none;cursor:pointer;border:none}
.btn-primary{background:#6366f1;color:#fff}.btn-primary:hover{background:#4f46e5}
.btn-secondary{background:#f3f4f6;color:#374151}.btn-secondary:hover{background:#e5e7eb}
.req{color:#ef4444;margin-left:2px}
.field-err{display:none;font-size:.78rem;color:#ef4444;margin-top:.3rem}
.field-err.show{display:block}
.field-invalid{border-color:#ef4444!important;box-shadow:0 0 0 3px rgba(239,68,68,.1)!important}
.req-note{font-size:.78rem;color:#9ca3af;margin-top:1.25rem}
.btn-back{width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;border:1px solid #e5e7eb;background:transparent;color:#6b7280;cursor:pointer;text-decoration:none;flex-shrink:0}.btn-back:hover{background:#f3f4f6;color:#1a1a1a}
</style>

<div style="display:flex;align-items:center;gap:.75rem;max-width:500px;margin:0 auto 1.25rem;">
    <a href="/documents?chapter_id=<?= (int)$chapter['id'] ?>" class="btn-back" title="Back"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
    <p class="breadcrumb" style="margin:0;max-width:none;">
        <a href="/courses">Subjects</a> ›
        <a href="/themes?subject_id=<?= (int)$chapter['subject_id'] ?>"><?= htmlspecialchars($chapter['subject_name'], ENT_QUOTES) ?></a> ›
        <a href="/chapters?theme_id=<?= (int)$chapter['theme_id'] ?>"><?= htmlspecialchars($chapter['theme_name'], ENT_QUOTES) ?></a> ›
        <a href="/documents?chapter_id=<?= (int)$chapter['id'] ?>"><?= htmlspecialchars($chapter['name'], ENT_QUOTES) ?></a> ›
        Upload
    </p>
</div>

<div class="form-card">
    <h1>Upload document</h1>
    <form method="post" action="/documents/upload?chapter_id=<?= (int)$chapter['id'] ?>" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="chapter_id" value="<?= (int)$chapter['id'] ?>">
        <div class="field">
            <label for="title">Title <span class="req">*</span></label>
            <input type="text" id="title" name="title" maxlength="255" autofocus>
            <span class="field-err" id="err-title">Please enter a title.</span>
        </div>
        <div class="field">
            <label for="description">Description <span style="font-weight:400;color:#9ca3af">(optional)</span></label>
            <textarea id="description" name="description" maxlength="1000"></textarea>
        </div>
        <div class="field">
            <label>File <span class="req">*</span></label>
            <div class="file-row">
                <label for="file" class="file-btn" id="file-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    Choose file
                </label>
                <span class="file-name-lbl" id="fn">No file chosen</span>
            </div>
            <input type="file" id="file" name="file" style="display:none"
                   onchange="(function(f){if(!f)return;document.getElementById('fn').textContent=f.name;document.getElementById('file-btn').classList.remove('file-invalid');document.getElementById('err-file').classList.remove('show');var t=document.getElementById('title');if(!t.value.trim()){t.value=f.name.replace(/\.[^.]+$/,'');t.classList.remove('field-invalid');document.getElementById('err-title').classList.remove('show');}})(this.files[0])">
            <span class="field-err" id="err-file">Please choose a file.</span>
            <p class="field-hint">PDF, images (JPG, PNG, GIF, WebP), Word, PowerPoint, plain text — max 50 MB</p>
        </div>
        <p class="req-note"><span class="req">*</span> Required</p>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
    </form>
</div>

<script>
(function(){
    var titleEl = document.getElementById('title');
    var fileEl  = document.getElementById('file');
    titleEl.addEventListener('input', function(){ titleEl.classList.remove('field-invalid'); document.getElementById('err-title').classList.remove('show'); });
    titleEl.closest('form').addEventListener('submit', function(e){
        var valid = true;
        if (!titleEl.value.trim()) {
            titleEl.classList.add('field-invalid');
            document.getElementById('err-title').classList.add('show');
            valid = false;
        }
        if (!fileEl.files || !fileEl.files.length) {
            document.getElementById('file-btn').classList.add('file-invalid');
            document.getElementById('err-file').classList.add('show');
            valid = false;
        }
        if (!valid) {
            e.preventDefault();
            document.querySelector('.field-err.show, .file-invalid').scrollIntoView({behavior:'smooth',block:'center'});
        }
    });
})();
</script>
