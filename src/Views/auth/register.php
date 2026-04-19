<?php $title = __('auth.register.title'); ?>
<style>
.field-err{display:none;font-size:.78rem;color:#ef4444;margin-top:.25rem}
.field-err.show{display:block}
.field-invalid{border-color:#ef4444!important;outline:none!important;box-shadow:0 0 0 3px rgba(239,68,68,.15)!important}
.pw-wrap{position:relative;display:flex;align-items:center}
.pw-wrap input{padding-right:2.5rem}
.pw-toggle{position:absolute;right:.5rem;background:none;border:none;cursor:pointer;color:var(--text-subtle);padding:.2rem;display:flex;align-items:center;line-height:1}
.pw-toggle:hover{color:var(--text)}
</style>
<h1><?= __('auth.register.title') ?></h1>
<form method="POST" action="/register" novalidate>
    <label for="first_name"><?= __('auth.register.first_name') ?> <span style="color:#ef4444">*</span></label>
    <input type="text" id="first_name" name="first_name" autofocus
           value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>">
    <span class="field-err" id="err-first_name"><?= __('auth.register.first_name') ?></span>

    <label for="last_name"><?= __('auth.register.last_name') ?> <span style="color:#ef4444">*</span></label>
    <input type="text" id="last_name" name="last_name"
           value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>">
    <span class="field-err" id="err-last_name"><?= __('auth.register.last_name') ?></span>

    <label for="email"><?= __('auth.register.email') ?> <span style="color:#ef4444">*</span></label>
    <input type="email" id="email" name="email"
           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    <span class="field-err" id="err-email"><?= __('auth.register.email') ?></span>

    <label for="password"><?= __('auth.register.password') ?> <span style="color:#ef4444">*</span> <small><?= __('profile.pw_hint') ?></small></label>
    <div class="pw-wrap">
        <input type="password" id="password" name="password">
        <button type="button" class="pw-toggle" aria-label="Show password" onclick="togglePw('password',this)"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
    </div>
    <span class="field-err" id="err-password"><?= __('revision_settings.step_invalid') ?></span>

    <label for="confirm"><?= __('auth.register.confirm') ?> <span style="color:#ef4444">*</span></label>
    <div class="pw-wrap">
        <input type="password" id="confirm" name="confirm">
        <button type="button" class="pw-toggle" aria-label="Show confirm password" onclick="togglePw('confirm',this)"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
    </div>
    <span class="field-err" id="err-confirm"><?= __('auth.errors.passwords_no_match') ?></span>

    <button type="submit"><?= __('auth.register.submit') ?></button>
</form>
<p class="link"><?= __('auth.register.has_account') ?> <a href="/login"><?= __('auth.register.login') ?></a></p>

<script>
var EYE = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
var EYE_OFF = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
function togglePw(id, btn) {
    var inp = document.getElementById(id);
    var show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    btn.innerHTML = show ? EYE_OFF : EYE;
    btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
}
(function () {
    function show(id, errId) { document.getElementById(id).classList.add('field-invalid'); document.getElementById(errId).classList.add('show'); }
    function clear(id, errId) { document.getElementById(id).classList.remove('field-invalid'); document.getElementById(errId).classList.remove('show'); }

    ['first_name','last_name','email','password','confirm'].forEach(function (id) {
        document.getElementById(id).addEventListener('input', function () {
            clear(id, 'err-' + id);
        });
    });

    document.querySelector('form').addEventListener('submit', function (e) {
        var ok = true;
        var fn  = document.getElementById('first_name');
        var ln  = document.getElementById('last_name');
        var em  = document.getElementById('email');
        var pw  = document.getElementById('password');
        var cf  = document.getElementById('confirm');

        if (!fn.value.trim())  { show('first_name', 'err-first_name'); ok = false; } else { clear('first_name', 'err-first_name'); }
        if (!ln.value.trim())  { show('last_name',  'err-last_name');  ok = false; } else { clear('last_name',  'err-last_name'); }
        if (!em.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em.value)) { show('email', 'err-email'); ok = false; } else { clear('email', 'err-email'); }
        if (pw.value.length < 8) { show('password', 'err-password'); ok = false; } else { clear('password', 'err-password'); }
        if (cf.value !== pw.value) { show('confirm', 'err-confirm'); ok = false; } else { clear('confirm', 'err-confirm'); }

        if (!ok) e.preventDefault();
    });
})();
</script>
