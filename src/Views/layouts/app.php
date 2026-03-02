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
        <a href="/dashboard" class="active">Dashboard</a>
    </nav>
    <div class="wrapper">
        <?php if (!empty($flash)): ?>
            <div class="flash <?= htmlspecialchars($flash['type']) ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>
        <?= $content ?>
    </div>
</body>
</html>
