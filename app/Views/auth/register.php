<h1>Register</h1>

<?php if (!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error'] ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form action="<?= $baseUrl ?>/auth/registerSubmit" method="post">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">


    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Confirm Password:</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit">Register</button>
</form>

<p>Already have an account? <a href="/auth/login">Login</a></p>
