<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BananaGo</title>

    <link rel="stylesheet" href="assets/css/auth.css">
    <style>
        .error-message {
            color: #DC2626; 
            background-color: #FEE2E2; 
            font-size: 0.9rem;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
            display: none; 
            width: 100%;
        }
        .btn-auth:disabled {
            background-color: #A3A3A3;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

<form id="registerForm" class="auth-form" method="POST" action="config/proses_register.php" novalidate>

    <h2>Register</h2>

    <div id="errorBox" class="error-message"></div>

    <input type="text" id="username" name="username" placeholder="Username" required>

    <input type="password" id="password" name="password" placeholder="Password" required>

    <button type="submit" id="btnSubmit" class="btn-auth">
        Register
    </button>

    <p class="auth-text">
        Sudah punya akun?
        <a href="login.php">Login</a>
    </p>

    <a href="index.php" class="btn-home">
        ← Back Home
    </a>

</form>

<script>
    const registerForm = document.getElementById('registerForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const errorBox = document.getElementById('errorBox');

    registerForm.addEventListener('submit', function (event) {
        event.preventDefault(); 
        
        const usernameVal = document.getElementById('username').value.trim();
        const passwordVal = document.getElementById('password').value.trim();

        if (usernameVal === '' || passwordVal === '') {
            errorBox.innerText = 'All fields are required.';
            errorBox.style.display = 'block';
            
            return; 
        }

        errorBox.style.display = 'none';

        btnSubmit.innerHTML = 'Processing...';
        btnSubmit.disabled = true;
        
        registerForm.submit();
    });
</script>

</body>
</html>