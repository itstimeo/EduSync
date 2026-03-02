<?php $title = 'Register'; ?>
<h1>Create your account</h1>
<form method="POST" action="/register">
    <label for="first_name">First name</label>
    <input type="text" id="first_name" name="first_name" required autofocus
           value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>">

    <label for="last_name">Last name</label>
    <input type="text" id="last_name" name="last_name" required
           value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>">

    <label for="email">Email address</label>
    <input type="email" id="email" name="email" required
           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

    <label for="password">Password <small>(min. 8 characters)</small></label>
    <input type="password" id="password" name="password" required minlength="8">

    <label for="confirm">Confirm password</label>
    <input type="password" id="confirm" name="confirm" required minlength="8">

    <button type="submit">Create account</button>
</form>
<p class="link">Already have an account? <a href="/login">Sign in</a></p>
