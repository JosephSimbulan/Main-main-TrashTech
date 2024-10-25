<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entered_code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
    $new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING);
    $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);

    // Check if the entered code matches the session code
    if ($entered_code == $_SESSION['verification_code']) {
        if ($new_password === $confirm_password) {
            // Here, you should hash the password and save it in the database
            // Assuming $conn is your database connection
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $email = $_SESSION['email'];

            $sql = "UPDATE users SET password = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $hashed_password, $email);

            if ($stmt->execute()) {
                echo 'Password updated successfully. You can now log in.';
                // Optionally, destroy the session
                session_destroy();
            } else {
                echo 'Error updating password.';
            }
        } else {
            echo 'Passwords do not match.';
        }
    } else {
        echo 'Invalid verification code.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
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
        }
        input[type="text"], input[type="password"] {
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify Code</h2>
        <form method="POST" action="">
            <label for="code">Enter Verification Code:</label>
            <input type="text" name="code" required>
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required>
            <input type="submit" value="Reset Password">
        </form>
    </div>
</body>
</html>
