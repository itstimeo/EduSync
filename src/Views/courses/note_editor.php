<?php
$isEdit     = $note !== null;
$chapterId  = (int) $chapter['id'];
$formAction = $isEdit ? '/documents/note/edit' : '/documents/note/new';
$backUrl    = $isEdit ? '/documents/view?id=' . (int)$note['id'] : '/documents?chapter_id=' . $chapterId;
?>
<style>
.breadcrumb{font-size:.85rem;color:var(--text-muted)}.breadcrumb a{color:#6366f1;text-decoration:none}
.editor-wrap{background:var(--surface);border:1px solid var(--border);border-radius:10px;overflow:hidden;max-width:820px;margin:0 auto}
.editor-meta{padding:1.25rem 1.5rem 0}
.editor-meta h1{font-size:1.1rem;font-weight:700;margin-bottom:1.1rem}
.field{margin-bottom:1rem}
.field label{display:block;font-size:.875rem;font-weight:500;margin-bottom:.35rem;color:var(--text)}
.field input[type="text"],.field textarea{width:100%;padding:.5rem .75rem;border:1px solid var(--border-soft);border-radius:6px;font-size:.9rem;background:var(--input-bg);color:var(--text);box-sizing:border-box}
.field input[type="text"]:focus,.field textarea:focus{outline:none;border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.field textarea{resize:vertical;min-height:60px}
.field-err{display:none;font-size:.78rem;color:#ef4444;margin-top:.3rem}
.field-err.show{display:block}
.field-invalid{border-color:#ef4444!important;box-shadow:0 0 0 3px rgba(239,68,68,.1)!important}
.req{color:#ef4444;margin-left:2px}
.toolbar{display:flex;align-items:center;gap:2px;padding:.55rem .75rem;border-top:1px solid var(--border);border-bottom:1px solid var(--border);background:var(--bg-subtle);flex-wrap:wrap;row-gap:4px}
.tb-btn{display:inline-flex;align-items:center;justify-content:center;min-width:30px;height:28px;padding:0 .4rem;border-radius:5px;border:1px solid transparent;background:transparent;cursor:pointer;font-size:.8rem;font-weight:600;color:var(--text);line-height:1;user-select:none;white-space:nowrap;font-family:inherit}
.tb-btn:hover{background:var(--border);border-color:var(--border-soft)}
.tb-btn.active{background:#6366f1;color:#fff;border-color:#6366f1}
.tb-sep{width:1px;height:18px;background:var(--border);margin:0 3px;flex-shrink:0}
.editor-area{min-height:340px;padding:1.25rem 1.5rem;outline:none;font-size:.95rem;line-height:1.75;color:var(--text);background:var(--surface);overflow-y:auto}
.editor-area:empty::before{content:attr(data-placeholder);color:var(--text-subtle);pointer-events:none}
.editor-area h1{font-size:1.4rem;font-weight:700;margin:.75rem 0 .35rem}
.editor-area h2{font-size:1.2rem;font-weight:700;margin:.75rem 0 .35rem}
.editor-area h3{font-size:1.05rem;font-weight:600;margin:.6rem 0 .25rem}
.editor-area ul,.editor-area ol{padding-left:1.5rem;margin:.35rem 0}
.editor-area li{margin:.15rem 0}
.editor-area hr{border:none;border-top:1px solid var(--border);margin:.75rem 0}
.editor-area [style*="background-color"]{color:#111111}
.editor-footer{padding:.85rem 1.5rem;border-top:1px solid var(--border);display:flex;gap:.75rem;align-items:center}
.tb-color-wrap{position:relative}
.tb-color-btn{flex-direction:column;gap:0;height:28px;padding:0 .45rem}
.tb-color-btn span.lbl{font-size:.8rem;font-weight:700;line-height:1.1}
.color-bar{width:16px;height:3px;border-radius:1px;margin-top:2px}
.color-drop{display:none;position:fixed;background:var(--surface);border:1px solid var(--border-soft);border-radius:8px;padding:.45rem;z-index:9999;box-shadow:0 4px 16px rgba(0,0,0,.15);grid-template-columns:repeat(5,22px);gap:3px}
.color-drop.open{display:grid}
.color-swatch{width:22px;height:22px;border-radius:4px;cursor:pointer;border:2px solid transparent;box-sizing:border-box}
.color-swatch:hover{border-color:#6366f1}
.color-swatch.swatch-none{background:linear-gradient(to bottom right,#fff 44%,#ef4444 44%,#ef4444 56%,#fff 56%);border:1px solid #d1d5db}
</style>

<div style="display:flex;align-items:center;gap:.75rem;max-width:820px;margin:0 auto 1.25rem;">
    <a href="<?= htmlspecialchars($backUrl, ENT_QUOTES) ?>" class="btn-back" title="Back">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <p class="breadcrumb" style="margin:0">
        <a href="/courses">Subjects</a> ›
        <a href="/themes?subject_id=<?= (int)$chapter['subject_id'] ?>"><?= htmlspecialchars($chapter['subject_name'], ENT_QUOTES) ?></a> ›
        <a href="/chapters?theme_id=<?= (int)$chapter['theme_id'] ?>"><?= htmlspecialchars($chapter['theme_name'], ENT_QUOTES) ?></a> ›
        <a href="/documents?chapter_id=<?= $chapterId ?>"><?= htmlspecialchars($chapter['name'], ENT_QUOTES) ?></a> ›
        <?= $isEdit ? htmlspecialchars($note['title'], ENT_QUOTES) : 'New note' ?>
    </p>
</div>

<form method="post" action="<?= $formAction ?>" novalidate id="note-form">
    <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= (int)$note['id'] ?>">
    <?php else: ?>
        <input type="hidden" name="chapter_id" value="<?= $chapterId ?>">
    <?php endif; ?>
    <input type="hidden" name="content" id="content-input">

    <div class="editor-wrap">
        <div class="editor-meta">
            <h1><?= $isEdit ? 'Edit note' : 'New note' ?></h1>
            <div class="field">
                <label for="title">Title <span class="req">*</span></label>
                <input type="text" id="title" name="title" maxlength="255" autofocus
                       value="<?= $isEdit ? htmlspecialchars($note['title'], ENT_QUOTES) : '' ?>">
                <span class="field-err" id="err-title">Please enter a title.</span>
            </div>
            <div class="field">
                <label for="description">Description <span style="font-weight:400;color:var(--text-subtle)">(optional)</span></label>
                <textarea id="description" name="description" maxlength="1000"><?= $isEdit ? htmlspecialchars($note['description'] ?? '', ENT_QUOTES) : '' ?></textarea>
            </div>
        </div>

        <div class="toolbar" id="toolbar">
            <!-- Inline formatting -->
            <button type="button" class="tb-btn" data-cmd="bold"           title="Bold (Ctrl+B)"><b>B</b></button>
            <button type="button" class="tb-btn" data-cmd="italic"         title="Italic (Ctrl+I)"><i>I</i></button>
            <button type="button" class="tb-btn" data-cmd="underline"      title="Underline (Ctrl+U)"><u>U</u></button>
            <button type="button" class="tb-btn" data-cmd="strikeThrough"  title="Strikethrough"><s>S</s></button>
            <div class="tb-sep"></div>
            <!-- Superscript / Subscript -->
            <button type="button" class="tb-btn" data-cmd="superscript" title="Superscript">x<sup>2</sup></button>
            <button type="button" class="tb-btn" data-cmd="subscript"   title="Subscript">x<sub>2</sub></button>
            <div class="tb-sep"></div>
            <!-- Block format -->
            <button type="button" class="tb-btn" data-cmd="formatBlock" data-val="h1" title="Heading 1">H1</button>
            <button type="button" class="tb-btn" data-cmd="formatBlock" data-val="h2" title="Heading 2">H2</button>
            <button type="button" class="tb-btn" data-cmd="formatBlock" data-val="h3" title="Heading 3">H3</button>
            <button type="button" class="tb-btn" data-cmd="formatBlock" data-val="p"  title="Paragraph">¶</button>
            <div class="tb-sep"></div>
            <!-- Lists -->
            <button type="button" class="tb-btn" data-cmd="insertUnorderedList" title="Bullet list">• List</button>
            <button type="button" class="tb-btn" data-cmd="insertOrderedList"   title="Numbered list">1. List</button>
            <div class="tb-sep"></div>
            <!-- Alignment -->
            <button type="button" class="tb-btn" data-cmd="justifyLeft"   title="Align left">≡L</button>
            <button type="button" class="tb-btn" data-cmd="justifyCenter" title="Align center">≡C</button>
            <button type="button" class="tb-btn" data-cmd="justifyRight"  title="Align right">≡R</button>
            <div class="tb-sep"></div>
            <!-- Indent -->
            <button type="button" class="tb-btn" data-cmd="outdent" title="Outdent">⇤</button>
            <button type="button" class="tb-btn" data-cmd="indent"  title="Indent">⇥</button>
            <div class="tb-sep"></div>
            <!-- Horizontal rule -->
            <button type="button" class="tb-btn" data-cmd="insertHorizontalRule" title="Horizontal rule">─</button>
            <div class="tb-sep"></div>
            <!-- Text color -->
            <div class="tb-color-wrap">
                <button type="button" class="tb-btn tb-color-btn" id="btn-fg" title="Text color">
                    <span class="lbl">A</span>
                    <span class="color-bar" id="bar-fg" style="background:#111111"></span>
                </button>
                <div class="color-drop" id="drop-fg">
                    <div class="color-swatch" data-color="#111111" style="background:#111111" title="Black"></div>
                    <div class="color-swatch" data-color="#6b7280" style="background:#6b7280" title="Gray"></div>
                    <div class="color-swatch" data-color="#ef4444" style="background:#ef4444" title="Red"></div>
                    <div class="color-swatch" data-color="#f97316" style="background:#f97316" title="Orange"></div>
                    <div class="color-swatch" data-color="#eab308" style="background:#eab308" title="Yellow"></div>
                    <div class="color-swatch" data-color="#22c55e" style="background:#22c55e" title="Green"></div>
                    <div class="color-swatch" data-color="#3b82f6" style="background:#3b82f6" title="Blue"></div>
                    <div class="color-swatch" data-color="#8b5cf6" style="background:#8b5cf6" title="Purple"></div>
                    <div class="color-swatch" data-color="#ec4899" style="background:#ec4899" title="Pink"></div>
                    <div class="color-swatch" data-color="#14b8a6" style="background:#14b8a6" title="Teal"></div>
                </div>
            </div>
            <!-- Highlight color -->
            <div class="tb-color-wrap">
                <button type="button" class="tb-btn tb-color-btn" id="btn-hl" title="Highlight color">
                    <span class="lbl" style="background:#fef08a;padding:0 2px;border-radius:2px;color:#111">A</span>
                    <span class="color-bar" id="bar-hl" style="background:#fef08a"></span>
                </button>
                <div class="color-drop" id="drop-hl">
                    <div class="color-swatch swatch-none" data-color="" title="Remove highlight"></div>
                    <div class="color-swatch" data-color="#fef08a" style="background:#fef08a" title="Yellow"></div>
                    <div class="color-swatch" data-color="#bbf7d0" style="background:#bbf7d0" title="Green"></div>
                    <div class="color-swatch" data-color="#bae6fd" style="background:#bae6fd" title="Blue"></div>
                    <div class="color-swatch" data-color="#fbcfe8" style="background:#fbcfe8" title="Pink"></div>
                    <div class="color-swatch" data-color="#fed7aa" style="background:#fed7aa" title="Orange"></div>
                    <div class="color-swatch" data-color="#ddd6fe" style="background:#ddd6fe" title="Purple"></div>
                    <div class="color-swatch" data-color="#fecaca" style="background:#fecaca" title="Red"></div>
                    <div class="color-swatch" data-color="#d1fae5" style="background:#d1fae5" title="Mint"></div>
                    <div class="color-swatch" data-color="#a5f3fc" style="background:#a5f3fc" title="Cyan"></div>
                </div>
            </div>
            <div class="tb-sep"></div>
            <!-- Clear -->
            <button type="button" class="tb-btn" id="btn-clear" title="Clear formatting">✕ Format</button>
        </div>

        <div id="editor"
             class="editor-area"
             contenteditable="true"
             data-placeholder="Start writing your note…"><?php if ($isEdit && !empty($note['content'])): ?><?= $note['content'] ?><?php endif; ?></div>

        <div class="editor-footer">
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <?= $isEdit ? 'Save' : 'Create note' ?>
            </button>
        </div>
    </div>
</form>

<script>
(function () {
    var editor  = document.getElementById('editor');
    var toolbar = document.getElementById('toolbar');
    var form    = document.getElementById('note-form');
    var titleEl = document.getElementById('title');
    var hidden  = document.getElementById('content-input');

    var btnFg  = document.getElementById('btn-fg');
    var btnHl  = document.getElementById('btn-hl');
    var dropFg = document.getElementById('drop-fg');
    var dropHl = document.getElementById('drop-hl');
    var barFg  = document.getElementById('bar-fg');
    var barHl  = document.getElementById('bar-hl');

    var currentFg = '#111111';
    var currentHl = '#fef08a';

    // ── Color picker helpers ────────────────────────────────────────────────

    function openDrop(drop, triggerBtn) {
        closeAllDrops();
        var rect = triggerBtn.getBoundingClientRect();
        drop.style.top  = (rect.bottom + 4) + 'px';
        drop.style.left = rect.left + 'px';
        drop.classList.add('open');
    }

    function closeAllDrops() {
        dropFg.classList.remove('open');
        dropHl.classList.remove('open');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('mousedown', function (e) {
        if (!e.target.closest('.tb-color-wrap')) {
            closeAllDrops();
        }
    });

    // Toggle dropdowns via their trigger buttons
    btnFg.addEventListener('mousedown', function (e) {
        e.preventDefault();
        if (dropFg.classList.contains('open')) { closeAllDrops(); return; }
        openDrop(dropFg, btnFg);
    });

    btnHl.addEventListener('mousedown', function (e) {
        e.preventDefault();
        if (dropHl.classList.contains('open')) { closeAllDrops(); return; }
        openDrop(dropHl, btnHl);
    });

    // Swatch clicks for text color
    dropFg.addEventListener('mousedown', function (e) {
        e.preventDefault();
        var sw = e.target.closest('.color-swatch');
        if (!sw) return;
        closeAllDrops();
        editor.focus();
        var color = sw.dataset.color;
        document.execCommand('foreColor', false, color);
        currentFg = color;
        barFg.style.background = color;
    });

    // Swatch clicks for highlight color
    dropHl.addEventListener('mousedown', function (e) {
        e.preventDefault();
        var sw = e.target.closest('.color-swatch');
        if (!sw) return;
        closeAllDrops();
        editor.focus();
        var color = sw.dataset.color;
        if (color === '') {
            // remove background color via removeFormat on selection
            document.execCommand('removeFormat', false, null);
        } else {
            document.execCommand('backColor', false, color);
            currentHl = color;
            barHl.style.background = color;
            btnHl.querySelector('.lbl').style.background = color;
        }
    });

    // ── Toolbar button actions ──────────────────────────────────────────────

    toolbar.addEventListener('mousedown', function (e) {
        var btn = e.target.closest('.tb-btn');
        if (!btn || btn.id === 'btn-fg' || btn.id === 'btn-hl') return;
        e.preventDefault();
        closeAllDrops();
        editor.focus();

        if (btn.id === 'btn-clear') {
            document.execCommand('removeFormat', false, null);
            document.execCommand('formatBlock', false, 'p');
            updateToolbarState();
            return;
        }

        var cmd = btn.dataset.cmd;
        var val = btn.dataset.val || null;
        document.execCommand(cmd, false, val);
        updateToolbarState();
    });

    // ── Toolbar active state ────────────────────────────────────────────────

    function updateToolbarState() {
        var toggleCmds = ['bold', 'italic', 'underline', 'strikeThrough', 'superscript', 'subscript',
                          'insertUnorderedList', 'insertOrderedList',
                          'justifyLeft', 'justifyCenter', 'justifyRight'];
        toggleCmds.forEach(function (cmd) {
            var btn = toolbar.querySelector('[data-cmd="' + cmd + '"]');
            if (btn) btn.classList.toggle('active', document.queryCommandState(cmd));
        });
        var block = document.queryCommandValue('formatBlock').toLowerCase();
        ['h1', 'h2', 'h3', 'p'].forEach(function (tag) {
            var btn = toolbar.querySelector('[data-cmd="formatBlock"][data-val="' + tag + '"]');
            if (btn) btn.classList.toggle('active', block === tag);
        });
    }

    editor.addEventListener('keyup', updateToolbarState);
    editor.addEventListener('mouseup', updateToolbarState);
    document.addEventListener('selectionchange', function () {
        if (document.activeElement === editor) updateToolbarState();
    });

    // ── Form submit ─────────────────────────────────────────────────────────

    form.addEventListener('submit', function (e) {
        hidden.value = editor.innerHTML;
        if (!titleEl.value.trim()) {
            titleEl.classList.add('field-invalid');
            document.getElementById('err-title').classList.add('show');
            e.preventDefault();
            titleEl.focus();
        }
    });

    titleEl.addEventListener('input', function () {
        titleEl.classList.remove('field-invalid');
        document.getElementById('err-title').classList.remove('show');
    });

    updateToolbarState();
})();
</script>
