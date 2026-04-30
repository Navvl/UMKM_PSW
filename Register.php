<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BananaGo</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="login-page">

<!-- Background -->
<div class="login-background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>

<!-- FORM REGISTER -->
<form class="login-form register-form" method="post" action="proses_register.php">

    <h3>Register BananaGo</h3>

    <p style="color:#4c2013; font-size:14px; margin-bottom:20px;">
        Daftar untuk mulai order pisang favoritmu!
    </p>

    <input 
        type="text" 
        name="nama" 
        placeholder="Nama Lengkap" 
        required
    >

    <input 
        type="password" 
        name="password" 
        placeholder="Password" 
        required
    >

    <input 
        type="text" 
        name="phone" 
        placeholder="Nomor HP" 
        required
    >

    <input 
        type="text" 
        name="address" 
        placeholder="Alamat" 
        required
    >

    <button type="submit" class="btn-login">Register</button>

    <a href="login.php" class="btn-home">← Sudah punya akun? Login</a>

</form>

</body>
</html>