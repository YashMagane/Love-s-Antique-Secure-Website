<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';
session_start(); //Cand_No: 249763

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errorOccurred = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['txtEmail1'], $_POST['txtPassword1'], $_POST['txtPassword2'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }

    $mysql_host = "localhost"; 
    $mysql_database = "id21551194_lovejoysdatabase"; 
    $mysql_user = "id21551194_lovejoysdb"; 
    $mysql_password = 'V4o"B|3,H5f1'; 

    $dsn = "mysql:host=$mysql_host;dbname=$mysql_database;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($dsn, $mysql_user, $mysql_password, $options);
    } catch (\PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    $forename = htmlspecialchars($_POST['txtForename']); 
    $surname = htmlspecialchars($_POST['txtSurname']);  
    $email1 = htmlspecialchars($_POST['txtEmail1']);
    $password1 = htmlspecialchars($_POST['txtPassword1']); 
    $password2 = htmlspecialchars($_POST['txtPassword2']);
    $phone = htmlspecialchars($_POST['txtPhone']);

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email1]);
    if ($stmt->fetchColumn() > 0) {
        $_SESSION['registration_errors'] = "An account with this email already exists.";
        header('Location: registerForm.php');
        exit;
    }

    $passwordStrengthError = '';
    if (strlen($password1) < 8) {
        $passwordStrengthError .= 'Password must be at least 8 characters long. ';
    }
    if (!preg_match('/[A-Z]/', $password1)) {
        $passwordStrengthError .= 'Password must include at least one uppercase letter. ';
    }
    if (!preg_match('/[a-z]/', $password1)) {
        $passwordStrengthError .= 'Password must include at least one lowercase letter. ';
    }
    if (!preg_match('/\d/', $password1)) {
        $passwordStrengthError .= 'Password must include at least one number. ';
    }
    if (!preg_match('/\W/', $password1)) {
        $passwordStrengthError .= 'Password must include at least one special character. ';
    }
    if ($passwordStrengthError != '') {
        $_SESSION['registration_errors'] = $passwordStrengthError;
        header('Location: registerForm.php');
        exit;
    }

    if ($password1 != $password2) {
        echo "Passwords do not match. <a href='registerForm.php' class='login-link'>Click here to retry</a>";
        $errorOccurred = 1;
    } else {
        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
        $securityQuestion = $_POST['security_question'];
        $securityAnswer = password_hash($_POST['security_answer'], PASSWORD_DEFAULT);

        if ($errorOccurred == 0) {
            $sql = "INSERT INTO users (password, forename, surname, email, phone, security_question, security_answer) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$hashed_password, $forename, $surname, $email1, $phone, $securityQuestion, $securityAnswer])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $message = "Registration Successful. <a href='dashboard.php' class='login-link'>Click here to go to your dashboard</a>";
            } else {
                $message = "Registration Unsuccessful. <a href='registerForm.php' class='login-link'>Click here to retry</a>";
            }
        } else {
            $message = "There were errors in your form submission. <a href='registerForm.php' class='login-link'>Click here to retry</a>";
        }
    }
} else {
    $message = "Invalid request method.";
}

echo "<!DOCTYPE html>
      <html lang='en'>
      <head>
          <meta charset='UTF-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <title>Registration Status</title>
          <style>
              body {
                  font-family: 'Times New Roman', serif;
                  background-color: #fdf6e3;
                  color: #8B4513;
                  padding: 20px;
                  text-align: center;
              }
              .message {
                  padding: 20px;
                  border-radius: 5px;
                  box-shadow: 0 2px 5px rgba(139, 69, 19, 0.2);
                  max-width: 400px;
                  margin: 40px auto;
                  border: 1px solid #cd853f;
                  font-family: 'Papyrus', fantasy;
              }
              .login-link {
                  display: inline-block;
                  margin-top: 20px;
                  padding: 10px 15px;
                  border: none;
                  border-radius: 4px;
                  background-color: #8B4513;
                  color: #fdf6e3;
                  text-decoration: none;
                  font-size: 16px;
                  font-family: 'Courier New', Courier, monospace;
              }
              .login-link:hover {
                  background-color: #996515;
                  text-decoration: underline;
              }
          </style>
      </head>
      <body>
          <div class='message'>
              <h1>Registration Status</h1>
              <p>$message</p>
          </div>
      </body>
      </html>";
exit;
?>
