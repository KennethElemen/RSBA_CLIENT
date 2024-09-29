<?php
include '../includes/dbconn.php';

$dbConnection = new mysqli($servername, $username, $password, $dbname);
if ($dbConnection->connect_error) {
    die(json_encode(['success' => false, 'message' => "Connection failed: " . $dbConnection->connect_error]));
}

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Begin transaction to ensure atomicity
    $dbConnection->begin_transaction();

    // First, delete from the dependent tables
    $sql = "DELETE FROM Addresses WHERE user_id = ?";
    $stmt = $dbConnection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $sql = "DELETE FROM Crops WHERE user_id = ?";
    $stmt = $dbConnection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $sql = "DELETE FROM Contacts WHERE user_id = ?";
    $stmt = $dbConnection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $sql = "DELETE FROM JobRoles WHERE user_id = ?";
    $stmt = $dbConnection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Now delete from the parent tables
    $sql = "DELETE FROM useraccounts WHERE user_id = ?";
    $stmt = $dbConnection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $sql = "DELETE FROM Users WHERE user_id = ?";
    $stmt = $dbConnection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Commit the transaction
    $dbConnection->commit();

    // Close the statement and connection
    $stmt->close();
    $dbConnection->close();

    // Return success response
    echo json_encode(['success' => true, 'message' => 'User rejected successfully.']);
    exit();
} else {
    echo json_encode(['success' => false, 'message' => "No user ID provided."]);
}
?>
