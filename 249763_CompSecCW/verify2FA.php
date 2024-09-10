<?php
session_start(); //Cand_No: 249763
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complete Two-Factor Authentication Setup</title>
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
        .verify-form {
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(139, 69, 19, 0.2);
            max-width: 400px;
            margin: 20px auto;
            border: 1px solid #cd853f;
        }
        .verify-form h2 {
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
        label {
            display: block;
            margin-bottom: 5px;
            color: #8B4513;
            font-family: 'Georgia', serif;
        }
    </style>
</head>
<body>
    <div class="verify-form">
        <h1>Lovejoy's Antique Store - 249763</h1>
        <h2>Complete Two-Factor Authentication Setup</h2>

        <form action="verify2FAScript.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="verification_code">Enter the code from the app:</label>
            <input type="text" id="verification_code" name="verification_code" class="form-control" required>
            <input type="submit" value="Verify Code" class="btn">
        </form>
    </div>
</body>
</html>

