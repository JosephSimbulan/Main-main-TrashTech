<?php
// user_logs.php
include 'db_connection.php';
include 'header.php';
include 'sidebar.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch user logs for admin
$sql = "SELECT users.username, user_logs.action, user_logs.timestamp 
        FROM user_logs 
        JOIN users ON user_logs.user_id = users.id 
        ORDER BY user_logs.timestamp DESC";
$result = $conn->query($sql);

$page_title = "User Logs Page";

?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding-top: 60px; /* Adjust for header height */
        display: flex;
    }
    /* Sidebar styling */
    .sidebar {
        width: 220px; /* Sidebar width */
        background-color: #343a40;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        padding: 20px;
        overflow-y: auto;
        z-index: 1000; /* Ensure sidebar is on top of the content */
    }
    /* Header styling */
    header {
        background-color: #f8f9fa;
        padding: 20px;
        text-align: center;
        position: fixed;
        top: 0;
        left: 220px; /* Move header to the right of sidebar */
        width: calc(100% - 220px); /* Adjust width to match sidebar */
        z-index: 999; /* Ensure header is above the content */
        box-sizing: border-box;
    }
    /* Content section (where the user logs are displayed) */
    #content {
        margin-left: 280px; /* Shift content more to the right */
        padding: 20px;
        width: calc(100% - 280px); /* Adjust content width */
        background: linear-gradient(135deg, #D187F5, #FFFFFF); /* Gradient background */
        height: calc(100vh - 80px); /* Fill remaining height after header */
        overflow-y: auto; /* Allow scrolling */
        box-sizing: border-box;
    }
    h1 {
        margin-top: 0;
        margin-left: 20px; /* Align h1 beside the sidebar */
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 18px;
        text-align: left;
    }
    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #f5f5f5;
    }
</style>

<!-- Content Section -->
<div id="content">
    <h1>User Logs</h1>
    <table>
        <tr>
            <th>Username</th>
            <th>Action</th>
            <th>Date and Time (PHT)</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            $date = new DateTime($row['timestamp'], new DateTimeZone('UTC'));
            $date->setTimezone(new DateTimeZone('Asia/Manila'));
            $formatted_date = $date->format('Y-m-d H:i:s');
            echo '
            <tr>
                <td>' . htmlspecialchars($row['username']) . '</td>
                <td>' . htmlspecialchars($row['action']) . '</td>
                <td>' . htmlspecialchars($formatted_date) . '</td>
            </tr>';
        }
        ?>
    </table>
</div>
