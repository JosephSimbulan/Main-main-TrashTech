<?php
// Start the session
session_start();

// Enable error reporting for debugging (remove or comment out in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if company_name is set in the URL
if (!isset($_GET['company_name'])) {
    // Redirect to the registration page if company_name is not provided
    header("Location: register_company.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Registration Successful</title>
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
        a {
            color: #7C3AED;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration Successful!</h2>
        <p>
            The registration of your company 
            <strong><?php echo htmlspecialchars($_GET['company_name']); ?></strong> 
            has been successful.
        </p>
        <p>You can now <a href="signup.php">create your Admin Account</a>.</p>
    </div>
</body>
</html>
