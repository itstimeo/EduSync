<?php $title = 'Login'; ?>
<h1>Sign in to EduSync</h1>
<form method="POST" action="/login">
    <label for="email">Email address</label>
    <input type="email" id="email" name="email" required autofocus
           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <label style="flex-direction:row;gap:.5rem;align-items:center;font-weight:400;margin-top:1rem;">
        <input type="checkbox" name="remember_me" value="1" style="width:auto;">
        Remember me
    </label>

    <button type="submit">Sign in</button>
</form>
<p class="link">No account? <a href="/register">Create one</a></p>
