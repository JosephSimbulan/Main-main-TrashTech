<?php
// template.php
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-top: 60px; /* Adjust this value to match the header height */
        }
        #header {
            width: 100%;
            background-color: #760b9a;
            color: white;
            height: 60px;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-sizing: border-box;
        }
        #header .logo-space {
            width: 50px;
            height: 50px;
        }
        #header .logo-space img {
            width: 100%;
            height: auto;
        }
        #header .brand-name {
            font-size: 30px;
            font-weight: bold;
            margin: 0;
            padding-left: 5px;
        }
        #header .button-container {
            margin-left: auto;
            display: flex;
            align-items: center;
            position: relative;
        }
        #header .notification-button, #header .logout-button {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            font-size: 18px;
            margin-left: 10px;
            display: flex;
            align-items: center;
        }
        #header .notification-button span {
            font-size: 24px;
            margin-right: 5px;
        }
        #header .notification-dropdown {
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
        #header .notification-dropdown.show {
            display: block;
        }
        #header .notification-dropdown .notification-item {
            display: flex;
            padding: 10px;
            align-items: center;
            border-bottom: 1px solid #eee;
        }
        #header .notification-dropdown .notification-item span {
            flex-grow: 1;
        }
        #header .notification-dropdown .notification-item small {
            color: gray;
            font-size: 12px;
        }
        #header .notification-dropdown .notification-item:hover {
            background-color: #f0f0f0;
        }
        #header .notification-dropdown .no-notifications {
            text-align: center;
            padding: 15px;
            color: gray;
            font-style: italic;
        }
        #header .notification-dropdown .see-all {
            display: block;
            text-align: center;
            padding: 10px;
            color: #007bff;
            text-decoration: none;
        }
        #header .notification-dropdown .see-all:hover {
            text-decoration: underline;
        }
        #sidebar {
            width: 200px;
            background-color: #333;
            color: white;
            height: 100vh;
            position: fixed;
            padding: 15px;
            top: 60px;
        }
        #sidebar h2 {
            color: white;
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
        }
        #sidebar ul li a.active {
            font-weight: bold;
            background-color: #575757;
        }
        #sidebar ul li a:hover {
            background-color: #575757;
        }
        #content {
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
        }
    </style>
</head>
<body>
    <div id="header">
        <div class="logo-space">
            <img src="images/TTechLogo.png" alt="Company Logo">
        </div>
        <div class="brand-name">TrashTech</div>
        <div class="button-container">
            <div class="notification-button" onclick="toggleDropdown()">
                <span style="color: white;">&#xf0f3;</span> Notification
            </div>
            <a href="logout.php" class="logout-button">Logout</a>
            <div id="notificationDropdown" class="notification-dropdown">
                <!-- Notifications will be inserted dynamically -->
            </div>
        </div>
    </div>
    <?php include 'sidebar.php'; ?>
    <div id="content">
    <?php echo isset($page_content) ? $page_content : "<p>No content available.</p>"; ?>
</div>


    <script>
        const notifications = []; // Replace with actual weekly waste data

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
</body>
</html>
