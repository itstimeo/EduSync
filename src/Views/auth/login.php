<?php $title = 'Login'; ?>
<style>
.field-err{display:none;font-size:.78rem;color:#ef4444;margin-top:.25rem}
.field-err.show{display:block}
.field-invalid{border-color:#ef4444!important;outline:none!important;box-shadow:0 0 0 3px rgba(239,68,68,.15)!important}
</style>
<h1>Sign in to EduSync</h1>
<form method="POST" action="/login" novalidate>
    <label for="email">Email address <span style="color:#ef4444">*</span></label>
    <input type="email" id="email" name="email" autofocus
           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    <span class="field-err" id="err-email">Please enter your email address.</span>

    <label for="password">Password <span style="color:#ef4444">*</span></label>
    <input type="password" id="password" name="password">
    <span class="field-err" id="err-password">Please enter your password.</span>

    <label style="flex-direction:row;gap:.5rem;align-items:center;font-weight:400;margin-top:1rem;">
        <input type="checkbox" name="remember_me" value="1" style="width:auto;">
        Remember me
    </label>

    <button type="submit">Sign in</button>
</form>
<p class="link">No account? <a href="/register">Create one</a></p>

<script>
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
