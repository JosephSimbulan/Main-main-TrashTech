<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'header.php'; // Include the header.php to maintain the header layout
include 'sidebar.php'; // Include sidebar.php to ensure the sidebar is rendered
include 'db_connection.php'; // Ensure you include your database connection

// Get company name from session
$company_name = $_SESSION['company_name'];

$page_title = "Dashboard";

// Content with styling and layout for the Dashboard
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <style>
        /* General styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #D187F5, #FFFFFF);
            height: 100vh;
            display: flex;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-top: 50px; /* Add top margin to lower the content */
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80%;
            max-width: 1200px;
            margin: auto;
        }

        .left-section {
            flex: 1;
            padding: 20px;
            color: #333333;
        }

        .left-section h1 {
            font-size: 48px;
            font-weight: bold;
            color: #4A00E0; /* Purple color for TrashTech */
            margin-top: 20px; /* Add top margin to lower the heading */
        }

        .left-section h1 span {
            color: #854AE0; /* Slightly darker purple for emphasis */
        }

        .left-section p {
            font-size: 18px;
            color: #666666;
            margin-top: 20px; /* Increase the top margin to lower the paragraph */
        }

        .right-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px; /* Add top margin to lower the image */
        }

        .right-section img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                text-align: center;
            }

            .left-section {
                padding: 10px;
            }

            .left-section h1 {
                font-size: 36px;
            }

            .right-section {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>

<div id="content">
    <div class="main-content">
        <div class="container">
            <div class="left-section">
                <h1>Welcome to <span>TrashTech</span></h1>
                <p>Where your waste is in our hands.</p>
            </div>
            <div class="right-section">
                <img src="images/Other 07.png" alt="TrashTech">
            </div>
        </div>
    </div>
</div>

</body>
</html>
