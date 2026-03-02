<?php $title = 'Verify your email'; ?>
<h1>Verify your email</h1>
<p style="margin-bottom:1rem;font-size:.9rem;color:#555;">
    We sent a 6-digit code to your email address. Enter it below to activate your account.
</p>
<form method="POST" action="/verify-email">
    <label for="code">Verification code</label>
    <input type="text" id="code" name="code" required autofocus
           maxlength="6" pattern="\d{6}" inputmode="numeric"
           placeholder="000000"
           style="text-align:center;font-size:1.5rem;letter-spacing:.3em">

    <button type="submit">Verify</button>
</form>
<p class="link"><a href="/register">Back to register</a></p>
