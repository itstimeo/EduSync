<!DOCTYPE html>
<html lang="<?= \EduSync\Core\Lang::current() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'EduSync') ?> — EduSync</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <script>if(localStorage.getItem('theme')==='dark')document.documentElement.classList.add('dark');</script>
    <style>
        :root {
            --bg: #f5f5f5; --surface: #fff; --text: #1a1a1a;
            --text-muted: #6b7280; --text-subtle: #9ca3af;
            --border: #e5e7eb; --border-soft: #d1d5db;
            --bg-subtle: #f3f4f6; --input-bg: #fff;
        }
        html.dark {
            color-scheme: dark;
            --bg: #0f172a; --surface: #1e293b; --text: #e2e8f0;
            --text-muted: #94a3b8; --text-subtle: #64748b;
            --border: #334155; --border-soft: #475569;
            --bg-subtle: #162032; --input-bg: #0f172a;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: var(--surface); border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.1); padding: 2rem; width: 100%; max-width: 420px; }
        h1 { font-size: 1.4rem; margin-bottom: 1.5rem; text-align: center; }
        label { display: block; font-size: .85rem; font-weight: 600; margin-bottom: .25rem; margin-top: 1rem; }
        input { width: 100%; padding: .5rem .75rem; border: 1px solid var(--border-soft); border-radius: 4px; font-size: 1rem; background: var(--input-bg); color: var(--text); }
        input:focus { outline: 2px solid #6366f1; border-color: transparent; }
        button[type=submit] { margin-top: 1.5rem; width: 100%; padding: .6rem; background: #6366f1; color: #fff; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; }
        button[type=submit]:hover { background: #4f46e5; }
        .flash { padding: .6rem 1rem; border-radius: 4px; margin-bottom: 1rem; font-size: .9rem; }
        .flash.error   { background: #fee2e2; color: #b91c1c; }
        .flash.success { background: #dcfce7; color: #15803d; }
        .link { text-align: center; margin-top: 1rem; font-size: .85rem; }
        .link a { color: #6366f1; text-decoration: none; }
        .link a:hover { text-decoration: underline; }
        .top-controls{position:fixed;top:1rem;right:1rem;display:flex;align-items:center;gap:.5rem;}
        #theme-toggle { display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; padding: 0; border-radius: 99px; background: var(--surface); border: 2px outset rgba(0,0,0,.2); color: var(--text-muted); cursor: pointer; }
        html.dark #theme-toggle { border: 2px outset rgba(255,255,255,.15); }
        .lang-dropdown{position:relative;display:inline-block}
        .lang-dd-btn{display:flex;align-items:center;gap:.35rem;padding:.28rem .55rem .28rem .45rem;border-radius:8px;border:1px solid var(--border-soft);background:var(--surface);color:var(--text);cursor:pointer;font-size:.78rem;font-weight:600;font-family:inherit;transition:background .15s}
        .lang-dd-btn:hover{background:var(--bg-subtle)}
        .lang-flag{display:inline-flex;align-items:center;flex-shrink:0}
        .lang-dd-code{font-size:.78rem;font-weight:600;color:var(--text-muted)}
        .lang-dd-chevron{transition:transform .2s;color:var(--text-subtle);flex-shrink:0}
        .lang-dropdown.open .lang-dd-chevron{transform:rotate(180deg)}
        .lang-dd-menu{display:none;position:absolute;top:calc(100% + 5px);right:0;background:var(--surface);border:1px solid var(--border-soft);border-radius:10px;box-shadow:0 4px 20px rgba(0,0,0,.12);min-width:140px;overflow:hidden;z-index:1000}
        .lang-dropdown.open .lang-dd-menu{display:block}
        .lang-dd-option{display:flex;align-items:center;gap:.55rem;padding:.55rem .85rem;font-size:.85rem;color:var(--text);text-decoration:none;font-weight:500;transition:background .12s}
        .lang-dd-option:hover{background:var(--bg-subtle)}
        .lang-dd-option.active{color:#6366f1;font-weight:700;background:#f5f3ff}
        /* ── Global round checkboxes ── */
        input[type="checkbox"] { appearance:none; -webkit-appearance:none; width:16px!important; height:16px; border-radius:50%; border:2px solid var(--border-soft); background:transparent!important; cursor:pointer; position:relative; flex-shrink:0; transition:background .15s,border-color .15s; vertical-align:middle; padding:0!important; }
        input[type="checkbox"]:checked { background:#6366f1!important; border-color:#6366f1!important; }
        input[type="checkbox"]:checked::after { content:''; position:absolute; left:50%; top:50%; width:4px; height:8px; border:2px solid #fff; border-top:none; border-left:none; transform:translate(-50%,-60%) rotate(45deg); }
        @media (max-width: 480px) {
            body { padding: 3.5rem 1rem 1.5rem; align-items: flex-start; }
            .card { padding: 1.5rem 1.25rem; }
        }
    </style>
</head>
<body>
    <div class="top-controls">
        <?php include __DIR__ . '/_lang_dropdown.php'; ?>
        <button id="theme-toggle" type="button" aria-label="Toggle dark mode"></button>
    </div>
    <script>
    (function(){
        var MOON = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';
        var SUN  = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>';
        var btn = document.getElementById('theme-toggle');
        function updateIcon() { btn.innerHTML = document.documentElement.classList.contains('dark') ? MOON : SUN; }
        updateIcon();
        btn.addEventListener('click', function(){
            var dark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', dark ? 'dark' : 'light');
            updateIcon();
        });
    })();
    </script>
    <div class="card">
        <?php if (!empty($flash)): ?>
            <div class="flash <?= htmlspecialchars($flash['type']) ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>
        <?= $content ?>
    </div>
</body>
</html>
