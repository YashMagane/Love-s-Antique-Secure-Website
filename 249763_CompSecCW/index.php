<?php
session_start();//Cand_No: 249763

//CSRF tokens
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page - Love's Antique Store</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
    body {
        font-family: 'Times New Roman', serif;
        background-color: #fdf6e3;
        color: #8B4513;
        padding: 20px;
        text-align: center;
    }
    .title-bar {
        text-align: center;
        margin-bottom: 20px;
    }

    .title-bar h1 {
        font-family: 'Papyrus', fantasy;
        color: #8B4513;
        margin-bottom: 5px;
    }

    hr {
        border: 0;
        height: 1px;
        background-color: #cd853f;
        max-width: 400px;
        margin: 0 auto;
    }
    .login-form {
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(139, 69, 19, 0.2);
        max-width: 400px;
        margin: 40px auto;
        border: 1px solid #cd853f;
    }
    .store-heading {
        font-family: 'Papyrus', fantasy;
        color: #6e503b;
        margin-bottom: 10px;
    }
    .login-form h2 {
        margin-bottom: 20px;
        color: #6e503b;
    }
    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #cd853f;
        border-radius: 4px;
        box-sizing: border-box;
        background-color: transparent;
        color: #8B4513;
    }
    .btn {
        width: 100%;
        padding: 10px;
        border: 1px solid #cd853f;
        border-radius: 4px;
        background-color: #8B4513;
        color: #fdf6e3;
        cursor: pointer;
        font-size: 16px;
        text-transform: uppercase;
        font-family: 'Courier New', Courier, monospace;
    }
    .btn:hover {
        background-color: #996515;/
    }
    .register-link, .password-link {
        display: block;
        margin-top: 20px;
        color: #6e503b;
        text-decoration: none;
        font-weight: bold;
    }
    .register-link:hover, .password-link:hover {
        text-decoration: underline;
    }
    .g-recaptcha {
        margin-top: 15px;
    }
</style>
    </style>
</head>
<body>
<?php
if (isset($_SESSION['error_message'])) {
    echo '<div style="color: red;">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}
?>
<div class="title-bar">
        <h1>Lovejoy's Antique Shop - 249763</h1>
        <hr>
    </div>
    <div class="login-form">
        <form action='loginScript.php' method='POST'>
            <h2>Login to Your Account</h2>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input name='txtEmail' type='text' class='form-control' placeholder='Email'>
            <input name='txtPassword' type='password' class='form-control' placeholder='Password'>
            <!-- Commented out the 2FA input field -->
            <!-- <input name="2fa_code" type="text" class="form-control" placeholder="Two-Factor Authentication Code"> -->
            <div class="g-recaptcha" data-sitekey="6LcLPi4pAAAAAHpkbr5ERkj_f8ISKjOuJvOC61Kq"></div>
            <input type='submit' value='Login' class='btn'>
            <a href='registerForm.php' class='register-link'>Not Registered Yet?</a>
            <!--<a href='passRecovery.php' class='password-link'>Forgot Password? (OUT OF SERVICE AS IT USES 2FA VIDEO WALKTHROUGH AVAILABLE)</a> -->
            <span class='password-link'>Forgot Password? (OUT OF SERVICE AS IT USES 2FA VIDEO WALKTHROUGH AVAILABLE)</span>
        </form>
    </div>
</body>
</html>

