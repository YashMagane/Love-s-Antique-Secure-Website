<?php
session_start();//Cand_No: 249763

// CSRF token validation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // Handle the error - CSRF token does not match or not set
        die('CSRF token validation failed.');
    }
}

// Redirect to login page if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Process the form if it's submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $host = 'localhost';
    $db = 'id21551194_lovejoysdatabase';
    $user = 'id21551194_lovejoysdb';
    $pass = 'V4o"B|3,H5f1';
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Sanitise and validate form inputs

    $details = filter_input(INPUT_POST, 'details', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $contactMethod = filter_input(INPUT_POST, 'contactMethod', FILTER_SANITIZE_STRING);
    $userId = $_SESSION['user_id']; // Assuming user_id is stored in session
    
// Handle file upload
if (isset($_FILES['objectPhoto']) && $_FILES['objectPhoto']['error'] == 0) {
    $targetDir = "uploads/"; // Directory where files will be stored
    $fileName = time() . '_' . basename($_FILES["objectPhoto"]["name"]); // Creating a unique file name
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Specify allowed file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to the server
        if (move_uploaded_file($_FILES["objectPhoto"]["tmp_name"], $targetFilePath)) {
            // File upload success, path will be stored in the database
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed.";
        exit;
    }
} else {
    $targetFilePath = null; // No file uploaded
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php'); // Redirect if not logged in
    exit;
}

$userId = $_SESSION['user_id'];
// Handle file path
$photoPath = isset($fileName) ? 'uploads/' . $fileName : NULL;

    // Insert the evaluation request into the database
    $sql = "INSERT INTO evaluation_requests (user_id, details, contact_method, photo_path) VALUES (:user_id, :details, :contact_method, :photo_path)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':details', $details, PDO::PARAM_STR);
    $stmt->bindParam(':contact_method', $contactMethod, PDO::PARAM_STR);
    $stmt->bindParam(':photo_path', $photoPath, PDO::PARAM_STR);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Submission Status</title>
                  <style>
              body {
                  font-family: 'Times New Roman', serif;
                  background-color: #fdf6e3;
                  color: #8B4513;
                  padding: 20px;
                  text-align: center;
              }
              .message {
                  background: url('path_to_your_antique_paper_texture.jpg');
                  padding: 20px;
                  border-radius: 5px;
                  box-shadow: 0 2px 5px rgba(139, 69, 19, 0.2);
                  max-width: 400px;
                  margin: 40px auto;
                  border: 1px solid #cd853f;
              }
              .login-link {
                  display: inline-block;
                  margin-top: 20px;
                  padding: 10px 15px;
                  border: 1px solid #cd853f;
                  border-radius: 4px;
                  background-color: #8B4513;
                  color: #fdf6e3;
                  text-decoration: none;
                  font-size: 16px;
                  font-family: 'Courier New', Courier, monospace;
              }
              .login-link:hover {
                  background-color: #996515;
              }
          </style>
              </head>
              <body>
                  <div class='message'>
                      <h1>Request Received</h1>
                      <p>Your request has been received. We will contact you as soon as possible!</p>
                      <a href='req_evaForm.php' class='login-link'>Got another request? Click here.</a>
                      <a href='logout.php' class='login-link'>Logout</a>
                  </div>
              </body>
              </html>";
        exit;
    } else {
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Error</title>
                  <style>
              body {
                  font-family: 'Times New Roman', serif;
                  background-color: #fdf6e3;
                  color: #8B4513;
                  padding: 20px;
                  text-align: center;
              }
              .message {
                  background: url('path_to_your_antique_paper_texture.jpg');
                  padding: 20px;
                  border-radius: 5px;
                  box-shadow: 0 2px 5px rgba(139, 69, 19, 0.2);
                  max-width: 400px;
                  margin: 40px auto;
                  border: 1px solid #cd853f;
              }
              .login-link {
                  display: inline-block;
                  margin-top: 20px;
                  padding: 10px 15px;
                  border: 1px solid #cd853f;
                  border-radius: 4px;
                  background-color: #8B4513;
                  color: #fdf6e3;
                  text-decoration: none;
                  font-size: 16px;
                  font-family: 'Courier New', Courier, monospace;
              }
              .login-link:hover {
                  background-color: #996515;
              }
          </style>
              </head>
              <body>
                  <div class='message'>
                      <h1>Submission Error</h1>
                      <p>Error submitting the evaluation request.</p>
                      <a href='req_evaForm.php' class='login-link'>Return to Request Form</a>
                  </div>
              </body>
              </html>";
        exit;
    }
    
}
?>
