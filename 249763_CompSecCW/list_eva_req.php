<?php
session_start();//Cand_No: 249763

// Redirect if not logged in or not an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Database connection
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

// Fetch all evaluation requests
try {
    $stmt = $pdo->query("SELECT * FROM evaluation_requests");
    $requests = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching evaluation requests: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Lovjoy's Antique Store</title>
    <style>
    body {
        font-family: 'Times New Roman', serif;
        background-color: #fdf6e3;
        color: #8B4513;
        padding: 20px;
        text-align: center;
    }
    h1, h2 {
        color: #6e503b;
        font-family: 'Papyrus', fantasy;
    }
    table {
        width: 100%;
        max-width: 1000px;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #fff8f0;
        border: 1px solid #cd853f;
    }
    th, td {
        padding: 10px;
        border: 1px solid #cd853f;
        text-align: left;
        color: #8B4513;
    }
    th {
        background-color: #996515;
        color: white;
        font-family: 'Courier New', Courier, monospace;
    }
    tr:nth-child(even) {
        background-color: #fff8f0;
    }
    img {
        max-width: 100px;
        height: auto;
        border-radius: 5px;
    }
    a {
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
    a:hover {
        background-color: #996515;
    }
</style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <h2>Evaluation Requests</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Details</th>
                <th>Contact Method</th>
                <th>Photo Path</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $request): ?>
            <tr>
                <td><?php echo htmlspecialchars($request['id']); ?></td>
                <td><?php echo htmlspecialchars($request['user_id']); ?></td>
                <td><?php echo htmlspecialchars($request['details']); ?></td>
                <td><?php echo htmlspecialchars($request['contact_method']); ?></td>
                <td><?php 
            if (!empty($request['photo_path'])) {
                echo "<img src='" . htmlspecialchars($request['photo_path']) . "' alt='Evaluation Photo' style='width:100px; height:auto;'>";

            } else {
                echo "No photo";
            }
            ?></td>
                <td><?php echo htmlspecialchars($request['created_at']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>

