<?php
// fetch_company_code.php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_name = filter_input(INPUT_POST, 'company_name', FILTER_SANITIZE_STRING);

    $sql = "SELECT company_code FROM companies WHERE company_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $company_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $company = $result->fetch_assoc();
        echo json_encode(['success' => true, 'company_code' => $company['company_code']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Company not found']);
    }
}
?>
