<?php
// about_us.php
include 'db_connection.php';
include 'header.php';
include 'sidebar.php'; // Moved sidebar inclusion after header

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$page_title = "About Us Page";

?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        min-height: 100vh; /* Ensure body takes the full height of the page */
    }
   
    /* Content section */
    #content {
        margin-left: 0px; /* Space for the sidebar */
        width: calc(1000% - 10px); /* Fill the remaining width after the sidebar */
        background: linear-gradient(135deg, #D187F5, #FFFFFF); /* Gradient background */
        min-height: 100vh; /* Ensure content fills the full height of the page */
        padding-top: 78px; /* Leave space for the header */
        box-sizing: border-box; /* Ensure padding does not affect width */
    }
    h1, h2, p {
        margin: 0; /* Remove all margins */
        padding-left: 10px; /* Optional: Add slight padding to the left for a bit of breathing space */
    }
</style>

<!-- Content Section -->
<div id="content">
    <h1>About Us</h1>
    <p>Information about TrashTech.</p>
    <h2>Mission</h2>
    <p>Our mission is to provide innovative waste management solutions that promote sustainability and environmental responsibility.</p>
    <h2>Vision</h2>
    <p>Our vision is to be a global leader in waste management, transforming waste into valuable resources and creating a cleaner, greener future for all.</p>
</div>
