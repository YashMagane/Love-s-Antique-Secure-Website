<?php
session_start();//Cand_No: 249763
require 'vendor/autoload.php';

// The Google2FA part is commented out as we are disabling 2FA
// use PragmaRX\Google2FA\Google2FA;

$host = 'localhost';
$db = 'id21551194_lovejoysdatabase';
$user = 'id21551194_lovejoysdb';
$pass = 'V4o"B|3,H5f1';
$charset = 'utf8mb4';

$recaptchaSecretKey = '6LcLPi4pAAAAAIyKyOriY_Jui1dzf_l0me4C6OUa';

// PDO Connection setup
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['csrf_token'], $_POST['txtEmail'], $_POST['txtPassword'], $_POST['g-recaptcha-response'])) {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error_message'] = 'CSRF token validation failed';
        header('Location: index.php');
        exit;
    }

    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($recaptchaSecretKey) . '&response=' . urlencode($recaptchaResponse));
    $recaptcha = json_decode($recaptcha);

    if (!$recaptcha->success) {
        $_SESSION['error_message'] = 'reCAPTCHA verification failed. Please try again.';
        header('Location: index.php');
        exit;
    }

    $email = htmlspecialchars($_POST['txtEmail']);
    $password = htmlspecialchars($_POST['txtPassword']);

    $sql = "SELECT id, password, secret_key, role, failed_attempts, lockout_time FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        $lockoutTime = new DateTime($user['lockout_time'] ?? 'now');
        $currentTime = new DateTime();
        $diff = $currentTime->diff($lockoutTime);

        if ($user['failed_attempts'] >= 5 && $diff->i < 30) {
            $_SESSION['error_message'] = "Your account is locked. Please try again in " . (30 - $diff->i) . " minutes.";
            header('Location: index.php');
            exit;
        }

        if (password_verify($password, $user['password'])) {
            // Removed the 2FA check here

            $stmt = $pdo->prepare("UPDATE users SET failed_attempts = 0, lockout_time = NULL WHERE email = ?");
            $stmt->execute([$email]);

            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($_SESSION['role'] === 'admin') {
                header('Location: admin_dashboard.php');
                exit;
            } else {
                header('Location: dashboard.php');
                exit;
            }
        } else {
            $stmt = $pdo->prepare("UPDATE users SET failed_attempts = failed_attempts + 1, lockout_time = NOW() WHERE email = ?");
            $stmt->execute([$email]);

            $remainingAttempts = 5 - $user['failed_attempts'] - 1;
            $_SESSION['error_message'] = "Incorrect password. You have $remainingAttempts remaining attempts.";
            header('Location: index.php');
            exit;
        }
    } else {
        $_SESSION['error_message'] = "User linked with that email does not exist.";
        header('Location: index.php');
        exit;
    }
}
?>
