<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?> — EduSync</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, sans-serif; background: #f5f5f5; color: #1a1a1a; min-height: 100vh; }
        header { background: #fff; border-bottom: 1px solid #e5e7eb; padding: .75rem 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        header .logo { font-weight: 700; font-size: 1.1rem; color: #6366f1; }
        header .user { font-size: .875rem; color: #6b7280; }
        nav { background: #fff; border-bottom: 1px solid #e5e7eb; padding: 0 1.5rem; }
        nav a { display: inline-block; padding: .75rem 1rem; font-size: .875rem; color: #6b7280; text-decoration: none; border-bottom: 2px solid transparent; }
        nav a.active { color: #6366f1; border-bottom-color: #6366f1; font-weight: 600; }
        nav a:hover { color: #6366f1; }
        .wrapper { max-width: 900px; margin: 2rem auto; padding: 0 1.5rem; }
        .flash { padding: .6rem 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: .9rem; }
        .flash.error   { background: #fee2e2; color: #b91c1c; }
        .flash.success { background: #dcfce7; color: #15803d; }
        /* ── Global icon buttons ── */
        .btn-icon{width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;cursor:pointer;border:1px solid #e5e7eb;background:transparent;color:#6b7280;text-decoration:none;flex-shrink:0}
        .btn-edit{background:#f3f4f6;color:#6b7280;border-color:#e5e7eb}.btn-edit:hover{background:#e5e7eb}
        .btn-delete{background:#fee2e2;color:#f87171;border-color:#fecaca}.btn-delete:hover{background:#fecaca}
        .btn-download{background:#dbeafe;color:#60a5fa;border-color:#bfdbfe}.btn-download:hover{background:#bfdbfe}
        .btn-done{background:#dcfce7;color:#22c55e;border-color:#bbf7d0}.btn-done:hover{background:#bbf7d0}
        .btn-back{width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;border:1px solid #e5e7eb;background:transparent;color:#6b7280;cursor:pointer;text-decoration:none;flex-shrink:0}.btn-back:hover{background:#f3f4f6;color:#1a1a1a}
    </style>
</head>
<body>
    <header>
        <span class="logo">EduSync</span>
        <span class="user">
            <?= htmlspecialchars($userName ?? '') ?>
            <a href="/logout" style="margin-left:1rem;font-size:.8rem;color:#9ca3af;text-decoration:none;" onmouseover="this.style.color='#6366f1'" onmouseout="this.style.color='#9ca3af'">Log out</a>
        </span>
    </header>
    <nav>
        <?php $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH); ?>
        <a href="/dashboard"<?= $uri === '/dashboard' ? ' class="active"' : '' ?>>Dashboard</a>
        <?php
            $coursesActive = str_starts_with($uri, '/courses')
                          || str_starts_with($uri, '/themes')
                          || str_starts_with($uri, '/chapters')
                          || str_starts_with($uri, '/documents');
        ?>
        <a href="/courses"<?= $coursesActive ? ' class="active"' : '' ?>>Courses</a>
        <a href="/grades"<?= str_starts_with($uri, '/grades') ? ' class="active"' : '' ?>>Grades</a>
        <a href="/planning"<?= str_starts_with($uri, '/planning') ? ' class="active"' : '' ?>>Planning</a>
        <a href="/revision"<?= str_starts_with($uri, '/revision') ? ' class="active"' : '' ?>>Revision</a>
    </nav>
    <div class="wrapper">
        <?php if (!empty($flash)): ?>
            <div class="flash <?= htmlspecialchars($flash['type']) ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>
        <?= $content ?>
    </div>
    <!-- Confirm modal -->
    <div id="es-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:9999;align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:12px;padding:1.5rem 1.75rem;max-width:380px;width:90%;box-shadow:0 8px 32px rgba(0,0,0,.18);">
            <p id="es-modal-msg" style="margin-bottom:1.5rem;font-size:.95rem;color:#1a1a1a;line-height:1.5;"></p>
            <div style="display:flex;gap:.75rem;justify-content:flex-end;">
                <button id="es-modal-cancel" style="padding:.5rem 1.1rem;border:1px solid #d1d5db;border-radius:6px;background:#f3f4f6;cursor:pointer;font-size:.875rem;font-weight:500;">Cancel</button>
                <button id="es-modal-confirm" style="padding:.5rem 1.1rem;border:none;border-radius:6px;background:#ef4444;color:#fff;cursor:pointer;font-size:.875rem;font-weight:600;">Delete</button>
            </div>
        </div>
    </div>
    <script>
    (function () {
        var overlay = document.getElementById('es-modal');
        var _fn = null;
        window.esConfirm = function (msg, fn) {
            document.getElementById('es-modal-msg').textContent = msg;
            _fn = fn;
            overlay.style.display = 'flex';
        };
        document.getElementById('es-modal-cancel').onclick = function () {
            overlay.style.display = 'none'; _fn = null;
        };
        document.getElementById('es-modal-confirm').onclick = function () {
            overlay.style.display = 'none';
            if (_fn) _fn();
        };
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) { overlay.style.display = 'none'; _fn = null; }
        });
    })();
    </script>
</body>
</html>
