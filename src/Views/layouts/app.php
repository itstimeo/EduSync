<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?> — EduSync</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, sans-serif; background: #f5f5f5; color: #1a1a1a; min-height: 100vh; }
        body::before { content: ''; display: block; height: 4px; background: linear-gradient(90deg, #6366f1, #8b5cf6, #a855f7); }
        header { background: #fff; border-radius: 0 0 99px 99px; box-shadow: 0 4px 20px rgba(0,0,0,.1), 0 1px 4px rgba(0,0,0,.06); display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; height: 56px; padding: 0 1rem; gap: 2.5rem; margin: 0 1.5rem; }
        header .nav-left  { display: flex; align-items: center; justify-content: flex-end; gap: .25rem; }
        header .nav-center { display: flex; align-items: center; justify-content: center; }
        header .nav-center a { font-weight: 800; font-size: 1.55rem; color: #6366f1; text-decoration: none; line-height: 1; letter-spacing: -.02em; }
        header .nav-center a:hover { color: #4f46e5; }
        header .nav-right { display: flex; align-items: center; justify-content: flex-start; gap: .25rem; padding-right: 1.5rem; }
        header .user { margin-left: auto; font-size: .875rem; color: #6b7280; white-space: nowrap; }
        .nav-link { display: inline-flex; align-items: center; height: 38px; padding: 0 1.1rem; font-size: .875rem; color: #6b7280; text-decoration: none; border-radius: 99px; font-weight: 500; white-space: nowrap; }
        .nav-link.active { background: #6366f1; color: #fff; font-weight: 600; }
        .nav-link:hover:not(.active) { color: #6366f1; background: #f5f3ff; }
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
        a[href],button,[onclick]:not(.card-actions),.card{transition:transform .15s ease;}
        a[href]:hover,button:hover,[onclick]:not(.card-actions):hover,.card:hover{transform:scale(1.03);}
        header{transition:transform .15s ease;transform-origin:top center;}
        header:hover{transform:scale(1.015);}
        footer{display:flex;align-items:center;gap:1rem;padding:2rem 2rem 1.5rem;font-size:.8rem;color:#9ca3af;}
        footer::before,footer::after{content:'';flex:1;height:1px;background:#e5e7eb;}
    </style>
</head>
<body>
    <?php
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $coursesActive = str_starts_with($uri, '/courses')
                      || str_starts_with($uri, '/themes')
                      || str_starts_with($uri, '/chapters')
                      || str_starts_with($uri, '/documents');
    ?>
    <header>
        <div class="nav-left">
            <a href="/courses" class="nav-link<?= $coursesActive ? ' active' : '' ?>">Courses</a>
            <a href="/grades"  class="nav-link<?= str_starts_with($uri, '/grades') ? ' active' : '' ?>">Grades</a>
        </div>
        <div class="nav-center">
            <a href="/dashboard" style="display:flex;align-items:center;gap:.5rem;">
                <svg width="50" height="50" viewBox="2 10 60 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <defs>
                    <marker id="nl" viewBox="0 0 10 10" refX="0" refY="5" markerWidth="8" markerHeight="8" markerUnits="userSpaceOnUse" orient="auto">
                      <path d="M0 0 L10 5 L0 10 Z" fill="#6366f1" fill-opacity=".6"/>
                    </marker>
                  </defs>
                  <path d="M4 56 C8 46,16 36,22 40 C28 44,30 48,36 42 C42 36,46 22,48 16" stroke="#6366f1" stroke-width="1.5" stroke-linecap="butt" fill="none" stroke-opacity=".6" marker-end="url(#nl)"/>
                  <rect x="10" y="35" width="44" height="23" rx="1" fill="#6366f1" opacity=".2" stroke="#6366f1" stroke-width="1.5" stroke-opacity=".7"/>
                  <rect x="10" y="30" width="16" height="6" fill="#6366f1" opacity=".35" stroke="#6366f1" stroke-width="1.2" stroke-opacity=".7"/>
                  <rect x="38" y="30" width="16" height="6" fill="#6366f1" opacity=".35" stroke="#6366f1" stroke-width="1.2" stroke-opacity=".7"/>
                  <path d="M22 30l6-10h8l6 10H22z" fill="#6366f1" opacity=".5" stroke="#6366f1" stroke-width="1.5" stroke-opacity=".7" stroke-linejoin="round"/>
                  <path d="M32 20v-6" stroke="#6366f1" stroke-width="1.5" stroke-linecap="round" stroke-opacity=".7"/>
                  <path d="M32 14l5 2-5 2" fill="#6366f1" stroke="#6366f1" stroke-width="1" stroke-linejoin="round" opacity=".7"/>
                  <rect x="13" y="37" width="4" height="4" rx=".4" fill="#6366f1" opacity=".65"/>
                  <rect x="20" y="37" width="4" height="4" rx=".4" fill="#6366f1" opacity=".65"/>
                  <rect x="40" y="37" width="4" height="4" rx=".4" fill="#6366f1" opacity=".65"/>
                  <rect x="47" y="37" width="4" height="4" rx=".4" fill="#6366f1" opacity=".65"/>
                  <rect x="13" y="43" width="4" height="4" rx=".4" fill="#6366f1" opacity=".65"/>
                  <rect x="20" y="43" width="4" height="4" rx=".4" fill="#6366f1" opacity=".65"/>
                  <rect x="40" y="43" width="4" height="4" rx=".4" fill="#6366f1" opacity=".65"/>
                  <rect x="47" y="43" width="4" height="4" rx=".4" fill="#6366f1" opacity=".65"/>
                  <rect x="28" y="47" width="8" height="11" rx="4" fill="#6366f1" opacity=".85"/>
                </svg>
                EduSync
            </a>
        </div>
        <div class="nav-right">
            <a href="/planning" class="nav-link<?= str_starts_with($uri, '/planning') ? ' active' : '' ?>">Planning</a>
            <a href="/revision" class="nav-link<?= str_starts_with($uri, '/revision') ? ' active' : '' ?>">Revision</a>
            <span class="user">
                <?= htmlspecialchars($userName ?? '') ?>
                <a href="/logout" style="margin-left:1rem;font-size:.8rem;color:#9ca3af;text-decoration:none;" onmouseover="this.style.color='#6366f1'" onmouseout="this.style.color='#9ca3af'">Log out</a>
            </span>
        </div>
    </header>
    <div class="wrapper">
        <?php if (!empty($flash)): ?>
            <div class="flash <?= htmlspecialchars($flash['type']) ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>
        <?= $content ?>
    </div>
    <footer>© 2026 EduSync · v0.10.0</footer>
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
