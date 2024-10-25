<?php
session_start();
include 'db_connection.php';

// Get company name from session
$company_name = $_SESSION['company_name'] ?? ''; // Prevent notices

// Get the username to display if logged in
$username = $_SESSION['username'] ?? ''; 
?>

<div id="header">
    <div class="logo-space">
        <img src="images/TTechLogo.png" alt="Website Logo">
    </div>
    <div class="brand-name">TrashTech</div>
    <div class="button-container">
        <?php if (!empty($username)): ?>
            <div class="notification-button" onclick="toggleDropdown()">
                <span>&#xf0f3;</span> Notifications
            </div>
            <a href="logout.php" class="logout-button">Logout</a>
        <?php endif; ?>
        <div id="notificationDropdown" class="notification-dropdown">
            <!-- Notifications will be inserted dynamically -->
        </div>
    </div>
</div>

<script>
    const notifications = []; // Replace with actual notifications data

    function toggleDropdown() {
        const dropdown = document.getElementById("notificationDropdown");
        dropdown.classList.toggle("show");
        renderNotifications();
    }

    function renderNotifications() {
        const dropdown = document.getElementById("notificationDropdown");
        dropdown.innerHTML = ''; // Clear previous content

        if (notifications.length === 0) {
            dropdown.innerHTML = '<div class="no-notifications">There are no notifications yet.</div>';
        } else {
            notifications.forEach(notification => {
                const item = document.createElement('div');
                item.className = 'notification-item';
                item.innerHTML = `
                    <span>${notification.message}</span>
                    <small>${notification.time}</small>
                `;
                dropdown.appendChild(item);
            });
            dropdown.innerHTML += '<a href="#" class="see-all">See All Notifications</a>';
        }
    }

    window.onclick = function(event) {
        if (!event.target.closest('.notification-button')) {
            document.getElementById("notificationDropdown").classList.remove("show");
        }
    };
</script>

<style>
    #header {
        width: 100%;
        background-color: #760b9a; /* Modern off-white color */
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for modern look */
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        height: 60px; /* Fixed height for the header */
    }
    
    .logo-space {
        width: 50px;
        height: 50px;
    }
    .logo-space img {
        height: 40px;
    }
    .brand-name {
        font-size: 30px;
        font-weight: bold;
        margin: 0;
        padding-left: 5px;
    }
    .button-container {
        margin-left: auto;
        display: flex;
        align-items: center;
        position: relative;
    }
    .notification-button, .logout-button {
        color: #333;
        text-decoration: none;
        padding: 10px 15px;
        font-size: 18px;
        margin-left: 10px;
        display: flex;
        align-items: center;
    }
    .notification-button span {
        font-size: 24px;
        margin-right: 5px;
    }
    #notificationDropdown {
        display: none;
        position: absolute;
        top: 60px;
        right: 0;
        width: 320px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }
    #notificationDropdown.show {
        display: block;
    }
    #notificationDropdown .notification-item {
        display: flex;
        padding: 10px;
        align-items: center;
        border-bottom: 1px solid #eee;
    }
    #notificationDropdown .notification-item span {
        flex-grow: 1;
    }
    #notificationDropdown .notification-item small {
        color: gray;
        font-size: 12px;
    }
    #notificationDropdown .notification-item:hover {
        background-color: #f0f0f0;
    }
    #notificationDropdown .no-notifications {
        text-align: center;
        padding: 15px;
        color: gray;
        font-style: italic;
    }
    #notificationDropdown .see-all {
        display: block;
        text-align: center;
        padding: 10px;
        color: #007bff;
        text-decoration: none;
    }
    #notificationDropdown .see-all:hover {
        text-decoration: underline;
    }
</style>
