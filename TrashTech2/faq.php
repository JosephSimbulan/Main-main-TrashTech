<?php
// faq.php
include 'db_connection.php';
include 'header.php';  // Include the header.php to maintain the header layout
include 'sidebar.php'; // Include sidebar.php to ensure the sidebar is rendered
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM faqs";
$result = $conn->query($sql);

$page_title = "FAQ Page";

$page_content = '
    <h1>FAQs</h1>
    <div class="faq-container">';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $page_content .= '
            <div class="faq-item">
                <div class="faq-question">
                    <strong>' . htmlspecialchars($row['question']) . '</strong>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">' . htmlspecialchars($row['answer']) . '</div>
            </div>';
    }
} else {
    $page_content .= '<p>No FAQs found.</p>';
}

$page_content .= '
    </div>';

?>

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
        margin-left: 20px; /* Align h1 beside the sidebar */
        margin-bottom: 30px; /* Add space below the header */
    }

    .faq-container {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .faq-item {
        margin-bottom: 15px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
    }

    .faq-question {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        transition: background-color 0.3s ease;
    }

    .faq-question:hover {
        background-color: #e9e9e9;
    }

    .faq-toggle {
        font-size: 20px;
        font-weight: bold;
        transition: transform 0.3s ease;
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: max-height 0.3s ease, opacity 0.3s ease;
        margin-top: 10px;
        font-size: 16px;
        padding: 10px 15px;
        background-color: #f4f4f4;
        border-radius: 5px;
    }

    .faq-answer.active {
        max-height: 500px; /* Allow larger space for content */
        opacity: 1;
    }

    @media (max-width: 600px) {
        #content {
            margin-left: 0;
            width: 100%;
            padding: 10px;
        }
        .faq-container {
            padding: 10px;
        }
    }
</style>

<!-- Link the external JavaScript file -->
<script src="faq.js"></script>

<?php
// Output the page content
echo $page_content;
?>
