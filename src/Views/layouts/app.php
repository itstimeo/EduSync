<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?> — EduSync</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <script>if(localStorage.getItem('theme')==='dark')document.documentElement.classList.add('dark');</script>
    <style>
        :root {
            --bg: #f5f5f5; --surface: #fff; --text: #1a1a1a;
            --text-muted: #6b7280; --text-subtle: #9ca3af;
            --border: #e5e7eb; --border-soft: #d1d5db;
            --bg-subtle: #f3f4f6; --bg-hover: #f9fafb; --input-bg: #fff;
            --nav-hover-bg: #f5f3ff;
            --purple-tint: #f5f3ff; --purple-tint-2: #ede9fe; --purple-tint-3: #e0e7ff;
        }
        html.dark {
            color-scheme: dark;
            --bg: #0f172a; --surface: #1e293b; --text: #e2e8f0;
            --text-muted: #94a3b8; --text-subtle: #64748b;
            --border: #334155; --border-soft: #475569;
            --bg-subtle: #162032; --bg-hover: #1e293b; --input-bg: #0f172a;
            --nav-hover-bg: rgba(99,102,241,.15);
            --purple-tint: #1e1b4b; --purple-tint-2: #1e1b4b; --purple-tint-3: #1e274d;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }
        body::before { content: ''; display: block; height: 4px; background: linear-gradient(90deg, #6366f1, #8b5cf6, #a855f7); }
        header { background: var(--surface); border-radius: 0 0 99px 99px; box-shadow: 0 4px 20px rgba(0,0,0,.1), 0 1px 4px rgba(0,0,0,.06); display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; height: 56px; padding: 0 1rem; gap: 2.5rem; margin: 0 1.5rem; }
        header .nav-left  { display: flex; align-items: center; justify-content: flex-end; gap: .25rem; }
        header .nav-center { display: flex; align-items: center; justify-content: center; }
        header .nav-center a { font-weight: 800; font-size: 1.55rem; color: #6366f1; text-decoration: none; line-height: 1; letter-spacing: -.02em; }
        header .nav-center a:hover { color: #4f46e5; }
        header .nav-right { display: flex; align-items: center; justify-content: flex-start; gap: .25rem; padding-right: 1.5rem; }
        header .user { margin-left: auto; font-size: .875rem; color: var(--text-muted); white-space: nowrap; display: flex; align-items: center; gap: .6rem; }
        .nav-avatar-link { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:50%; overflow:hidden; text-decoration:none; flex-shrink:0; }
        .nav-avatar-img { width:32px; height:32px; border-radius:50%; object-fit:cover; display:block; }
        .nav-avatar-initials { width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; font-size:.75rem; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .nav-link { display: inline-flex; align-items: center; height: 38px; padding: 0 1.1rem; font-size: .875rem; color: var(--text-muted); text-decoration: none; border-radius: 99px; font-weight: 500; white-space: nowrap; }
        .nav-link.active { background: #6366f1; color: #fff; font-weight: 600; }
        .nav-link:hover:not(.active) { color: #6366f1; background: var(--nav-hover-bg); }
        .wrapper { max-width: 900px; margin: 2rem auto; padding: 0 1.5rem; }
        .flash { padding: .6rem 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: .9rem; }
        .flash.error   { background: #fee2e2; color: #b91c1c; }
        .flash.success { background: #dcfce7; color: #15803d; }
        /* ── Global icon buttons ── */
        .btn-icon{width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;cursor:pointer;border:1px solid var(--border);background:transparent;color:var(--text-muted);text-decoration:none;flex-shrink:0}
        .btn-edit{background:var(--bg-subtle);color:var(--text-muted);border-color:var(--border)}.btn-edit:hover{background:var(--border)}
        .btn-delete{background:#fee2e2;color:#f87171;border-color:#fecaca}.btn-delete:hover{background:#fecaca}
        .btn-download{background:#dbeafe;color:#60a5fa;border-color:#bfdbfe}.btn-download:hover{background:#bfdbfe}
        .btn-done{background:#dcfce7;color:#22c55e;border-color:#bbf7d0}.btn-done:hover{background:#bbf7d0}
        .btn-back{width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;border:1px solid var(--border);background:transparent;color:var(--text-muted);cursor:pointer;text-decoration:none;flex-shrink:0}.btn-back:hover{background:var(--bg-subtle);color:var(--text)}
        a[href],button,[onclick]:not(.card-actions),.card{transition:transform .15s ease;}
        a[href]:hover,button:hover,[onclick]:not(.card-actions):hover,.card:hover{transform:scale(1.03);}
        header{transition:transform .15s ease;transform-origin:top center;}
        header:hover{transform:scale(1.015);}
        footer{display:flex;align-items:center;gap:1rem;padding:2rem 2rem 1.5rem;font-size:.8rem;color:var(--text-subtle);}
        footer::before,footer::after{content:'';flex:1;height:1px;background:var(--border);}
        /* ── Dark mode — global input/select overrides ── */
        html.dark input, html.dark select, html.dark textarea {
            background: var(--input-bg); color: var(--text); border-color: var(--border-soft);
        }
        html.dark input::placeholder, html.dark textarea::placeholder { color: var(--text-subtle); }
        /* ── Theme toggle ── */
        #theme-toggle, #theme-toggle-m { width: 38px; height: 38px; padding: 0; justify-content: center; background: var(--surface); border: 2px outset rgba(0,0,0,.2); border-radius: 99px; }
        html.dark #theme-toggle, html.dark #theme-toggle-m { border: 2px outset rgba(255,255,255,.15); }
        /* ── Mobile nav ── */
        .nav-mobile { display: none; align-items: center; gap: .4rem; }
        .nav-hamburger { background: none; border: none; border-radius: 99px; width: 38px; height: 38px; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; color: var(--text-muted); padding: 0; flex-shrink: 0; transition: color .15s, background .15s; }
        .nav-hamburger:hover { background: var(--nav-hover-bg); color: #6366f1; }
        .nav-hamburger .bar { display: block; width: 18px; height: 2px; background: currentColor; border-radius: 99px; transition: transform .22s ease, opacity .18s ease, background .15s; }
        .nav-hamburger.open .bar:nth-child(1) { transform: translateY(6px) rotate(45deg); }
        .nav-hamburger.open .bar:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .nav-hamburger.open .bar:nth-child(3) { transform: translateY(-6px) rotate(-45deg); }
        @keyframes menuSlideDown { from { opacity: 0; transform: scaleY(0); } to { opacity: 1; transform: scaleY(1); } }
        .mobile-menu { display: none; flex-direction: column; gap: .15rem; background: var(--surface); border-radius: 0 0 16px 16px; box-shadow: 0 8px 24px rgba(0,0,0,.12); margin: 0 .75rem; padding: .5rem .75rem .75rem; position: relative; z-index: 50; transform-origin: top; }
        .mobile-menu.open { display: flex; animation: menuSlideDown .22s ease forwards; }
        .mobile-menu .nav-link { width: 100%; justify-content: flex-start; border-radius: 8px; height: 40px; padding: 0 .75rem; }
        .mobile-menu-user { display: flex; align-items: center; justify-content: space-between; padding: .6rem .75rem 0; margin-top: .25rem; border-top: 1px solid var(--border); font-size: .875rem; color: var(--text-muted); }
        .mobile-menu-user a { color: var(--text-subtle); font-size: .8rem; text-decoration: none; }
        .mobile-menu-user a:hover { color: var(--text); }
        /* ── Responsive ── */
        @media (max-width: 767px) {
            header { display: flex; align-items: center; position: relative; margin: 0 .75rem; gap: 0; padding: 0 .75rem; transition: border-radius .22s ease; }
            header .nav-left, header .nav-right { display: none; }
            header .nav-mobile { display: flex; margin-left: auto; margin-right: .5rem; }
            header .nav-center { position: absolute; left: 50%; transform: translateX(-50%); justify-content: center; }
            header.menu-open { border-radius: 99px 99px 0 0; }
            .mobile-menu { margin-top: 0; }
            .mobile-menu.open { box-shadow: 0 6px 20px rgba(0,0,0,.1), 0 2px 4px rgba(0,0,0,.06); }
            .wrapper { padding: 0 1rem; margin-top: 1.25rem; }
            .btn-icon, .btn-back { width: 36px; height: 36px; }
            footer { padding: 1.5rem 1rem 1rem; font-size: .75rem; }
            .page-hd { flex-wrap: wrap; gap: .5rem; }
        }
        @media (hover: none) {
            a[href]:hover, button:hover, [onclick]:not(.card-actions):hover, .card:hover { transform: none; }
            header:hover { transform: none; }
        }
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
                <button id="theme-toggle" class="nav-link" type="button" aria-label="Toggle dark mode"></button>
                <a href="/profile" class="nav-avatar-link" title="Profile">
                    <img src="/profile/photo" class="nav-avatar-img" alt=""
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <span class="nav-avatar-initials" style="display:none"><?= htmlspecialchars(mb_strtoupper(mb_substr($userName ?? '?', 0, 1))) ?></span>
                </a>
                <a href="/logout" style="margin-left:.25rem;font-size:.8rem;color:var(--text-subtle);text-decoration:none;">Log out</a>
            </span>
        </div>
        <div class="nav-mobile">
            <button class="nav-hamburger" id="nav-hamburger" type="button" aria-label="Open menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
        </div>
    </header>
    <nav class="mobile-menu" id="mobile-menu">
        <a href="/courses"  class="nav-link<?= $coursesActive ? ' active' : '' ?>">Courses</a>
        <a href="/grades"   class="nav-link<?= str_starts_with($uri, '/grades')   ? ' active' : '' ?>">Grades</a>
        <a href="/planning" class="nav-link<?= str_starts_with($uri, '/planning') ? ' active' : '' ?>">Planning</a>
        <a href="/revision" class="nav-link<?= str_starts_with($uri, '/revision') ? ' active' : '' ?>">Revision</a>
        <div class="mobile-menu-user">
            <a href="/profile" class="nav-avatar-link" title="Profile" style="flex-shrink:0;">
                <img src="/profile/photo" class="nav-avatar-img" alt=""
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <span class="nav-avatar-initials" style="display:none"><?= htmlspecialchars(mb_strtoupper(mb_substr($userName ?? '?', 0, 1))) ?></span>
            </a>
            <div style="display:flex;align-items:center;gap:.75rem;">
                <button id="theme-toggle-m" type="button" class="nav-link" aria-label="Toggle dark mode"></button>
                <a href="/logout">Log out</a>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <?php if (!empty($flash)): ?>
            <div class="flash <?= htmlspecialchars($flash['type']) ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>
        <?= $content ?>
    </div>
    <footer>© 2026 EduSync · v1.4.2</footer>
    <!-- Confirm modal -->
    <div id="es-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:9999;align-items:center;justify-content:center;">
        <div class="modal-box" style="border-radius:12px;padding:1.5rem 1.75rem;max-width:380px;width:90%;box-shadow:0 8px 32px rgba(0,0,0,.18);">
            <p id="es-modal-msg" style="margin-bottom:1.5rem;font-size:.95rem;line-height:1.5;"></p>
            <div style="display:flex;gap:.75rem;justify-content:flex-end;">
                <button id="es-modal-cancel" class="modal-cancel-btn" style="padding:.5rem 1.1rem;border-radius:6px;cursor:pointer;font-size:.875rem;font-weight:500;">Cancel</button>
                <button id="es-modal-confirm" style="padding:.5rem 1.1rem;border:none;border-radius:6px;background:#ef4444;color:#fff;cursor:pointer;font-size:.875rem;font-weight:600;">Delete</button>
            </div>
        </div>
    </div>
    <style>
        .modal-box { background: var(--surface); color: var(--text); }
        .modal-cancel-btn { border: 1px solid var(--border-soft); background: var(--bg-subtle); color: var(--text); }
    </style>
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
    // ── Dark mode toggle ──
    (function () {
        var MOON = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';
        var SUN  = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>';
        var btns = ['theme-toggle', 'theme-toggle-m'].map(function (id) { return document.getElementById(id); }).filter(Boolean);
        function updateIcon() {
            var icon = document.documentElement.classList.contains('dark') ? MOON : SUN;
            btns.forEach(function (b) { b.innerHTML = icon; });
        }
        updateIcon();
        btns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                updateIcon();
            });
        });
    })();
    // ── Hamburger menu ──
    (function () {
        var hamburger = document.getElementById('nav-hamburger');
        var menu = document.getElementById('mobile-menu');
        if (!hamburger || !menu) return;
        var navHeader = document.querySelector('header');
        hamburger.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = menu.classList.toggle('open');
            hamburger.classList.toggle('open', isOpen);
            if (navHeader) navHeader.classList.toggle('menu-open', isOpen);
        });
        document.addEventListener('click', function (e) {
            if (!menu.contains(e.target) && !hamburger.contains(e.target)) {
                menu.classList.remove('open');
                hamburger.classList.remove('open');
                if (navHeader) navHeader.classList.remove('menu-open');
            }
        });
    })();
    </script>
</body>
</html>
