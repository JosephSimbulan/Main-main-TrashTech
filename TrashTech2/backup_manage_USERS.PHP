<?php
include 'header.php';
include 'sidebar.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connection.php'; // Ensure the database connection is included

// Ensure session_start() is only called once
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if it's not already started
}

// Check if user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Retrieve company_name based on the username
$query = "SELECT company_name FROM users WHERE username = ? LIMIT 1"; // Use ? for mysqli
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user_info = $result->fetch_assoc();

// Check if user information is retrieved successfully
if ($user_info) {
    $_SESSION['company_name'] = $user_info['company_name']; // Store company_name in session
} else {
    echo "User not found.";
    exit();
}

// Function to fetch users based on company_name
function fetchUsers($conn, $company_name) {
    $query = "SELECT * FROM users WHERE company_name = ?"; // Use ? for mysqli
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $company_name);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Initialize error messages array
$errors = [];

// Function to validate password
function validatePassword($password) {
    return strlen($password) >= 8 && strlen($password) <= 16 &&
           preg_match('/[A-Z]/', $password) &&
           preg_match('/[a-z]/', $password) &&
           preg_match('/[0-9]/', $password);
}

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? null;
    $userId = $_POST['user_id'] ?? null; // Single user ID for update/delete

    // Handle user create/update/delete actions
    if (isset($_POST['create_user']) || ($action === 'update' || $action === 'delete')) {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $company_name = $_POST['company_name'] ?? $_SESSION['company_name']; // Use session company name for new user
        $company_address = $_POST['company_address'] ?? '';
        $role = $_POST['role'] ?? '';
        $password = $_POST['password'] ?? '';

        // Basic validation
        if (empty($username)) {
            $errors['username'] = "Username is required.";
        }

        // Skip email validation if deleting a user
        if ($action !== 'delete' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }

        if ($role != 'admin' && !validatePassword($password)) {
            $errors['password'] = "Password must be between 8-16 characters and include an uppercase letter, a lowercase letter, and a number.";
        }

        // Only proceed if there are no errors
        if (empty($errors)) {
            // Hash the password only if creating/updating
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            if (isset($_POST['create_user'])) {
                // Insert new user into the database
                $sql = "INSERT INTO users (username, email, password, company_name, company_address, role) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $username, $email, $hashed_password, $company_name, $company_address, $role);
                $stmt->execute();
                echo "New user created successfully";
            } elseif ($action === 'update') {
                // Update existing user
                $sql = "UPDATE users SET username=?, email=?, company_name=?, company_address=?, role=?, password=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssi", $username, $email, $company_name, $company_address, $role, $hashed_password, $userId);
                $stmt->execute();
                echo "User updated successfully";
            } elseif ($action === 'delete') {
                // Delete user
                $sql = "DELETE FROM users WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                echo "User deleted successfully";
            }
        }
    }
}

// Fetch users for the logged-in admin's company
$users = fetchUsers($conn, $_SESSION['company_name']);

$page_title = "Manage Users";
$page_content = '
    <h1>Manage Users</h1>
    <div class="form-container">
        <form method="POST" action="manage_users.php">
            <h2>Create User</h2>
            <label for="username">Username</label>
            <input type="text" name="username" value="" placeholder="Enter username">
            <div class="error">' . ($errors['username'] ?? '') . '</div>
            
            <label for="email">Email</label>
            <input type="email" name="email" value="" placeholder="Enter email">
            <div class="error">' . ($errors['email'] ?? '') . '</div>
            
            <label for="password">Password</label>
            <input type="password" name="password" value="" placeholder="Enter password">
            <div class="error">' . ($errors['password'] ?? '') . '</div>
            
            <label for="role">Role</label>
            <select name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            
            <button type="submit" name="create_user">Create User</button>
        </form>
    </div>';

$page_content .= '
    <h2>Existing Users</h2>
    <form id="userForm" method="POST" action="manage_users.php">
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Company Name</th>
                <th>Company Address</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>';

foreach ($users as $row) {
    $page_content .= '
        <tr>
            <td>
                <input type="text" name="username[]" value="' . htmlspecialchars($row['username']) . '" class="input-field">
                <div class="error">' . ($errors['username'] ?? '') . '</div>
            </td>
            <td>
                <input type="email" name="email[]" value="' . htmlspecialchars($row['email']) . '" class="input-field">
                <div class="error">' . ($errors['email'] ?? '') . '</div>
            </td>
            <td>
                <input type="text" name="company_name[]" value="' . htmlspecialchars($row['company_name']) . '" class="input-field">
            </td>
            <td>
                <input type="text" name="company_address[]" value="' . htmlspecialchars($row['company_address']) . '" class="input-field">
            </td>
            <td>
                <select name="role[]" class="input-field">
                    <option value="user" ' . ($row['role'] == 'user' ? 'selected' : '') . '>User</option>
                    <option value="admin" ' . ($row['role'] == 'admin' ? 'selected' : '') . '>Admin</option>
                </select>
            </td>
            <td>
                <button type="button" onclick="updateUser(' . $row['id'] . ', \'' . htmlspecialchars($row['username']) . '\', \'' . htmlspecialchars($row['email']) . '\', \'' . htmlspecialchars($row['company_name']) . '\', \'' . htmlspecialchars($row['company_address']) . '\', \'' . $row['role'] . '\')">Update</button>
                <button type="button" onclick="confirmDelete(' . $row['id'] . ')">Delete</button>
            </td>
        </tr>';
}

$page_content .= '</table></form>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="content">
        <?= $page_content ?>
    </div>
</body>
</html>

<script>
function updateUser(userId, username, email, companyName, companyAddress, role) {
    const form = document.getElementById('userForm');
    form.action = 'manage_users.php';
    form.method = 'POST';

    // Clear any existing hidden inputs to prevent duplicates
    form.querySelectorAll('input[type="hidden"]').forEach(input => input.remove());

    // Create hidden inputs for the update action
    const inputUserId = document.createElement('input');
    inputUserId.type = 'hidden';
    inputUserId.name = 'user_id';
    inputUserId.value = userId;

    const inputAction = document.createElement('input');
    inputAction.type = 'hidden';
    inputAction.name = 'action';
    inputAction.value = 'update';

    // Append hidden inputs
    form.appendChild(inputUserId);
    form.appendChild(inputAction);

    // Populate the fields with the current user data
    form.username.value = username;
    form.email.value = email;
    form.company_name.value = companyName;
    form.company_address.value = companyAddress;
    form.role.value = role;

    // Submit the form
    form.submit();
}

function confirmDelete(userId) {
    if (confirm("Are you sure you want to delete this user?")) {
        const form = document.getElementById('userForm');
        const inputUserId = document.createElement('input');
        inputUserId.type = 'hidden';
        inputUserId.name = 'user_id';
        inputUserId.value = userId;

        const inputAction = document.createElement('input');
        inputAction.type = 'hidden';
        inputAction.name = 'action';
        inputAction.value = 'delete';

        // Append hidden inputs
        form.appendChild(inputUserId);
        form.appendChild(inputAction);

        // Submit the form
        form.submit();
    }
}
</script>
