<style>
.breadcrumb{font-size:.85rem;color:#6b7280;margin-bottom:1.25rem}.breadcrumb a{color:#6366f1;text-decoration:none}
.form-card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:1.5rem;max-width:500px;margin:0 auto}
.form-card h1{font-size:1.1rem;font-weight:700;margin-bottom:1.25rem}
.field{margin-bottom:1.1rem}
.field label{display:block;font-size:.875rem;font-weight:500;margin-bottom:.35rem;color:#374151}
.field input[type="text"],.field textarea{width:100%;padding:.5rem .75rem;border:1px solid #d1d5db;border-radius:6px;font-size:.9rem}
.field input[type="text"]:focus,.field textarea:focus{outline:none;border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.field textarea{resize:vertical;min-height:72px}
.current-file{display:inline-flex;align-items:center;gap:.4rem;padding:.35rem .65rem;background:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;font-size:.82rem;color:#374151;margin-bottom:.5rem}
.file-row{display:flex;align-items:center;gap:.75rem;flex-wrap:wrap}
.file-btn{display:inline-flex;align-items:center;gap:.4rem;padding:.45rem .9rem;border-radius:6px;border:1px solid #d1d5db;background:#f3f4f6;cursor:pointer;font-size:.85rem;color:#374151;user-select:none;white-space:nowrap}
.file-btn:hover{background:#e5e7eb;border-color:#9ca3af}
.file-name-lbl{font-size:.85rem;color:#6b7280}
.field-hint{font-size:.78rem;color:#9ca3af;margin-top:.3rem}
.form-actions{display:flex;gap:.75rem;margin-top:1.4rem}
.btn{display:inline-flex;align-items:center;padding:.5rem 1.1rem;border-radius:6px;font-size:.875rem;font-weight:500;text-decoration:none;cursor:pointer;border:none}
.btn-primary{background:#6366f1;color:#fff}.btn-primary:hover{background:#4f46e5}
.btn-secondary{background:#f3f4f6;color:#374151}.btn-secondary:hover{background:#e5e7eb}
.btn-back{width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;border:1px solid #e5e7eb;background:transparent;color:#6b7280;cursor:pointer;text-decoration:none;flex-shrink:0}.btn-back:hover{background:#f3f4f6;color:#1a1a1a}
</style>

<div style="display:flex;align-items:center;gap:.75rem;max-width:500px;margin:0 auto 1.25rem;">
    <a href="/documents?chapter_id=<?= (int)$doc['chapter_id'] ?>" class="btn-back" title="Back"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
    <p class="breadcrumb" style="margin:0;max-width:none;">
        <a href="/courses">Subjects</a> ›
        <a href="/themes?subject_id=<?= (int)$doc['subject_id'] ?>"><?= htmlspecialchars($doc['subject_name'], ENT_QUOTES) ?></a> ›
        <a href="/chapters?theme_id=<?= (int)$doc['theme_id'] ?>"><?= htmlspecialchars($doc['theme_name'], ENT_QUOTES) ?></a> ›
        <a href="/documents?chapter_id=<?= (int)$doc['chapter_id'] ?>"><?= htmlspecialchars($doc['chapter_name'], ENT_QUOTES) ?></a> ›
        Edit
    </p>
</div>

<div class="form-card">
    <h1>Edit document</h1>
    <form method="post" action="/documents/edit" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= (int)$doc['id'] ?>">
        <div class="field">
            <label for="title">Title <span style="color:#ef4444">*</span></label>
            <input type="text" id="title" name="title" maxlength="255" required autofocus
                   value="<?= htmlspecialchars($doc['title'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="description">Description <span style="font-weight:400;color:#9ca3af">(optional)</span></label>
            <textarea id="description" name="description" maxlength="1000"><?= htmlspecialchars($doc['description'] ?? '', ENT_QUOTES) ?></textarea>
        </div>
        <div class="field">
            <label>Replace file <span style="font-weight:400;color:#9ca3af">(optional)</span></label>
            <?php if (!empty($doc['original_name'])): ?>
                <div class="current-file">
                    <span>Current:</span>
                    <strong><?= htmlspecialchars($doc['original_name'], ENT_QUOTES) ?></strong>
                </div><br>
            <?php endif; ?>
            <div class="file-row">
                <label for="file" class="file-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    Choose file
                </label>
                <span class="file-name-lbl" id="fn">No file chosen</span>
            </div>
            <input type="file" id="file" name="file" style="display:none"
                   onchange="document.getElementById('fn').textContent=this.files[0]?this.files[0].name:'No file chosen'">
            <p class="field-hint">Leave empty to keep current file — max 50 MB</p>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
