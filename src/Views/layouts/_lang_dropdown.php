<?php
$_ldCurrent = \EduSync\Core\Lang::current();
$_ldFlags   = [
    'en' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 30" width="20" height="14" style="border-radius:2px;display:block"><rect width="60" height="30" fill="#012169"/><path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6"/><path d="M0,0 L60,30 M60,0 L0,30" stroke="#C8102E" stroke-width="4"/><path d="M30,0 V30 M0,15 H60" stroke="#fff" stroke-width="10"/><path d="M30,0 V30 M0,15 H60" stroke="#C8102E" stroke-width="6"/></svg>',
    'fr' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3 2" width="20" height="14" style="border-radius:2px;display:block"><rect width="1" height="2" fill="#002395"/><rect x="1" width="1" height="2" fill="#EDEDED"/><rect x="2" width="1" height="2" fill="#ED2939"/></svg>',
];
$_ldItems   = [
    'en' => ['name' => 'English'],
    'fr' => ['name' => 'Français'],
];
$_ldCurFlag = $_ldFlags[$_ldCurrent] ?? $_ldFlags['en'];
?>
<div class="lang-dropdown">
    <button type="button" class="lang-dd-btn">
        <span class="lang-flag"><?= $_ldCurFlag ?></span>
        <span class="lang-dd-code"><?= strtoupper($_ldCurrent) ?></span>
        <svg class="lang-dd-chevron" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/></svg>
    </button>
    <div class="lang-dd-menu">
        <?php
            $_ldRedirect = urlencode($_SERVER['REQUEST_URI'] ?? '/dashboard');
        ?>
        <?php foreach ($_ldItems as $_ldCode => $_ldItem): ?>
            <a href="/lang?code=<?= $_ldCode ?>&redirect_to=<?= $_ldRedirect ?>" class="lang-dd-option<?= $_ldCurrent === $_ldCode ? ' active' : '' ?>">
                <span class="lang-flag"><?= $_ldFlags[$_ldCode] ?></span>
                <span><?= $_ldItem['name'] ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php if (!defined('_LANG_DD_JS')): define('_LANG_DD_JS', true); ?>
<script>
(function(){
    document.querySelectorAll('.lang-dd-btn').forEach(function(btn){
        btn.addEventListener('click', function(e){
            e.stopPropagation();
            var dd = btn.closest('.lang-dropdown');
            var wasOpen = dd.classList.contains('open');
            document.querySelectorAll('.lang-dropdown.open').forEach(function(d){ d.classList.remove('open'); });
            if(!wasOpen) dd.classList.add('open');
        });
    });
    document.addEventListener('click', function(e){
        document.querySelectorAll('.lang-dropdown.open').forEach(function(d){
            if(!d.contains(e.target)) d.classList.remove('open');
        });
    });
})();
</script>
<?php endif; ?>
