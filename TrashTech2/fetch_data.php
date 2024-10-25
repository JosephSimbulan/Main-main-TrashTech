<?php
// Start the session to retrieve the logged-in user information
include 'db_connection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['company_name'])) {
    die("User not logged in");
}

// Get the logged-in user's company name from the session
$company_name = $_SESSION['company_name'];



// Fetch the latest bin level and weight data from respective tables
$bin_data = array();

// Fetch Plastic data
$plastic_level_query = "SELECT level, timestamp FROM plastic_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$plastic_weight_query = "SELECT weight, timestamp FROM plastic_weight WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$plastic_level_result = $conn->query($plastic_level_query);
$plastic_weight_result = $conn->query($plastic_weight_query);

if ($plastic_level_result->num_rows > 0 && $plastic_weight_result->num_rows > 0) {
    $plastic_level = $plastic_level_result->fetch_assoc();
    $plastic_weight = $plastic_weight_result->fetch_assoc();
    $bin_data['plastic'] = array_merge($plastic_level, $plastic_weight);
}

// Fetch Glass data
$glass_level_query = "SELECT level, timestamp FROM glass_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$glass_weight_query = "SELECT weight, timestamp FROM glass_weight WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$glass_level_result = $conn->query($glass_level_query);
$glass_weight_result = $conn->query($glass_weight_query);

if ($glass_level_result->num_rows > 0 && $glass_weight_result->num_rows > 0) {
    $glass_level = $glass_level_result->fetch_assoc();
    $glass_weight = $glass_weight_result->fetch_assoc();
    $bin_data['glass'] = array_merge($glass_level, $glass_weight);
}

// Fetch Metal data
$metal_level_query = "SELECT level, timestamp FROM metal_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$metal_weight_query = "SELECT weight, timestamp FROM metal_weight WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$metal_level_result = $conn->query($metal_level_query);
$metal_weight_result = $conn->query($metal_weight_query);

if ($metal_level_result->num_rows > 0 && $metal_weight_result->num_rows > 0) {
    $metal_level = $metal_level_result->fetch_assoc();
    $metal_weight = $metal_weight_result->fetch_assoc();
    $bin_data['metal'] = array_merge($metal_level, $metal_weight);
}

// Fetch Paper data
$paper_level_query = "SELECT level, timestamp FROM paper_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$paper_weight_query = "SELECT weight, timestamp FROM paper_weight WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$paper_level_result = $conn->query($paper_level_query);
$paper_weight_result = $conn->query($paper_weight_query);

if ($paper_level_result->num_rows > 0 && $paper_weight_result->num_rows > 0) {
    $paper_level = $paper_level_result->fetch_assoc();
    $paper_weight = $paper_weight_result->fetch_assoc();
    $bin_data['paper'] = array_merge($paper_level, $paper_weight);
}

// Close connection
$conn->close();

// Return bin data as JSON
echo json_encode($bin_data);
?>
