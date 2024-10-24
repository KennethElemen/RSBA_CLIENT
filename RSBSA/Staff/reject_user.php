<?php
// reject_user.php

// Include the database connection
include '../includes/dbconn.php';

// Ensure the content type is set to JSON
header('Content-Type: application/json');

// Create a connection to the database
$dbConnection = new mysqli($servername, $username, $password, $dbname);
if ($dbConnection->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $dbConnection->connect_error]);
    exit();
}

// Check if user_id is set in POST request
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    try {
        // Start a transaction
        $dbConnection->begin_transaction();

        // Delete records from dependent tables
        $sql = "DELETE FROM Addresses WHERE user_id = ?";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $sql = "DELETE FROM Crops WHERE user_id = ?";
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Delete from useraccounts and Users table
        $sql = "DELETE FROM useraccounts WHERE user_id = ?";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $sql = "DELETE FROM Users WHERE user_id = ?";
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Commit transaction
        $dbConnection->commit();

        // Return success response
        echo json_encode(['success' => true, 'message' => 'User rejected successfully.']);
    } catch (Exception $e) {
        // Rollback in case of error
        $dbConnection->rollback();
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    // Return error if no user ID was sent
    echo json_encode(['success' => false, 'message' => 'No user ID provided.']);
}
?>
