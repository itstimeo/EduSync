<style>
.breadcrumb{font-size:.85rem;color:#6b7280}.breadcrumb a{color:#6366f1;text-decoration:none}
.doc-header{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.25rem}
.doc-title{font-size:1.2rem;font-weight:700}
.doc-desc{color:#6b7280;font-size:.9rem;margin-top:.35rem;line-height:1.5}
.doc-actions{display:flex;gap:.5rem;flex-shrink:0}
.btn{display:inline-flex;align-items:center;gap:.35rem;padding:.45rem .9rem;border-radius:6px;font-size:.85rem;font-weight:500;text-decoration:none;cursor:pointer;border:none}
.btn-primary{background:#6366f1;color:#fff}.btn-primary:hover{background:#4f46e5}
.btn-secondary{background:#f3f4f6;color:#374151}.btn-secondary:hover{background:#e5e7eb}
.viewer-box{margin-top:1rem;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;background:#f9fafb}
.viewer-box iframe{display:block;width:100%;height:76vh;border:none}
.viewer-box img{display:block;max-width:100%;margin:0 auto;padding:1rem}
#docx-container{padding:1.5rem 2rem;background:#fff;min-height:400px;line-height:1.7}
.no-preview{padding:3rem;text-align:center;color:#9ca3af}
.no-preview p{margin-bottom:1rem;font-size:.95rem}
</style>

<div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;">
    <a href="/documents?chapter_id=<?= (int)$doc['chapter_id'] ?>" class="btn-back" title="Back"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
    <p class="breadcrumb" style="margin:0;"><a href="/courses">Subjects</a> › <a href="/themes?subject_id=<?= (int)$doc['subject_id'] ?>"><?= htmlspecialchars($doc['subject_name'], ENT_QUOTES) ?></a> › <a href="/chapters?theme_id=<?= (int)$doc['theme_id'] ?>"><?= htmlspecialchars($doc['theme_name'], ENT_QUOTES) ?></a> › <a href="/documents?chapter_id=<?= (int)$doc['chapter_id'] ?>"><?= htmlspecialchars($doc['chapter_name'], ENT_QUOTES) ?></a> › <?= htmlspecialchars($doc['title'], ENT_QUOTES) ?></p>
</div>

<div class="doc-header">
    <div>
        <div class="doc-title"><?= htmlspecialchars($doc['title'], ENT_QUOTES) ?></div>
        <?php if (!empty($doc['description'])): ?>
            <div class="doc-desc"><?= htmlspecialchars($doc['description'], ENT_QUOTES) ?></div>
        <?php endif; ?>
    </div>
    <div class="doc-actions">
        <a href="/documents/edit?id=<?= (int)$doc['id'] ?>" class="btn btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.5-6.5a2.121 2.121 0 013 3L12 14l-4 1 1-4z"/></svg>
            Edit
        </a>
        <a href="/documents/download?id=<?= (int)$doc['id'] ?>" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 4v11m0 0l-3.5-3.5M12 15l3.5-3.5"/></svg>
            Download
        </a>
    </div>
</div>

<?php
    $type    = $doc['file_type'] ?? '';
    $isPdf   = str_contains($type, 'pdf');
    $isImage = str_contains($type, 'image');
    $isDocx  = $type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
?>

<div class="viewer-box">
    <?php if ($isPdf): ?>
        <iframe src="/documents/serve?id=<?= (int)$doc['id'] ?>"
                title="<?= htmlspecialchars($doc['title'], ENT_QUOTES) ?>"></iframe>

    <?php elseif ($isImage): ?>
        <img src="/documents/serve?id=<?= (int)$doc['id'] ?>"
             alt="<?= htmlspecialchars($doc['title'], ENT_QUOTES) ?>">

    <?php elseif ($isDocx): ?>
        <div id="docx-container"></div>
        <script src="https://cdn.jsdelivr.net/npm/mammoth@1.11.0/mammoth.browser.min.js"></script>
        <script>
        fetch('/documents/serve?id=<?= (int)$doc['id'] ?>')
            .then(function (r) {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.arrayBuffer();
            })
            .then(function (buf) { return mammoth.convertToHtml({ arrayBuffer: buf }); })
            .then(function (result) {
                document.getElementById('docx-container').innerHTML = result.value || '<p style="color:#9ca3af;text-align:center;padding:2rem;">Empty document.</p>';
            })
            .catch(function (err) {
                document.getElementById('docx-container').innerHTML =
                    '<p style="color:#b91c1c;text-align:center;padding:2rem;">Preview error: ' + (err && err.message ? err.message : String(err)) + '</p>';
            });
        </script>

    <?php else: ?>
        <div class="no-preview">
            <p>Preview not available for this file type (<code><?= htmlspecialchars($type, ENT_QUOTES) ?></code>).</p>
            <a href="/documents/download?id=<?= (int)$doc['id'] ?>" class="btn btn-primary">
                ↓ Download file
            </a>
        </div>
    <?php endif; ?>
</div>
