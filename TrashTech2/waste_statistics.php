<?php
// waste_statistics.php
include 'db_connection.php';
include 'header.php'; // Include the header file for the page
include 'sidebar.php'; // Include the sidebar file for the page

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['user_id'])) {
    echo "User ID is not set in the session.";
    exit();
}

// Get company name from session
$company_name = $_SESSION['company_name'];

// Get the current year
$current_year = date("Y");

function getTallies($conn, $company_name, $current_year) {
    $categories = ['paper', 'plastic', 'metal', 'glass'];
    $tallies = [];

    foreach ($categories as $category) {
        $sql = "SELECT MONTH(timestamp) AS month, SUM(weight) AS total_weight 
                FROM {$category}_weight 
                WHERE company_name = ? AND YEAR(timestamp) = ?
                GROUP BY MONTH(timestamp)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $company_name, $current_year);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Initialize totals for the current year
        $category_totals = array_fill(0, 12, 0);

        while ($row = $result->fetch_assoc()) {
            $month_index = (int)$row['month'] - 1; // Convert to zero-based index
            $category_totals[$month_index] = (float)$row['total_weight'];
        }
        
        // Store the totals in the tallies array
        $tallies[$category] = $category_totals;
    }

    return $tallies;
}

// Check if it's an AJAX request
if (isset($_GET['action']) && $_GET['action'] === 'fetch_data') {
    // Get the latest tallies
    $tallies = getTallies($conn, $company_name, $current_year);

    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($tallies);
    exit();
}

// Initial data fetch for the charts
$tallies = getTallies($conn, $company_name, $current_year);

$page_title = "Waste Statistics Page";

?>

<style>
    /* General page and body styling */
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: Arial, sans-serif;
        box-sizing: border-box;
    }

    /* Content section (where the charts are displayed) */
    #content {
        margin-left: 280px;
        margin-top: 30px;
        padding: 20px;
        background: linear-gradient(135deg, #D187F5, #FFFFFF);
        height: calc(100vh - 80px);
        overflow-y: auto;
        box-sizing: border-box;
    }

    /* Chart containers styling */
    .chart-vertical-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding-top: 20px;
    }

    .chart-container {
        position: relative;
        height: 400px;
        width: 100%;
    }

    /* Ensures charts scale correctly */
    .chart-container canvas {
        max-height: 100%;
        max-width: 100%;
    }

    /* Heading styling for waste statistics */
    h1 {
        margin-top: 0;
        font-size: 2rem;
        text-align: left;
        padding-left: 10px;
    }
</style>

<!-- Content Section -->
<div id="content">
    <h1>Waste Statistics</h1>
    <div class="chart-vertical-container">
        <div class="chart-container">
            <canvas id="paperChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="plasticChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="metalChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="glassChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctxs = {
            paper: document.getElementById("paperChart").getContext("2d"),
            plastic: document.getElementById("plasticChart").getContext("2d"),
            metal: document.getElementById("metalChart").getContext("2d"),
            glass: document.getElementById("glassChart").getContext("2d")
        };

        let charts = {};

        function createChart(ctx, label, data) {
            return new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: label + " (kgs)", // Add " (kgs)" to the label
                        data: data,
                        backgroundColor: "#D187F5",
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: "#333333",
                                font: {
                                    family: "Arial, Helvetica, sans-serif",
                                    size: 12
                                },
                                callback: function(value) {
                                    return value + ' kgs'; // Append "kgs" to y-axis labels
                                }
                            },
                            grid: {
                                color: "rgba(0, 0, 0, 0.1)"
                            }
                        },
                        x: {
                            ticks: {
                                color: "#333333",
                                font: {
                                    family: "Arial, Helvetica, sans-serif",
                                    size: 12
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            padding: 10,
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.dataset.label + ': ' + tooltipItem.raw + ' kgs'; // Append "kgs" to tooltip
                                }
                            }
                        }
                    }
                }
            });
        }

        // Initial chart rendering
        function renderCharts(tallies) {
            charts.paper = createChart(ctxs.paper, "Paper", tallies.paper);
            charts.plastic = createChart(ctxs.plastic, "Plastic", tallies.plastic);
            charts.metal = createChart(ctxs.metal, "Metal", tallies.metal);
            charts.glass = createChart(ctxs.glass, "Glass", tallies.glass);
        }

        // Fetch updated data from the server
        function fetchData() {
            fetch("waste_statistics.php?action=fetch_data")
                .then(response => response.json())
                .then(data => {
                    // Update chart data
                    charts.paper.data.datasets[0].data = data.paper;
                    charts.plastic.data.datasets[0].data = data.plastic;
                    charts.metal.data.datasets[0].data = data.metal;
                    charts.glass.data.datasets[0].data = data.glass;

                    // Re-render charts
                    charts.paper.update();
                    charts.plastic.update();
                    charts.metal.update();
                    charts.glass.update();
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Initial render
        renderCharts(<?php echo json_encode($tallies); ?>);

        // Fetch new data every 30 seconds
        setInterval(fetchData, 30000);
    </script>
</div>
