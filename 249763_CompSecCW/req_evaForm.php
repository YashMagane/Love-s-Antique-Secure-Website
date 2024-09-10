<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Evaluation - Lovejoy's Antique Store</title>
    <style>
        <style>
        body {
            font-family: 'Times New Roman', serif;
            background-color: #fdf6e3;
            color: #8B4513;
            padding: 20px;
            text-align: center;
        }
        .evaluation-form {
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(139, 69, 19, 0.2);
            max-width: 500px;
            margin: auto;
            border: 1px solid #cd853f;
        }
        .form-control, .btn, .btn-back {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #cd853f;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: transparent;
            color: #8B4513;
        }
        .btn {
            border: none;
            background-color: #8B4513;
            color: #fdf6e3;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
            font-family: 'Courier New', Courier, monospace;
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }
        .btn:hover, .btn-back:hover {
            opacity: 0.9;
        }
        a {
            color: #6e503b;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="evaluation-form">
        <h1>Item Evaluation Request</h1>
        <form action="req_eva.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="details" style="font-weight: bold; color: #8B4513;">Details of the Object:</label>
            <textarea id="details" name="details" class="form-control" placeholder="Details of the Object" required></textarea>
            <label for="contactMethod" style="font-weight: bold; color: #8B4513;">Preferred Contact Method:</label>
            <select id="contactMethod" name="contactMethod" class="form-control">
                <option value="phone">Phone</option>
                <option value="email">Email</option>
            </select>
            <label for="objectPhoto" style="font-weight: bold; color: #8B4513;">Image of your Object (jpg, png, jpeg, gif)</label>
            <input type="file" id="objectPhoto" name="objectPhoto" accept="image/*" class="form-control">

            <input type="submit" value="Submit Request" class="btn">
            <a href="dashboard.php" class="btn-back">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>
