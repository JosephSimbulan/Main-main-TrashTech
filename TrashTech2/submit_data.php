<?php
include 'db_connection.php';

// Start the session to retrieve the logged-in user information
session_start();

// Check if the user is logged in
if (!isset($_SESSION['company_name'])) {
    die("User not logged in");
}

// Get the logged-in user's company name from the session
$company_name = $_SESSION['company_name'];


// Sanitize and get POST data
$plastic_level = isset($_POST['plastic_level']) ? floatval($_POST['plastic_level']) : null;
$plastic_weight = isset($_POST['plastic_weight']) ? floatval($_POST['plastic_weight']) : null;
$glass_level = isset($_POST['glass_level']) ? floatval($_POST['glass_level']) : null;
$glass_weight = isset($_POST['glass_weight']) ? floatval($_POST['glass_weight']) : null;
$metal_level = isset($_POST['metal_level']) ? floatval($_POST['metal_level']) : null;
$metal_weight = isset($_POST['metal_weight']) ? floatval($_POST['metal_weight']) : null;
$paper_level = isset($_POST['paper_level']) ? floatval($_POST['paper_level']) : null;
$paper_weight = isset($_POST['paper_weight']) ? floatval($_POST['paper_weight']) : null;

// Insert Plastic data
if (!is_null($plastic_level) && !is_null($plastic_weight)) {
    $plastic_level_query = "INSERT INTO plastic_level (level_cm, measured_at, company_name) VALUES ($plastic_level, NOW(), '$company_name')";
    $plastic_weight_query = "INSERT INTO plastic_weight (weight_kg, measured_at, company_name) VALUES ($plastic_weight, NOW(), '$company_name')";
    $conn->query($plastic_level_query);
    $conn->query($plastic_weight_query);
}

// Insert Glass data
if (!is_null($glass_level) && !is_null($glass_weight)) {
    $glass_level_query = "INSERT INTO glass_level (level_cm, measured_at, company_name) VALUES ($glass_level, NOW(), '$company_name')";
    $glass_weight_query = "INSERT INTO glass_weight (weight_kg, measured_at, company_name) VALUES ($glass_weight, NOW(), '$company_name')";
    $conn->query($glass_level_query);
    $conn->query($glass_weight_query);
}

// Insert Metal data
if (!is_null($metal_level) && !is_null($metal_weight)) {
    $metal_level_query = "INSERT INTO metal_level (level_cm, measured_at, company_name) VALUES ($metal_level, NOW(), '$company_name')";
    $metal_weight_query = "INSERT INTO metal_weight (weight_kg, measured_at, company_name) VALUES ($metal_weight, NOW(), '$company_name')";
    $conn->query($metal_level_query);
    $conn->query($metal_weight_query);
}

// Insert Paper data
if (!is_null($paper_level) && !is_null($paper_weight)) {
    $paper_level_query = "INSERT INTO paper_level (level_cm, measured_at, company_name) VALUES ($paper_level, NOW(), '$company_name')";
    $paper_weight_query = "INSERT INTO paper_weight (weight_kg, measured_at, company_name) VALUES ($paper_weight, NOW(), '$company_name')";
    $conn->query($paper_level_query);
    $conn->query($paper_weight_query);
}

// Close connection
$conn->close();

echo "Data inserted successfully!";
?>
