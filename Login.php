<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BananaGo</title>

    <link rel="stylesheet" href="/umkm_psw/assets/css/style.css">
</head>

<body class="login-page">

<div class="login-background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>

<form class="login-form" method="post" action="cek_login.php">

    <h3>Login</h3>

    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" class="btn-login">Login</button>

    <a href="index.html" class="btn-home">← Kembali ke Home</a>

</form>

</body>
</html>