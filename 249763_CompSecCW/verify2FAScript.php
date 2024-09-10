<?php
session_start(); //Cand_No: 249763
require 'vendor/autoload.php';
use PragmaRX\Google2FA\Google2FA;

$errorMessage = '';

if (!isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('CSRF token validation failed');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $google2fa = new Google2FA();
    
    $userId = $_SESSION['user_id']; // Ensure this session variable is set
    
    // Database connection credentials
    $host = 'localhost';
    $db = 'id21551194_lovejoysdatabase';
    $user = 'id21551194_lovejoysdb';
    $pass = 'V4o"B|3,H5f1';
    $charset = 'utf8mb4';
    
    // Set up the DSN
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        
        // Prepare the SQL statement
        $sql = "SELECT secret_key FROM users WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result && !empty($result['secret_key'])) {
            $secretKey = $result['secret_key'];
            $verificationCode = $_POST['verification_code'] ?? '';

            if ($google2fa->verifyKey($secretKey, $verificationCode)) {
                header('Location: dashboard.php');
                exit;
            } else {
                $errorMessage = "Invalid verification code. Please try again.";
            }
        } else {
            $errorMessage = "Secret key not found for user. Please contact support.";
        }
    } catch (\PDOException $e) {
        $errorMessage = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Two-Factor Authentication Setup</title>
    <style>
    body {
        font-family: 'Times New Roman', Times, serif;
        background-color: #faf0e6;
        padding: 20px;
        text-align: center;
    }
    .verification-form {
        background: #fdf5e6;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: 40px auto;
        border: 1px solid #deb887;
    }
    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #a0522d;
        border-radius: 4px;
        box-sizing: border-box;
        background-color: #fffaf0;
        color: #654321;
    }
    .btn {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 4px;
        background-color: #8b4513;
        color: white;
        cursor: pointer;
        font-size: 16px;
        text-transform: uppercase;
        font-weight: bold;
    }
    .btn:hover {
        background-color: #6b8e23;
    }
    .error-message {
        color: #800000;
        margin-bottom: 10px;
    }
</style>
</head>
<body>
    <div class="verification-form">
        <h1>Love's Antique Store - 249763</h1>
        <h2>Complete Two-Factor Authentication Setup</h2>

        <?php if ($errorMessage): ?>
            <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>

        <form action="verify2FAScript.php" method="POST">
            <div>
                <label for="verification_code">Enter the code from the app:</label>
                <input type="text" id="verification_code" name="verification_code" class="form-control" required>
            </div>
            <input type="submit" value="Verify Code" class="btn">
        </form>
    </div>
</body>
</html>



