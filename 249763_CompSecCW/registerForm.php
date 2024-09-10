<?php
    session_start();//Cand_No: 249763
    $registrationErrors = isset($_SESSION['registration_errors']) ? $_SESSION['registration_errors'] : '';
    unset($_SESSION['registration_errors']);

    if (!empty($registrationErrors)){
        echo "<div class='error-message'>" . htmlspecialchars($registrationErrors) . "</div>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Register - Love's Antique Shop</title>
    <style>
    body {
        font-family: 'Times New Roman', serif;
        background-color: #fdf6e3;
        color: #8B4513;
        padding: 20px;
        text-align: center;
    }
    .title-bar {
        text-align: center;
        margin-bottom: 20px;
    }

    .title-bar h1 {
        font-family: 'Papyrus', fantasy;
        color: #8B4513;
        margin-bottom: 5px;
    }

    hr {
        border: 0;
        height: 1px;
        background-color: #cd853f;
        max-width: 400px;
        margin: 0 auto;
    }
    .registration-form {
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(139, 69, 19, 0.2);
        max-width: 400px;
        margin: 40px auto;
        border: 1px solid #cd853f;
    }
    .registration-form h1 {
        text-align: center;
        color: #6e503b;
        font-family: 'Papyrus', fantasy;
    }
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #cd853f;
        border-radius: 4px;
        margin-bottom: 15px;
        box-sizing: border-box;
    }
    .btn-primary {
        width: 100%;
        padding: 10px;
        border: 1px solid #cd853f;
        border-radius: 4px;
        background-color: #8B4513;
        color: #fdf6e3;
        cursor: pointer;
        font-size: 16px;
        text-transform: uppercase;
        margin-bottom: 10px;
        font-family: 'Courier New', Courier, monospace;
    }
    .btn-primary:hover {
        background-color: #996515;
    }
    .login-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #8B4513;
        text-decoration: none;
        font-weight: bold;
    }
    .login-link:hover {
        text-decoration: underline;
    }
    .error-message {
        color: red;
        margin-bottom: 10px;
        text-align: center;
    }
    .checkbox-group, .security-question-group {
        margin: 20px 0;
    }
    .checkbox-group label, .security-question-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #8B4513;
    }
    .checkbox-group input, .security-question-group input,
    .checkbox-group select, .security-question-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #cd853f;
        border-radius: 4px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }
    .custom-checkbox {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        display: inline-block;
    }
    .custom-checkbox input[type="checkbox"] {
        display: none;
    }
    .custom-checkbox .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
        border-radius: 4px;
        border: 1px solid #ddd;
    }
    .custom-checkbox input[type="checkbox"]:checked ~ .checkmark {
        background-color: #8B4513;
        border-color: #8B4513;
    }
    .custom-checkbox .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    .custom-checkbox input[type="checkbox"]:checked ~ .checkmark:after {
        display: block;
    }
    .custom-checkbox .checkmark:after {
        left: 7px;
        top: 3px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        transform: rotate(45deg);
    }
</style>
</head>
<body>
    <div class="title-bar">
        <h1>Love's Antique Shop - 249763</h1>
        <hr>
    </div>
    <div class="registration-form">
        <form action="registerScript.php" method="POST">
            <h1>Register Your Details</h1>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input id="txtForename" name="txtForename" type="text" class="form-control" placeholder="Forename">
            <input id="txtSurname" name="txtSurname" type="text" class="form-control" placeholder="Surname">
            <input id="txtEmail1" name="txtEmail1" type="email" class="form-control" placeholder="Email Address">
            <input id="txtEmail2" name="txtEmail2" type="email" class="form-control" placeholder="Confirm Email Address">
            <input id="txtPassword1" name="txtPassword1" type="password" class="form-control" placeholder="Password">
            <input id="txtPassword2" name="txtPassword2" type="password" class="form-control" placeholder="Confirm Password">
            <input id="txtPhone" name="txtPhone" type="text" class="form-control" placeholder="Contact Number">
            <div class="security-question-group">
                <label for="security_question">Security Question:</label>
                <select name="security_question" id="security_question" class="form-control">
                    <option value="Your first pet's name?">Your first pet's name?</option>
                    <option value="Where was your first job?">Where was your first job?</option>
                    <option value="Your favourite game?">Your favourite game?</option>
                </select>

                <label for="security_answer">Answer:</label>
                <input type="text" name="security_answer" id="security_answer" class="form-control" placeholder="Your Answer" required>
            
            <!-- Commented out the 2FA checkbox section -->
            <!-- <div class="checkbox-group">
                <label class="custom-checkbox">
                    Enable Two-Factor Authentication (Required)
                    <input type="checkbox" name="enable_2fa" value="yes"required>
                    <span class="checkmark"></span>
                </label>
            </div> -->

            <div class="g-recaptcha" data-sitekey="6LcLPi4pAAAAAHpkbr5ERkj_f8ISKjOuJvOC61Kq"></div>
            <input type="submit" value="Register" class="btn btn-primary">
        </form>
        <a href="index.php" class="login-link">Already have an account? Log in</a>
    </div>
</body>
</html>
