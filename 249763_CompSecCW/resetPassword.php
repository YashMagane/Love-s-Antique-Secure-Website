<?php
session_start(); //Cand_No: 249763
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f4eee8;
            padding: 20px;
            text-align: center;
        }
        .reset-password-form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        .reset-password-form h1 {
            color: #8b5a2b;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <div class="reset-password-form">
        <h1>Reset Your Password</h1>
        <form action="resetPasswordScript.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="reset_token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
            <input type="password" name="confirm_new_password" class="form-control" placeholder="Confirm New Password" required>
            <button type="submit" class="btn">Reset Password</button>
        </form>
    </div>
</body>
</html>
