<!DOCTYPE html>
<html lang="en">
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
        #theme-toggle { position: fixed; top: 1rem; right: 1rem; display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; padding: 0; border-radius: 99px; background: var(--surface); border: 2px outset rgba(0,0,0,.2); color: var(--text-muted); cursor: pointer; }
        html.dark #theme-toggle { border: 2px outset rgba(255,255,255,.15); }
    </style>
</head>
<body>
    <button id="theme-toggle" type="button" aria-label="Toggle dark mode"></button>
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
