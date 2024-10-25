<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include '../includes/dbconn.php';

// Check if the email and ID are set in the POST request
if (isset($_POST['email']) && isset($_POST['id'])) {
    $newEmail = $_POST['email'];
    $user_id = (int)$_POST['id']; // Cast to integer for safety

    // Create a new database connection
    $dbConnection = new mysqli($servername, $username, $password, $dbname);
    if ($dbConnection->connect_error) {
        die(json_encode(['status' => 'error', 'message' => 'Database connection failed.']));
    }

    // Prepare the SQL statement
    $stmt = $dbConnection->prepare("UPDATE useraccounts SET email = ? WHERE user_id = ?");
    $stmt->bind_param("si", $newEmail, $user_id); // "si" means string and integer

    // Execute the statement
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Email updated successfully
            echo json_encode(['status' => 'success', 'message' => 'Email updated successfully.']);
        } else {
            // No rows affected (email may not have changed)
            echo json_encode(['status' => 'error', 'message' => 'No changes made to the email.']);
        }
    } else {
        // Query execution error
        echo json_encode(['status' => 'error', 'message' => 'Failed to update email.']);
    }

    // Close the statement and connection
    $stmt->close();
    $dbConnection->close();
} else {
    // Missing email or ID
    echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
}
?>
