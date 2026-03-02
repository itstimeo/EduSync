<?php $title = 'Login'; ?>
<h1>Sign in to EduSync</h1>
<form method="POST" action="/login">
    <label for="email">Email address</label>
    <input type="email" id="email" name="email" required autofocus
           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Sign in</button>
</form>
<p class="link">No account? <a href="/register">Create one</a></p>
