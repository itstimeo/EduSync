<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'EduSync') ?> — EduSync</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, sans-serif; background: #f5f5f5; color: #1a1a1a; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #fff; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.1); padding: 2rem; width: 100%; max-width: 420px; }
        h1 { font-size: 1.4rem; margin-bottom: 1.5rem; text-align: center; }
        label { display: block; font-size: .85rem; font-weight: 600; margin-bottom: .25rem; margin-top: 1rem; }
        input { width: 100%; padding: .5rem .75rem; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem; }
        input:focus { outline: 2px solid #6366f1; border-color: transparent; }
        button[type=submit] { margin-top: 1.5rem; width: 100%; padding: .6rem; background: #6366f1; color: #fff; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; }
        button[type=submit]:hover { background: #4f46e5; }
        .flash { padding: .6rem 1rem; border-radius: 4px; margin-bottom: 1rem; font-size: .9rem; }
        .flash.error   { background: #fee2e2; color: #b91c1c; }
        .flash.success { background: #dcfce7; color: #15803d; }
        .link { text-align: center; margin-top: 1rem; font-size: .85rem; }
        .link a { color: #6366f1; text-decoration: none; }
        .link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
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
