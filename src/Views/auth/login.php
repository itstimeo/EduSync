<?php $title = 'Login'; ?>
<style>
.field-err{display:none;font-size:.78rem;color:#ef4444;margin-top:.25rem}
.field-err.show{display:block}
.field-invalid{border-color:#ef4444!important;outline:none!important;box-shadow:0 0 0 3px rgba(239,68,68,.15)!important}
.pw-wrap{position:relative;display:flex;align-items:center}
.pw-wrap input{padding-right:2.5rem}
.pw-toggle{position:absolute;right:.5rem;background:none;border:none;cursor:pointer;color:var(--text-subtle);padding:.2rem;display:flex;align-items:center;line-height:1}
.pw-toggle:hover{color:var(--text)}
</style>
<h1>Sign in to EduSync</h1>
<form method="POST" action="/login" novalidate>
    <label for="email">Email address <span style="color:#ef4444">*</span></label>
    <input type="email" id="email" name="email" autofocus
           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    <span class="field-err" id="err-email">Please enter your email address.</span>

    <label for="password">Password <span style="color:#ef4444">*</span></label>
    <div class="pw-wrap">
        <input type="password" id="password" name="password">
        <button type="button" class="pw-toggle" aria-label="Show password" onclick="togglePw('password',this)"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
    </div>
    <span class="field-err" id="err-password">Please enter your password.</span>

    <label style="flex-direction:row;gap:.5rem;align-items:center;font-weight:400;margin-top:1rem;">
        <input type="checkbox" name="remember_me" value="1" style="width:auto;">
        Remember me
    </label>

    <button type="submit">Sign in</button>
</form>
<p class="link">No account? <a href="/register">Create one</a></p>

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

    document.getElementById('email').addEventListener('input', function () { clear('email', 'err-email'); });
    document.getElementById('password').addEventListener('input', function () { clear('password', 'err-password'); });

    document.querySelector('form').addEventListener('submit', function (e) {
        var ok = true;
        var email = document.getElementById('email');
        var password = document.getElementById('password');
        if (!email.value.trim()) { show('email', 'err-email'); ok = false; } else { clear('email', 'err-email'); }
        if (!password.value) { show('password', 'err-password'); ok = false; } else { clear('password', 'err-password'); }
        if (!ok) e.preventDefault();
    });
})();
</script>
