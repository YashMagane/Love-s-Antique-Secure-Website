<?php
session_start();//Cand_No: 249763
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f4eee8;
            padding: 20px;
            text-align: center;
        }
        .forgot-password-form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #8b5a2b;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #5a3921;
        }
        .g-recaptcha {
            margin-top: 15px;
        }
        .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #8b5a2b;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link:hover {
            text-decoration: underline;
            color: #5a3921;
        }
    </style>
</head>
<body>
    <div class="forgot-password-form">
        <h1>Forgot Password</h1>
        <form action="forgotPasswordScript.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>

            <select name="security_question" class="form-control">
                <option value="Your first pet's name?">Your first pet's name?</option>
                    <option value="Where was your first job?">Where was your first job?</option>
                    <option value="Your favourite game?">Your favourite game?</option>
            </select>

            <input type="text" name="security_answer" class="form-control" placeholder="Answer for security question" required>

            <input type="text" name="2fa_code" class="form-control" placeholder="2FA Code" required>

            <div class="g-recaptcha" data-sitekey="6LcLPi4pAAAAAHpkbr5ERkj_f8ISKjOuJvOC61Kq"></div>

            <input type="submit" value="Reset Password" class="btn">
        </form>
        <a href="index.php" class="login-link">Back to Login</a>
    </div>
</body>
</html>
