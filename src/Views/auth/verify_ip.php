<?php $title = 'Verify new device'; ?>
<h1>New device detected</h1>
<p style="margin-bottom:1rem;font-size:.9rem;color:#555;">
    We sent a 6-digit code to your email address. Enter it below to continue.
</p>
<form method="POST" action="/verify-ip">
    <label for="code">Verification code</label>
    <input type="text" id="code" name="code" required autofocus
           maxlength="6" pattern="\d{6}" inputmode="numeric"
           placeholder="000000"
           style="text-align:center;font-size:1.5rem;letter-spacing:.3em">

    <button type="submit">Verify</button>
</form>
<p class="link"><a href="/login">Back to login</a></p>
