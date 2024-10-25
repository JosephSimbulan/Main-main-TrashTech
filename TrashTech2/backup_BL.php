<?php
// bin_levels.php

// Include necessary files
include 'db_connection.php';
include 'header.php';  // Include the header.php to maintain the header layout
include 'sidebar.php'; // Include sidebar.php to ensure the sidebar is rendered

// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['company_name'])) {
    die("User not logged in");
}

// Get the logged-in user's company name from the session
$company_name = $_SESSION['company_name'];

// Fetch the latest bin level data for each material
$bin_data = array();

// Fetch Paper data
$paper_level_query = "SELECT level, timestamp FROM paper_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$paper_level_result = $conn->query($paper_level_query);

if ($paper_level_result->num_rows > 0) {
    $paper_level = $paper_level_result->fetch_assoc();
    $bin_data['paper'] = $paper_level;
}

// Fetch Plastic data
$plastic_level_query = "SELECT level, timestamp FROM plastic_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$plastic_level_result = $conn->query($plastic_level_query);

if ($plastic_level_result->num_rows > 0) {
    $plastic_level = $plastic_level_result->fetch_assoc();
    $bin_data['plastic'] = $plastic_level;
}

// Fetch Metal data
$metal_level_query = "SELECT level, timestamp FROM metal_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$metal_level_result = $conn->query($metal_level_query);

if ($metal_level_result->num_rows > 0) {
    $metal_level = $metal_level_result->fetch_assoc();
    $bin_data['metal'] = $metal_level;
}

// Fetch Glass data
$glass_level_query = "SELECT level, timestamp FROM glass_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$glass_level_result = $conn->query($glass_level_query);

if ($glass_level_result->num_rows > 0) {
    $glass_level = $glass_level_result->fetch_assoc();
    $bin_data['glass'] = $glass_level;
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Monitoring - <?php echo $_SESSION['company_name']; ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-top: 60px; /* Adjust this value to match the header height */
            display: flex;
        }

        #content {
            margin-left: 280px; /* Shift content more to the right */
            padding: 20px;
            width: calc(100% - 280px); /* Adjust content width */
            background: linear-gradient(135deg, #D187F5, #FFFFFF); /* Gradient background */
        }

        h1 {
            margin-top: 0;
        }

        /* Flexbox layout for trash bins */
        .trash-bin-container {
            display: flex; /* Use flexbox */
            justify-content: space-around; /* Space bins evenly */
            align-items: flex-start; /* Align bins to the top */
            margin-top: 20px;
            flex-wrap: wrap; /* Allow wrapping if the screen is too small */
        }

        .container {
            padding: 80px; /* Increase padding for larger bins */
            margin: 10px;
            width: 120px; /* Increase width for the bins */
            background-color: transparent; /* Set background to transparent */
            border: none; /* Remove border */
        }

        label {
            position: relative;
            overflow: hidden;
            text-align: center; /* Center the text */
            margin-top: 10px; /* Add margin for spacing */
        }

        /* Shared trash bin styles */
        .trash {
            width: 90px; /* Increase width for the trash */
            height: 130px; /* Increase height for the trash */
            border: 3px solid black;
            border-radius: 8px;
            position: relative;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            background: transparent; /* Set background to transparent */
            cursor: pointer;
            transition: background-color 0.5s; /* Add transition for color change */
        }

        .trash .strap {
            width: 15px; /* Increase strap width */
            height: 95%; /* Increase strap height */
            background-color: black; /* Strap color */
            border-radius: 50px;
            position: relative;
            overflow: hidden;
        }

        .trash .strap::after {
            content: "";
            display: block;
            position: absolute;
            bottom: 0;
            height: 0%;
            background-color: rgb(77, 217, 77);
            width: 100%;
        }

        .trashLid {
            width: 90px; /* Increase lid width */
            height: 8px; /* Increase lid height */
            background-color: black;
            display: block;
            margin-bottom: 2px;
            border-radius: 50px;
            position: relative;
            transition: 0.5s cubic-bezier(0.05, 0.61, 0.41, 0.95);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?> <!-- Sidebar -->

    <div id="content">
        <h1>Bin Levels for <?php echo $_SESSION['company_name']; ?></h1>

        <!-- Trash Bin Animation - Visual Representation of Levels -->
        <div class="trash-bin-container">
            <div class="container trash-style-1">
                <div class="trashLid"></div>
                <div class="trash" id="trash1"></div>
                <label for="trash1">Paper</label>
            </div>
            <div class="container trash-style-2">
                <div class="trashLid"></div>
                <div class="trash" id="trash2"></div>
                <label for="trash2">Plastic</label>
            </div>
            <div class="container trash-style-3">
                <div class="trashLid"></div>
                <div class="trash" id="trash3"></div>
                <label for="trash3">Metal</label>
            </div>
            <div class="container trash-style-4">
                <div class="trashLid"></div>
                <div class="trash" id="trash4"></div>
                <label for="trash4">Glass</label>
            </div>
        </div>

        <script>
            // Function to determine bin color based on level
            function getBinColor(level) {
                if (level >= 20) return 'green';
                if (level >= 14) return 'yellow';
                if (level >= 6) return 'orange';
                return 'red';
            }

            // Update each trash bin's color based on the fetched levels
            function updateTrashBinColor() {
                // Update Paper bin color
                const paperLevel = <?php echo $bin_data['paper']['level'] ?? 0; ?>;
                document.getElementById('trash1').style.backgroundColor = getBinColor(paperLevel);

                // Update Plastic bin color
                const plasticLevel = <?php echo $bin_data['plastic']['level'] ?? 0; ?>;
                document.getElementById('trash2').style.backgroundColor = getBinColor(plasticLevel);

                // Update Metal bin color
                const metalLevel = <?php echo $bin_data['metal']['level'] ?? 0; ?>;
                document.getElementById('trash3').style.backgroundColor = getBinColor(metalLevel);

                // Update Glass bin color
                const glassLevel = <?php echo $bin_data['glass']['level'] ?? 0; ?>;
                document.getElementById('trash4').style.backgroundColor = getBinColor(glassLevel);
            }

            // Run the update function on page load
            updateTrashBinColor();
        </script>
    </div>
</body>
</html>
