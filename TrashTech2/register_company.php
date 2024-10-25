<?php
include 'db_connection.php'; // Ensure this file connects to the database
session_start();

// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and collect input data
    $company_name = filter_input(INPUT_POST, 'company_name', FILTER_SANITIZE_STRING);
    $owner_names = $_POST['owner_names'];  // Array of owner names
    $company_address = filter_input(INPUT_POST, 'company_address', FILTER_SANITIZE_STRING);
    $business_type = filter_input(INPUT_POST, 'business_type', FILTER_SANITIZE_STRING);
    $phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);
    $email_address = filter_input(INPUT_POST, 'email_address', FILTER_VALIDATE_EMAIL);
    $number_of_employees = filter_input(INPUT_POST, 'number_of_employees', FILTER_VALIDATE_INT);
    $contact_person_name = filter_input(INPUT_POST, 'contact_person_name', FILTER_SANITIZE_STRING);
    $contact_person_phone = filter_input(INPUT_POST, 'contact_person_phone', FILTER_SANITIZE_STRING);
    $terms_accepted = isset($_POST['terms_accepted']) ? 1 : 0;

    // Validation
    if (!$email_address || !$terms_accepted) {
        die('Please ensure all fields are filled and you have accepted the terms.');
    }

    // Convert owner names array to JSON
    $owner_names_json = json_encode($owner_names);

    // Generate a unique company code
    $company_code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO companies 
        (company_name, owner_names, company_address, business_type, phone_number, email_address, number_of_employees, contact_person_name, contact_person_phone, company_code, terms_accepted) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("sssssssssss", $company_name, $owner_names_json, $company_address, $business_type, $phone_number, $email_address, $number_of_employees, $contact_person_name, $contact_person_phone, $company_code, $terms_accepted);

    if ($stmt->execute()) {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'trashtechphilippines@gmail.com'; // Gmail address
            $mail->Password = 'esoz ozck akes zqdw'; // Generated app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('trashtechphilippines@gmail.com', 'TrashTech Support');
            $mail->addAddress($email_address); // Add the recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Company Registration Code';
            $mail->Body = "
                <p>Dear $company_name,</p>
                <p>Your company has been successfully registered! Your unique company code is: <strong>$company_code</strong>.</p>
                <p>Please keep this code safe for your records.</p>
                <p>Thank you!</p>
            ";

            // Send the email
            $mail->send();

            // Redirect to success page with the company name in query parameters
            header("Location: register_success.php?company_name=" . urlencode($company_name));
            exit();
        } catch (Exception $e) {
            echo 'Error sending email: ' . $mail->ErrorInfo; // Display error if email fails
        }
    } else {
        echo "Error: " . $stmt->error; // Show error if SQL execution fails
    }

    $stmt->close(); // Close the statement
    $conn->close(); // Close the connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Company</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="email"], input[type="tel"], input[type="number"], textarea, select {
            padding: 10px;
            margin-bottom: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #7C3AED;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #5a2ea6;
        }
        .owners-list {
            margin-bottom: 10px;
        }
        .terms {
            display: flex;
            align-items: center;
        }
        .terms a {
            margin-left: 5px;
            color: #7C3AED;
        }
    </style>
    <script>
        function addOwnerField() {
            const ownersList = document.getElementById('owners-list');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'owner_names[]';
            input.placeholder = 'Owner\'s Name';
            input.required = true;
            ownersList.appendChild(input);
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Register Your Company</h2>
        <form method="POST" action="register_company.php">
            <label for="company_name">Company Name</label>
            <input type="text" name="company_name" placeholder="Enter your company name" required>

            <label for="owner_names">Owner/s Name/s</label>
            <div id="owners-list" class="owners-list">
                <input type="text" name="owner_names[]" placeholder="Owner's Name" required>
            </div>
            <button type="button" onclick="addOwnerField()">Add More Owners</button>

            <label for="company_address">Company Address</label>
            <textarea name="company_address" placeholder="Enter your company address" required></textarea>

            <label for="business_type">Business Type</label>
            <select name="business_type" required>
                <option value="LLC">LLC</option>
                <option value="Corporation">Corporation</option>
                <option value="Partnership">Partnership</option>
                <option value="Sole Proprietorship">Sole Proprietorship</option>
                <option value="Non-Profit">Non-Profit</option>
            </select>

            <label for="phone_number">Phone Number</label>
            <input type="tel" name="phone_number" placeholder="Enter the last 10 digits of your phone number" required>

            <label for="email_address">Email Address</label>
            <input type="email" name="email_address" placeholder="Enter your email address" required>

            <label for="number_of_employees">Number of Employees</label>
            <input type="number" name="number_of_employees" placeholder="Enter the number of employees" required>

            <label for="contact_person_name">Contact Person's Name</label>
            <input type="text" name="contact_person_name" placeholder="Enter the contact person's name" required>

            <label for="contact_person_phone">Contact Person's Phone</label>
            <input type="tel" name="contact_person_phone" placeholder="Enter the contact person's phone number" required>

            <div class="terms">
                <input type="checkbox" name="terms_accepted" required>
                <label for="terms_accepted">I agree to the <a href="terms_conditions.php" target="_blank">Terms and Conditions</a></label>
            </div>

            <input type="submit" value="Register Company">
        </form>
    </div>
</body>
</html>
