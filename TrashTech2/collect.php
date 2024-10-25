<?php
session_start();
include 'db_connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the company name from the session
    if (!isset($_SESSION['company_name'])) {
        echo "Company name not found in session.";
        exit();
    }
    $company_name = $_SESSION['company_name'];
    
    // Get logs from the POST request
    $logs = $_POST['logs'] ?? null;

    // Check if logs is an array
    if (is_array($logs)) {
        // Prepare the SQL statement to insert data into collected_data
        $stmt = $conn->prepare("INSERT INTO collected_data (company_name, material_category, weight_kg) VALUES (?, ?, ?)");

        // Check if the statement was prepared correctly
        if (!$stmt) {
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            exit();
        }

        // Flag to check if all inserts were successful
        $all_inserts_successful = true;

        // Iterate over the logs array and bind parameters for each entry
        foreach ($logs as $log) {
            // Ensure that both category and weight are set
            if (isset($log['category'], $log['weight'])) {
                $material_category = $log['category'];
                $weight_kg = $log['weight'];

                // Bind the parameters
                $stmt->bind_param("ssi", $company_name, $material_category, $weight_kg);

                // Execute the statement
                if (!$stmt->execute()) {
                    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $all_inserts_successful = false; // Mark as unsuccessful if any insert fails
                }
            }
        }

        // Close the statement
        $stmt->close();

        if ($all_inserts_successful) {
            // Set a session variable to indicate data has been collected
            $_SESSION['data_collected'] = true;

            // Redirect back to logs.php to refresh the data
            header("Location: logs.php");
            exit();
        } else {
            // Redirect with an error message
            header("Location: logs.php?error=1");
            exit();
        }
    } else {
        echo 'No logs provided or logs format is incorrect.';
    }
} else {
    echo 'Invalid request method.';
}

// Close the database connection
$conn->close();
?>
