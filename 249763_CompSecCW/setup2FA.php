<?php
session_start(); //Cand_No: 249763
require 'vendor/autoload.php';
use PragmaRX\Google2FA\Google2FA;

// Redirect to login page if the user is not logged in or user_id is not set in session
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

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
    
    // Bind the user ID parameter and execute the statement
    $userId = $_SESSION['user_id'];
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch the user's secret key
    $result = $stmt->fetch();
    if ($result) {
        $secretKey = $result['secret_key']; // The secret key from the database
    } else {
        echo "Error: Secret key not found for the user.";
        exit;
    }
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Setup Two-Factor Authentication</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            background-color: #fdf6e3;
            color: #8B4513;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin: 0;
            font-size: 24px;
            color: #996515;
        }
        .setup-form {
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(139, 69, 19, 0.2);
            max-width: 400px;
            margin: 20px auto;
            border: 1px solid #cd853f;
        }
        .setup-form h2 {
            margin-bottom: 20px;
            color: #996515;
            font-family: 'Papyrus', fantasy;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.8);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #cd853f;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #8B4513;
            color: #fdf6e3;
            cursor: pointer;
            font-size: 16px;
            font-family: 'Courier New', Courier, monospace;
        }
        .btn:hover {
            background-color: #996515;
        }
        .info-text {
            margin: 10px 0;
            color: #8B4513;
            font-family: 'Georgia', serif;
        }
        a {
            color: #0056b3;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Lovejoy's Antique Store - 249763</h1>
    <div class="setup-form">
        <h2>Setup Two-Factor Authentication (Do not leave this page before successfully setting up or you will not be able to log on)</h2>
        <p class="info-text">Step 1: Go to your app store and download the Google Authenticator App.</p>
        <p class="info-text">Step 2: Open your Google Authenticator App and tap the plus button on the bottom right side.</p>
        <p class="info-text">Step 3: Enter this setup key with your Google Authenticator app.</p>
        <div class="form-control">
            <strong>Your setup key:</strong> <?php echo htmlspecialchars($secretKey); ?>
        </div>
        <p class="info-text">Once you have set up your app, click the link below to verify your setup:</p>
        <a href="verify2FA.php" class="btn">Click here to verify setup</a>
    </div>
</body>
</html>
