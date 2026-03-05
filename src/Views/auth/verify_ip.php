<?php $title = 'Verify new device'; ?>
<style>
.field-err{display:none;font-size:.78rem;color:#ef4444;margin-top:.25rem}
.field-err.show{display:block}
.field-invalid{border-color:#ef4444!important;outline:none!important;box-shadow:0 0 0 3px rgba(239,68,68,.15)!important}
</style>
<h1>New device detected</h1>
<p style="margin-bottom:1rem;font-size:.9rem;color:#555;">
    We sent a 6-digit code to your email address. Enter it below to continue.
</p>
<form method="POST" action="/verify-ip" novalidate>
    <label for="code">Verification code</label>
    <input type="text" id="code" name="code" autofocus
           maxlength="6" inputmode="numeric"
           placeholder="000000"
           style="text-align:center;font-size:1.5rem;letter-spacing:.3em">
    <span class="field-err" id="err-code">Please enter the 6-digit code.</span>

    <button type="submit">Verify</button>
</form>
<p class="link"><a href="/login">Back to login</a></p>

<script>
(function () {
    var codeEl = document.getElementById('code');
    codeEl.addEventListener('input', function () {
        codeEl.classList.remove('field-invalid');
        document.getElementById('err-code').classList.remove('show');
    });
    document.querySelector('form').addEventListener('submit', function (e) {
        if (!/^\d{6}$/.test(codeEl.value.trim())) {
            codeEl.classList.add('field-invalid');
            document.getElementById('err-code').classList.add('show');
            e.preventDefault();
        }
    });
})();
</script>
