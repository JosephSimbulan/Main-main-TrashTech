<?php
// Start the session
session_start();

// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize the email input
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Generate a random verification code
    $code = rand(100000, 999999);

    // Store the code and email in session variables
    $_SESSION['verification_code'] = $code;
    $_SESSION['email'] = $email;

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'trashtechphilippines@gmail.com'; //  Gmail address
        $mail->Password = 'esoz ozck akes zqdw'; //  generated app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('trashtechphilippines@gmail.com', 'TrashTech Support');
        $mail->addAddress($email); // Add the recipient

        // Create a unique link with the verification code
        $link = 'http://localhost/TrashTech2/reset_password.php?code=' . $code;

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Code';
        $mail->Body = "
            <p>Your password reset code is: <strong>$code</strong></p>
            <p>Click the button below to change your password:</p>
            <a href='$link' style='
                display: inline-block; 
                background-color: #7C3AED; 
                color: white; 
                padding: 10px 15px; 
                border-radius: 5px; 
                text-decoration: none;'>
                Change Password
            </a>
        ";

        // Send the email
        $mail->send();
        echo 'Verification code sent to your email.';
    } catch (Exception $e) {
        echo 'Error sending email: ' . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative; /* Add this for the overlay */
        }
        input[type="email"] {
            padding: 10px;
            margin-bottom: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #7C3AED;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #5a2ea6;
        }
        /* Loading overlay styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none; /* Hide it by default */
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Make sure it's on top */
        }
        /* Loader styles */
        .loader {
            width: 90px;
            height: 14px;
            box-shadow: 0 3px 0 #fff;
            position: relative;
            display: grid;
            clip-path: inset(-60px 0 -5px);
        }
        .loader:after {
            content: "";
            position: relative;
            background: repeating-linear-gradient(90deg,#0000 0 calc(50% - 8px), #ccc 0 calc(50% + 8px), #0000 0 100%) 0 0/calc(100%/3) 100%;
            animation: l6-1 1s infinite;
        } 
        .loader:before {
            content: "";
            position: absolute;
            width: 14px;
            aspect-ratio: 1;
            left: calc(50% - 7px);
            bottom: 0;
            border-radius: 50%;
            background: lightblue;
            animation: l6-2 1s infinite;
        }
        @keyframes l6-1 {
            50%,100% {background-position: calc(100%/2) 0}
        }
        @keyframes l6-2 {
            0%,50% {transform:translateY(-80px)}
        }
    </style>
    <script>
        function showLoadingAnimation() {
            document.getElementById('loadingOverlay').style.display = 'flex'; // Show loading overlay
            return true; // Allow form submission
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form method="POST" action="" onsubmit="return showLoadingAnimation()">
            <label for="email">Enter your email:</label>
            <input type="email" name="email" required>
            <input type="submit" value="Send Verification Code">
        </form>
    </div>

    <!-- Loading overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loader"></div>
    </div>
</body>
</html>
