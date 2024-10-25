<?php
// report_generation.php
include 'db_connection.php';
include 'header.php'; // Include the header file for the page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Report Generation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Header styles */
        #header {
            background-color: #760b9a;
            color: white;
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            position: fixed;
            top: 0;
            width: 100%;
            box-sizing: border-box;
            z-index: 1000;
        }

        /* Sidebar styles */
        #sidebar {
            background-color: #5a087a;
            width: 220px;
            position: fixed;
            top: 60px; /* Below the header */
            bottom: 0;
            left: 0;
            padding: 20px;
            color: white;
            box-sizing: border-box;
        }

        #content {
            margin-left: 220px; /* Leave space for the sidebar */
            margin-top: 80px; /* Leave space for the fixed header */
            padding: 20px;
        }

        .report-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            margin: 0 auto;
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .report-header h2 {
            margin: 0;
            font-size: 22px;
            color: #333;
        }

        .toggle-button {
            background-color: #760b9a;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .toggle-button:hover {
            background-color: #5a087a;
        }

        .report-section {
            margin-bottom: 20px;
        }

        .report-section h3 {
            margin: 0 0 10px;
            font-size: 18px;
            color: #333;
        }

        .stats-container {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-radius: 8px;
            background-color: #e9e9e9;
            margin-top: 10px;
        }

        .stat {
            text-align: center;
            flex: 1;
        }

        .stat-value {
            font-size: 24px;
            color: #760b9a;
            font-weight: bold;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?> <!-- Include the sidebar -->

    <div id="content">
        <div class="report-card">
            <div class="report-header">
                <h2>Weekly Report</h2>
                <button class="toggle-button">Switch to Monthly</button>
            </div>

            <div class="report-section">
                <h3>Waste Collection Summary</h3>
                <p>Great job! You've managed your waste collection efficiently this week.</p>
                <div class="stats-container">
                    <div class="stat">
                        <div class="stat-value">5</div>
                        <div class="stat-label">Collections</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value">3</div>
                        <div class="stat-label">Optimizations</div>
                    </div>
                </div>
            </div>

            <div class="report-section">
                <h3>Upcoming Tasks</h3>
                <ul>
                    <li>Prepare for next week's recycling collection.</li>
                    <li>Review and submit your report by Friday.</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
