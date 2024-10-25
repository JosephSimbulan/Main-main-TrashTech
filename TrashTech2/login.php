<?php
// login.php
include 'db_connection.php';

session_start();

$error_message = ""; // Initialize error message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Function to validate user and get their company
    function validate_user($conn, $username, $password) {
        $sql = "SELECT * FROM users WHERE username=?"; // Use the 'users' table
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            die("Error in SQL preparation: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Return the user data if password matches, including company_name
                return $row;
            } else {
                return "wrong_password"; // Indicate wrong password
            }
        }
        return "user_not_found"; // Indicate user not found
    }

    // Validate user from 'users' table
    $user_data = validate_user($conn, $username, $password);

    // If user data is found
    if (is_array($user_data)) {
        // Store user data in session
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['role'] = $user_data['role']; // Store the user's role
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['company_id'] = $user_data['company_id']; // Store company_id in session
        $_SESSION['company_name'] = $user_data['company_name']; // Store company_name for easy reference

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Handle error messages based on the validation result
        if ($user_data === "wrong_password") {
            $error_message = "Incorrect Credentials. Please try again.";
        } elseif ($user_data === "user_not_found") {
            $error_message = "User not found. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');
        body {
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(to bottom, white, #f4f4f4);
        }
        .container {
            display: flex;
            width: 1440px;
            height: 900px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .panel {
            width: 720px;
            padding: 40px;
            box-sizing: border-box;
        }
        .left-panel, .right-panel {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .left-panel img {
            width: 800px;
            height: 800px;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .right-panel form {
            width: 400px;
        }
        .right-panel form input[type="text"],
        .right-panel form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .right-panel form input[type="checkbox"] {
            margin-right: 10px;
        }
        .right-panel form button {
            width: 100%;
            padding: 10px;
            font-size: 18px;
            background-color: #512da8;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .right-panel form button:hover {
            background-color: #512da8;
        }
        .right-panel .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }
        .right-panel .signup-prompt {
            text-align: center;
            margin-top: 20px;
        }
        .right-panel .signup-prompt a {
            color: #512da8;
            text-decoration: none;
        }
        .error-message {
            color: red;
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="panel left-panel">
            <img src="images/logo last 1.png" alt="Illustration">
        </div>
        <div class="panel right-panel">
            <h2>Login</h2>
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form method="POST" action="login.php">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <div>
                    <input type="checkbox" id="show-password"> Show Password
                </div>
                <div class="forgot-password">
                    <a href="forgot_password.php">Forget password?</a>
                </div>
                <button type="submit">Log in</button>
            </form>
            <div class="signup-prompt">
                <p>Don't have an account? <a href="signup.php">Sign up</a></p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('show-password').addEventListener('change', function() {
            var passwordField = document.getElementById('password');
            passwordField.type = this.checked ? 'text' : 'password';
        });
    </script>
</body>
</html>
