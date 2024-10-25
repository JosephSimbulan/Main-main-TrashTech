<?php
include 'db_connection.php';

// Get the company name and user role from the session
$company_name = $_SESSION['company_name'] ?? '';
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div id="sidebar">
    <h2><?php echo htmlspecialchars($company_name); ?> Menu</h2> <!-- Display the company name -->
    <?php if ($_SESSION['role'] == 'admin'): ?>
        <h3>Admin Menu</h3>
        <ul>
            <li><a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
            <li><a href="waste_statistics.php" class="<?php echo $current_page == 'waste_statistics.php' ? 'active' : ''; ?>">Waste Statistics</a></li>
            <li><a href="logs.php" class="<?php echo $current_page == 'logs.php' ? 'active' : ''; ?>">Logs</a></li>
            <li><a href="bin_levels.php" class="<?php echo $current_page == 'bin_levels.php' ? 'active' : ''; ?>">Bin Levels</a></li>
            <li><a href="manage_users.php" class="<?php echo $current_page == 'manage_users.php' ? 'active' : ''; ?>">Manage Users</a></li>
            <li><a href="user_logs.php" class="<?php echo $current_page == 'user_logs.php' ? 'active' : ''; ?>">User Logs</a></li>
            <li><a href="about_us.php" class="<?php echo $current_page == 'about_us.php' ? 'active' : ''; ?>">About Us</a></li>
            <li><a href="faq.php" class="<?php echo $current_page == 'faq.php' ? 'active' : ''; ?>">FAQ</a></li>
            <li><a href="report_generation.php" class="<?php echo $current_page == 'report_generation.php' ? 'active' : ''; ?>">Weekly Report</a></li>
        </ul>
    <?php else: ?>
        <h3>User Menu</h3>
        <ul>
            <li><a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
            <li><a href="bin_levels.php" class="<?php echo $current_page == 'bin_levels.php' ? 'active' : ''; ?>">Bin Levels</a></li>
            <li><a href="logs.php" class="<?php echo $current_page == 'logs.php' ? 'active' : ''; ?>">Logs</a></li>
            <li><a href="about_us.php" class="<?php echo $current_page == 'about_us.php' ? 'active' : ''; ?>">About Us</a></li>
            <li><a href="faq.php" class="<?php echo $current_page == 'faq.php' ? 'active' : ''; ?>">FAQ</a></li>
        </ul>
    <?php endif; ?>
</div>

<style>
    #sidebar {
        width: 250px;
        background-color: #333;
        color: white;
        height: 100vh;
        position: fixed;
        padding: 15px;
        top: 60px; /* Aligned with the fixed header */
        left: 0;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }
    #sidebar h2 {
        color: white;
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
    }
    #sidebar ul {
        list-style-type: none;
        padding: 0;
    }
    #sidebar ul li {
        margin: 10px 0;
    }
    #sidebar ul li a {
        display: block;
        color: white;
        padding: 10px;
        text-decoration: none;
        text-align: center;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    #sidebar ul li a.active {
        font-weight: bold;
        background-color: #575757;
    }
    #sidebar ul li a:hover {
        background-color: #575757;
    }
</style>
