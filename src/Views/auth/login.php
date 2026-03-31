<?php $title = 'Login'; ?>
<style>
.field-err{display:none;font-size:.78rem;color:#ef4444;margin-top:.25rem}
.field-err.show{display:block}
.field-invalid{border-color:#ef4444!important;outline:none!important;box-shadow:0 0 0 3px rgba(239,68,68,.15)!important}
.pw-wrap{position:relative;display:flex;align-items:center}
.pw-wrap input{padding-right:2.5rem}
.pw-toggle{position:absolute;right:.5rem;background:none;border:none;cursor:pointer;color:var(--text-subtle);padding:.2rem;display:flex;align-items:center;line-height:1}
.pw-toggle:hover{color:var(--text)}
.remember-wrap{display:inline-block;margin-top:1rem;cursor:pointer;user-select:none}
.remember-wrap input{display:none}
.remember-btn-inner{display:inline-flex;align-items:center;gap:.4rem;padding:.3rem 1rem;border-radius:99px;border:1.5px solid #d1d5db;background:transparent;color:#6b7280;font-size:.85rem;font-weight:500;transition:background .25s,border-color .25s,color .25s}
.remember-wrap input:checked+.remember-btn-inner{background:#6366f1;border-color:#6366f1;color:#fff}
.ri-wrap{position:relative;width:16px;height:16px;flex-shrink:0}
.ri-wrap svg{position:absolute;top:0;left:0;overflow:visible;transform-origin:center}
.ri-cross{transform:rotate(0deg) scale(1);opacity:1}
.ri-cross line{stroke-dasharray:17;stroke-dashoffset:0}
.ri-check{transform:scale(0.3) rotate(-40deg);opacity:0}
.ri-check polyline{stroke-dasharray:23;stroke-dashoffset:23}
.remember-wrap input:checked+.remember-btn-inner .ri-cross{transform:rotate(90deg) scale(0);opacity:0}
.remember-wrap input:checked+.remember-btn-inner .ri-cross line{stroke-dashoffset:17}
.remember-wrap input:checked+.remember-btn-inner .ri-check{transform:scale(1) rotate(0deg);opacity:1}
.remember-wrap input:checked+.remember-btn-inner .ri-check polyline{stroke-dashoffset:0}
.remember-wrap.to-checked .ri-cross{transition:transform .22s cubic-bezier(.55,.055,.675,.19),opacity .18s ease}
.remember-wrap.to-checked .ri-cross line{transition:stroke-dashoffset .18s ease}
.remember-wrap.to-checked .ri-check{transition:transform .32s cubic-bezier(.34,1.56,.64,1) .1s,opacity .15s ease .1s}
.remember-wrap.to-checked .ri-check polyline{transition:stroke-dashoffset .35s cubic-bezier(.4,0,.2,1) .18s}
.remember-wrap.to-unchecked .ri-check{transition:transform .22s cubic-bezier(.55,.055,.675,.19),opacity .18s ease}
.remember-wrap.to-unchecked .ri-check polyline{transition:stroke-dashoffset .18s ease}
.remember-wrap.to-unchecked .ri-cross{transition:transform .32s cubic-bezier(.34,1.56,.64,1) .1s,opacity .15s ease .1s}
.remember-wrap.to-unchecked .ri-cross line{transition:stroke-dashoffset .35s cubic-bezier(.4,0,.2,1) .18s}
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

    <label class="remember-wrap">
        <input type="checkbox" name="remember_me" value="1" id="remember_me">
        <span class="remember-btn-inner">
            <span class="ri-wrap">
                <svg class="ri-cross" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                <svg class="ri-check" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12" pathLength="23"/></svg>
            </span>
            Remember me
        </span>
    </label>

    <button type="submit">Sign in</button>
</form>
<p class="link">No account? <a href="/register">Create one</a></p>

<script>
document.getElementById('remember_me').addEventListener('change', function() {
    var wrap = this.closest('label');
    wrap.classList.toggle('to-checked', this.checked);
    wrap.classList.toggle('to-unchecked', !this.checked);
});
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
