<?php
include 'header.php';
include 'sidebar.php';
include 'db_connection.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// CSRF Token Generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Retrieve company_name based on the username
$query = "SELECT company_name FROM users WHERE username = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user_info = $result->fetch_assoc();

if (!$user_info) {
    echo "User not found.";
    exit();
}

$_SESSION['company_name'] = $user_info['company_name'];

// Fetch users by company
function fetchUsers($conn, $company_name) {
    $query = "SELECT * FROM users WHERE company_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $company_name);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

$errors = [];

// Password Validation Function
function validatePassword($password) {
    return strlen($password) >= 8 && strlen($password) <= 16 &&
           preg_match('/[A-Z]/', $password) &&
           preg_match('/[a-z]/', $password) &&
           preg_match('/[0-9]/', $password);
}

// Handle Create, Update, and Delete Actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid CSRF token.');
    }

    $action = $_POST['action'] ?? null;
    $userId = $_POST['user_id'] ?? null;
    $full_name = $_POST['full_name'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $company_name = $_POST['company_name'] ?? $_SESSION['company_name'];
    $company_address = $_POST['company_address'] ?? '';
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($full_name)) {
        $errors['full_name'] = "Full name is required.";
    }
    if (!preg_match('/^\d{10}$/', $contact_number)) {
        $errors['contact_number'] = "Contact number must be exactly 10 digits.";
    }
    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }
    if ($action !== 'delete' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }
    if ($role != 'admin' && !validatePassword($password)) {
        $errors['password'] = "Password must be 8-16 characters and include uppercase, lowercase, and a number.";
    }
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    // Process actions if no errors
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if ($action === 'create_user') {
            $sql = "INSERT INTO users (full_name, contact_number, username, email, password, company_name, company_address, role) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss", $full_name, $contact_number, $username, $email, 
                              $hashed_password, $company_name, $company_address, $role);
            $stmt->execute();
            echo "New user created successfully.";
        } elseif ($action === 'update') {
            $sql = "UPDATE users SET full_name=?, contact_number=?, username=?, email=?, company_name=?, 
                    company_address=?, role=?, password=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssi", $full_name, $contact_number, $username, $email, 
                              $company_name, $company_address, $role, $hashed_password, $userId);
            $stmt->execute();
            echo "User updated successfully.";
        } elseif ($action === 'delete') {
            $sql = "DELETE FROM users WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            echo "User deleted successfully.";
        }
    }
}

$users = fetchUsers($conn, $_SESSION['company_name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .toggle-password {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="content">
        <h1>Manage Users</h1>

        <!-- User Creation Form -->
        <form method="POST" action="manage_users.php">
            <h2>Create User</h2>
            <input type="hidden" name="action" value="create_user">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <!-- Form Fields -->
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" placeholder="Enter the user's full name" required>
            <div class="error"><?= $errors['full_name'] ?? '' ?></div>

            <label for="contact_number">Contact Number:</label>
            <div class="contact-number-wrapper">
                <span class="country-code">+63</span>
                <input type="text" name="contact_number" maxlength="10" placeholder="Enter the last 10-digits of your contact number" required>
            </div>
            <div class="error"><?= $errors['contact_number'] ?? '' ?></div>

            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Enter a username" required>
            <div class="error"><?= $errors['username'] ?? '' ?></div>

            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Enter the user's email address" required>
            <div class="error"><?= $errors['email'] ?? '' ?></div>

            <label for="password">Password:</label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="Enter a password" required>
                <input type="checkbox" class="toggle-password" onclick="togglePassword('password')"> Show
            </div>
            <div class="error"><?= $errors['password'] ?? '' ?></div>

            <label for="confirm_password">Confirm Password:</label>
            <div class="password-wrapper">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Re-enter the password" required>
                <input type="checkbox" class="toggle-password" onclick="togglePassword('confirm_password')"> Show
            </div>
            <div class="error"><?= $errors['confirm_password'] ?? '' ?></div>

            <label for="role">Role:</label>
            <select name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Create User</button>
        </form>

        <!-- Users Table -->
        <h2>Existing Users</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Contact</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['full_name']) ?></td>
                        <td><?= htmlspecialchars($user['contact_number']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td>
                            <button type="button" onclick="confirmDelete(<?= $user['id'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'manage_users.php';
                form.innerHTML = `
                    <input type="hidden" name="user_id" value="${userId}">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function togglePassword(inputId) {
            const inputField = document.getElementById(inputId);
            if (inputField.type === "password") {
                inputField.type = "text";
            } else {
                inputField.type = "password";
            }
        }
    </script>
</body>
</html>
