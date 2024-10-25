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

// Fetch Paper data from the paper_level table
$paper_level_query = "SELECT level, timestamp FROM paper_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$paper_level_result = $conn->query($paper_level_query);

if ($paper_level_result->num_rows > 0) {
    $paper_level = $paper_level_result->fetch_assoc();
    $bin_data['paper'] = $paper_level;
}

// Fetch Plastic data from the plastic_level table
$plastic_level_query = "SELECT level, timestamp FROM plastic_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$plastic_level_result = $conn->query($plastic_level_query);

if ($plastic_level_result->num_rows > 0) {
    $plastic_level = $plastic_level_result->fetch_assoc();
    $bin_data['plastic'] = $plastic_level;
}

// Fetch Metal data from the metal_level table
$metal_level_query = "SELECT level, timestamp FROM metal_level WHERE company_name = '$company_name' ORDER BY id DESC LIMIT 1";
$metal_level_result = $conn->query($metal_level_query);

if ($metal_level_result->num_rows > 0) {
    $metal_level = $metal_level_result->fetch_assoc();
    $bin_data['metal'] = $metal_level;
}

// Fetch Glass data from the glass_level table
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
            padding-top: 60px;
            display: flex;
        }

        #content {
            margin-left: 280px;
            padding: 20px;
            width: calc(100% - 280px);
            background: linear-gradient(135deg, #D187F5, #FFFFFF);
        }

        h1 {
            margin-top: 0;
        }

        .trash-bin-container {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .container {
            padding: 80px;
            margin: 10px;
            width: 120px;
            background-color: transparent;
            border: none;
        }

        label {
            text-align: center;
            margin-top: 10px;
        }

        .trash {
            width: 90px;
            height: 130px;
            border: 3px solid black;
            border-radius: 8px;
            position: relative;
            background: transparent;
            cursor: pointer;
            transition: background-color 0.5s;
        }

        .trashLid {
            width: 90px;
            height: 8px;
            background-color: black;
            border-radius: 50px;
            margin-bottom: 2px;
        }

        .trashLevel {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 0;
            border-radius: 8px;
            transition: height 0.5s ease-out;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div id="content">
        <h1>Bin Levels for <?php echo $_SESSION['company_name']; ?></h1>

        <div class="trash-bin-container">
            <div class="container trash-style-1">
                <div class="trashLid"></div>
                <div class="trash" id="trash1">
                    <div class="trashLevel" id="trash1Level"></div>
                </div>
                <label for="trash1">Paper</label>
            </div>
            <div class="container trash-style-2">
                <div class="trashLid"></div>
                <div class="trash" id="trash2">
                    <div class="trashLevel" id="trash2Level"></div>
                </div>
                <label for="trash2">Plastic</label>
            </div>
            <div class="container trash-style-3">
                <div class="trashLid"></div>
                <div class="trash" id="trash3">
                    <div class="trashLevel" id="trash3Level"></div>
                </div>
                <label for="trash3">Metal</label>
            </div>
            <div class="container trash-style-4">
                <div class="trashLid"></div>
                <div class="trash" id="trash4">
                    <div class="trashLevel" id="trash4Level"></div>
                </div>
                <label for="trash4">Glass</label>
            </div>
        </div>

        <script>
            // Function to update trash bins based on color levels (green, yellow, orange, red)
            function updateBinColorAndLevel(color, binId, levelId) {
                let fillHeight = 0;

                if (color === 'red') {
                    fillHeight = 100; // 100% fill
                } else if (color === 'orange') {
                    fillHeight = 75; // 75% fill
                } else if (color === 'yellow') {
                    fillHeight = 50; // 50% fill
                } else {
                    fillHeight = 25; // 25% fill for green
                }

                document.getElementById(binId).style.backgroundColor = color;
                document.getElementById(levelId).style.backgroundColor = color;
                document.getElementById(levelId).style.height = `${fillHeight}%`;
            }

            // Function to update all bins based on fetched data
            function updateTrashBins() {
                // Paper
                const paperColor = "<?php echo $bin_data['paper']['level'] ?? 'green'; ?>";
                updateBinColorAndLevel(paperColor, 'trash1', 'trash1Level');

                // Plastic
                const plasticColor = "<?php echo $bin_data['plastic']['level'] ?? 'green'; ?>";
                updateBinColorAndLevel(plasticColor, 'trash2', 'trash2Level');

                // Metal
                const metalColor = "<?php echo $bin_data['metal']['level'] ?? 'green'; ?>";
                updateBinColorAndLevel(metalColor, 'trash3', 'trash3Level');

                // Glass
                const glassColor = "<?php echo $bin_data['glass']['level'] ?? 'green'; ?>";
                updateBinColorAndLevel(glassColor, 'trash4', 'trash4Level');
            }

            // Call the function to update trash bins on page load
            updateTrashBins();
        </script>
    </div>
</body>
</html>
