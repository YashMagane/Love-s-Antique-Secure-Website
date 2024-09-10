<?php
session_start();//Cand_No: 249763
require 'vendor/autoload.php';
use PragmaRX\Google2FA\Google2FA;

// Google reCAPTCHA secret key
$recaptchaSecretKey = '6LcLPi4pAAAAAIyKyOriY_Jui1dzf_l0me4C6OUa';

// CSRF Token check
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('CSRF token validation failed');
}

// reCAPTCHA verification
$recaptchaResponse = $_POST['g-recaptcha-response'];
$recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($recaptchaSecretKey) . '&response=' . urlencode($recaptchaResponse));
$recaptcha = json_decode($recaptcha);

if (!$recaptcha->success) {
    die('reCAPTCHA verification failed. Please try again.');
}

// Database connection setup
$host = 'localhost';
$db = 'id21551194_lovejoysdatabase';
$user = 'id21551194_lovejoysdb';
$pass = 'V4o"B|3,H5f1';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

    // Retrieve user data
    $stmt = $pdo->prepare("SELECT id, email, secret_key, security_question, security_answer FROM users WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    $user = $stmt->fetch();

    if ($user) {
        // Check security question and answer
        if ($user['security_question'] === $_POST['security_question'] && password_verify($_POST['security_answer'], $user['security_answer'])) {
            // Initialize Google2FA and verify the 2FA code
            $google2fa = new Google2FA();
            if ($google2fa->verifyKey($user['secret_key'], $_POST['2fa_code'])) {
                // Redirect to reset password page with a unique token
                $_SESSION['reset_token'] = bin2hex(random_bytes(32));
                $_SESSION['reset_user_id'] = $user['id'];
                header('Location: resetPassword.php?token=' . $_SESSION['reset_token']);
                exit;
            } else {
                echo "Invalid 2FA code. Please try again.";
            }
        } else {
            echo "Incorrect security question or answer. Please try again.";
        }
    } else {
        echo "User not found with the provided email.";
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
