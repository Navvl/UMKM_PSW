<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BananaGo</title>

    <link rel="stylesheet" href="assets/css/auth.css">
</head>

<body>

<form class="auth-form" method="POST" action="config/proses_login.php">

    <h2>Login</h2>

    <input type="text" name="username" placeholder="Username" required>

    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" class="btn-auth">
        Login
    </button>

    <p class="auth-text">
        Belum punya akun?
        <a href="register.php">Register</a>
    </p>

    <a href="index.php" class="btn-home">
        ← Back Home
    </a>

</form>

</body>
</html>