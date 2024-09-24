<?php
session_start(); // Start the session
// Include database connection
require_once('dbconn.php');
// Database connection
$dbConnection = new mysqli('host', 'username', 'password', 'database');

// Check connection
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve the user input
    $email = $dbConnection->real_escape_string($_POST['email']);
    $password = $_POST['password']; // We'll hash and check this later

    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT * FROM UserAccounts WHERE email = '$email'";
    $result = $dbConnection->query($sql);

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user data in session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Role-based redirection
            switch ($user['role']) {
                case 'admin':
                    header("Location: ../Admin/index.php");
                    exit();
                case 'staff':
                    header("Location: ../Staff/index.php");
                    exit();
                case 'user':
                    header("Location: ../users/index.php");
                    exit();
                default:
                    header("Location: ../../Public/login.php");
                    exit();
            }
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "No account found with that email address.";
    }
}

// Close the database connection
$dbConnection->close();
?>
