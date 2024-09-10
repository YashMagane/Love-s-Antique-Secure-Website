<?php
session_start(); //Cand_No: 249763
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF token check
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }

    // Check reset token
    if (!isset($_POST['reset_token']) || $_POST['reset_token'] !== $_SESSION['reset_token']) {
        die('Invalid reset token');
    }

    // Check if passwords match
    if ($_POST['new_password'] !== $_POST['confirm_new_password']) {
        die('Passwords do not match');
    }

    // Database connection setup
    $host = 'localhost';
    $db = 'id21551194_lovejoysdatabase';
    $user = 'id21551194_lovejoysdb';
    $pass = 'V4o"B|3,H5f1';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

        // Update user password
        $newPasswordHash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$newPasswordHash, $_SESSION['reset_user_id']]);

        // Cleanup session
        unset($_SESSION['reset_token']);
        unset($_SESSION['reset_user_id']);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Reset Successful</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f4eee8;
            padding: 20px;
            text-align: center;
        }
        .message-box {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 40px auto;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            background-color: #8b5a2b;
            color: white;
            text-decoration: none;
            font-size: 16px;
        }
        a:hover {
            background-color: #5a3921;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <h1>Password Reset Successful</h1>
        <p>Your password has been reset successfully. You can now log in with your new password.</p>
        <a href="index.php">Go to Login Page</a>
    </div>
</body>
</html>
