<?php
session_start();

// Check if the code is set in the URL
if (isset($_GET['code'])) {
    $code = $_GET['code'];
} else {
    // Redirect to the forgot password page if the code is not set
    header('Location: forgot_password.php');
    exit;
}

// Handle password change logic here
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the new password
    if ($new_password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (preg_match('/[A-Z]/', $new_password) && 
              preg_match('/[a-z]/', $new_password) && 
              preg_match('/[0-9]/', $new_password) && 
              preg_match('/[\W]/', $new_password) && 
              strlen($new_password) >= 8) {
        // Here you would typically save the new password to the database
        echo 'Password has been successfully changed!';
        // Optionally, redirect to login page or another page after successful change
        // header('Location: login.php');
        exit;
    } else {
        $error = 'Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        input[type="password"] {
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
        .error {
            color: red;
        }
        .show-password {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .show-password input {
            margin-right: 5px;
        }
    </style>
    <script>
        function togglePasswordVisibility() {
            const passwordFields = document.querySelectorAll('.password-field');
            passwordFields.forEach(field => {
                field.type = field.type === 'password' ? 'text' : 'password';
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form method="POST" action="">
            <input type="hidden" name="code" value="<?php echo htmlspecialchars($code); ?>">
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" class="password-field" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" class="password-field" required>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="show-password">
                <input type="checkbox" id="show-password" onclick="togglePasswordVisibility()">
                <label for="show-password">Show Passwords</label>
            </div>
            <input type="submit" value="Change Password">
        </form>
    </div>
</body>
</html>
