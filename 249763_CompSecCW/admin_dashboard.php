<?php
session_start();//Cand_No: 249763
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Lovejoy's Antique Store</title>
    <style>
    body {
        font-family: 'Times New Roman', serif;
        background-color: #fdf6e3;
        color: #8B4513;
        padding: 20px;
        text-align: center;
    }
    .welcome-heading {
        font-family: 'Papyrus', fantasy;
        color: #6e503b;
        margin-bottom: 20px;
    }
    .dashboard {
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(139, 69, 19, 0.2);
        max-width: 400px;
        margin: 40px auto;
        border: 1px solid #cd853f;
    }
    .dashboard h2 {
        font-family: 'Times New Roman', serif;
        color: #333;
        margin-bottom: 20px;
    }
    .dashboard-link {
        display: inline-block;
        margin: 10px auto;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        background-color: #8B4513;
        color: white;
        text-decoration: none;
        font-size: 16px;
        text-transform: uppercase;
    }
    .dashboard-link:hover {
        background-color: #996515;
    }
</style>

</head>
<body>
    <h1 class="welcome-heading">Welcome!</h1>
    <div class="dashboard">
        <h2>Admin Dashboard</h2>
        <a href="list_eva_req.php" class="dashboard-link">List of Evaluation Requests</a>
        <br>
        <a href="logout.php" class="dashboard-link">Logout</a>
    </div>
</body>
</html>
