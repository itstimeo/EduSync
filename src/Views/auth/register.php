<?php $title = 'Register'; ?>
<style>
.field-err{display:none;font-size:.78rem;color:#ef4444;margin-top:.25rem}
.field-err.show{display:block}
.field-invalid{border-color:#ef4444!important;outline:none!important;box-shadow:0 0 0 3px rgba(239,68,68,.15)!important}
</style>
<h1>Create your account</h1>
<form method="POST" action="/register" novalidate>
    <label for="first_name">First name <span style="color:#ef4444">*</span></label>
    <input type="text" id="first_name" name="first_name" autofocus
           value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>">
    <span class="field-err" id="err-first_name">Please enter your first name.</span>

    <label for="last_name">Last name <span style="color:#ef4444">*</span></label>
    <input type="text" id="last_name" name="last_name"
           value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>">
    <span class="field-err" id="err-last_name">Please enter your last name.</span>

    <label for="email">Email address <span style="color:#ef4444">*</span></label>
    <input type="email" id="email" name="email"
           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    <span class="field-err" id="err-email">Please enter a valid email address.</span>

    <label for="password">Password <span style="color:#ef4444">*</span> <small>(min. 8 characters)</small></label>
    <input type="password" id="password" name="password">
    <span class="field-err" id="err-password">Password must be at least 8 characters.</span>

    <label for="confirm">Confirm password <span style="color:#ef4444">*</span></label>
    <input type="password" id="confirm" name="confirm">
    <span class="field-err" id="err-confirm">Passwords do not match.</span>

    <button type="submit">Create account</button>
</form>
<p class="link">Already have an account? <a href="/login">Sign in</a></p>

<script>
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
