<?php
// signup.php
include 'db_connection.php';

$errors = [];

// Fetch registered companies for the dropdown
$sql = "SELECT company_name, company_code FROM companies";
$result = $conn->query($sql);
$companies = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $companies[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user inputs
    $full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING);
    $contact_number = filter_input(INPUT_POST, 'contact_number', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $selected_company = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
    $company_code = filter_input(INPUT_POST, 'company_code', FILTER_SANITIZE_STRING);

    // Step 1: Validate if a company is selected or being registered
    if ($selected_company === "-- Select a company --" && $role !== 'admin') {
        $errors['company'] = "Please select a registered company or register a new one as an admin.";
    }

    // Validate passwords
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match.";
    }
    if (!preg_match('/[A-Z]/', $password) || 
        !preg_match('/[a-z]/', $password) || 
        !preg_match('/[0-9]/', $password) || 
        !preg_match('/[\W_]/', $password) || 
        strlen($password) < 8) {
        $errors['password'] = "Your password doesn't meet the said requirements.";
    }

    // Validate contact number
    if (!preg_match('/^\d{10}$/', $contact_number)) {
        $errors['contact_number'] = "Please enter the last 10 digits of your number.";
    } else {
        $contact_number = '+63' . $contact_number;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    }

    // Check if username or email already exists
    $fields = ['username', 'email'];
    foreach ($fields as $field) {
        $sql = "SELECT * FROM users WHERE $field = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $$field);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $errors[$field] = "This $field is already in use.";
        }
        $stmt->close();
    }

    // Step 3: For Admins, validate the company code
    if ($role === 'admin') {
        // Fetch the company details from the selected company
        $matched_company = array_filter($companies, function($company) use ($selected_company) {
            return $company['company_name'] === $selected_company;
        });
        
        if (empty($company_code)) {
            $errors['company_code'] = "Admin must provide a valid company code.";
        } elseif ($matched_company) {
            $matched_company = array_shift($matched_company);
            // Validate if company code matches the selected company's code
            if ($company_code !== $matched_company['company_code']) {
                $errors['company_code'] = "Invalid company code for the selected company.";
            }
        } else {
            $errors['company'] = "Selected company not found.";
        }
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // If the role is 'admin', handle company registration
        if ($role === 'admin') {
            if (empty($company_code)) {
                $errors['company_code'] = "Admin must provide a valid company code.";
            } else {
                $sql = "SELECT * FROM companies WHERE company_name = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $selected_company);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 0) {
                    $sql = "INSERT INTO companies (company_name, company_code) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $selected_company, $company_code);

                    if (!$stmt->execute()) {
                        $errors['company_code'] = "Failed to register company: " . $stmt->error;
                    }
                }
            }
        }

        // If no company registration errors, insert user data
        if (empty($errors)) {
            $sql = "INSERT INTO users (full_name, contact_number, email, username, password, role, company_name) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $full_name, $contact_number, $email, $username, $hashed_password, $role, $selected_company);

            if ($stmt->execute()) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                header("Location: signup_success.php");
                exit();
            } else {
                $errors['general'] = "Failed to create account. " . $stmt->error;
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - TrashTech</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        .container {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .left-section {
            flex: 1;
            padding: 20px;
        }
        .right-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        label, .error-message {
            display: block;
            margin: 10px 0;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: calc(100% - 40px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
        }
        .password-requirements {
            color: red;
            font-size: 14px;
        }
        .show-password {
            margin-bottom: 10px;
        }
        .contact-number-wrapper {
            display: flex;
            align-items: stretch;
        }
        .country-code {
            padding: 10px 12px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            font-weight: bold;
            height: 40px;
            text-align: center;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
        }
    </style>
    <script>
        function toggleCompanyCodeField() {
            const roleSelect = document.getElementById('role');
            const companyCodeField = document.getElementById('company_code_field');
            companyCodeField.style.display = roleSelect.value === 'admin' ? 'block' : 'none';
        }

        function togglePasswordVisibility() {
            const passwordField = document.querySelector('input[name="password"]');
            const confirmPasswordField = document.querySelector('input[name="confirm_password"]');
            const showPasswordCheckbox = document.querySelector('input[name="show_password"]');
            const type = showPasswordCheckbox.checked ? 'text' : 'password';
            passwordField.type = type;
            confirmPasswordField.type = type;
        }
    </script>
</head>
<body>

<div class="container">
    <div class="left-section">
        <h1>Sign Up</h1>

        <form method="post" action="signup.php">
            <label for="role">Role:</label>
            <span class="error-message"><?php echo $errors['role'] ?? ''; ?></span>
            <select name="role" id="role" onchange="toggleCompanyCodeField()" required>
                <option value="">-- Select your role --</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <label for="company">Company:</label>
            <span class="error-message"><?php echo $errors['company'] ?? ''; ?></span>
            <select name="company" id="company" required>
                <option>-- Select a company --</option>
                <?php foreach ($companies as $company): ?>
                    <option value="<?php echo $company['company_name']; ?>"><?php echo $company['company_name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="full_name">Full Name:</label>
            <span class="error-message"><?php echo $errors['full_name'] ?? ''; ?></span>
            <input type="text" name="full_name" placeholder="Enter your full name" required>

            <label for="contact_number">Contact Number:</label>
            <span class="error-message"><?php echo $errors['contact_number'] ?? ''; ?></span>
            <div class="contact-number-wrapper">
                <span class="country-code">+63</span>
                <input type="text" name="contact_number" maxlength="10" class="contact-number" placeholder="Last 10 digits only" required>
            </div>

            <label for="email">Email:</label>
            <span class="error-message"><?php echo $errors['email'] ?? ''; ?></span>
            <input type="email" name="email" placeholder="Enter your email address" required>

            <label for="username">Username:</label>
            <span class="error-message"><?php echo $errors['username'] ?? ''; ?></span>
            <input type="text" name="username" placeholder="Choose a username" required>

            <label for="password">Password:</label>
            <span class="error-message"><?php echo $errors['password'] ?? ''; ?></span>
            <input type="password" name="password" placeholder="Enter your password" required>
            <span class="password-requirements">Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one digit, and one special character.</span>

            <label for="confirm_password">Confirm Password:</label>
            <span class="error-message"><?php echo $errors['confirm_password'] ?? ''; ?></span>
            <input type="password" name="confirm_password" placeholder="Re-enter your password" required>

            <div class="show-password">
                <input type="checkbox" name="show_password" onclick="togglePasswordVisibility()"> Show Password
            </div>

            <div id="company_code_field" style="display: none;">
                <label for="company_code">Company Code (For Admin Only):</label>
                <input type="text" name="company_code" placeholder="Enter your company code">
                <span class="error-message"><?php echo $errors['company_code'] ?? ''; ?></span>
            </div>

            <input type="submit" value="Sign Up">
        </form>
    </div>
    <div class="right-section">
        <img src="images/Rectangle 1.png" alt="Sign Up">
    </div>
</div>

</body>
</html>
