<?php
include '../dbconn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];

    // Create a new mysqli connection
    $dbConnection = new mysqli($servername, $username, $password, $dbname);
    if ($dbConnection->connect_error) {
        die("Connection failed: " . $dbConnection->connect_error);
    }

    // Fetch the current accountStatus
    $fetchStatusQuery = "SELECT accountStatus FROM useraccounts WHERE user_id = ?";
    $stmt = $dbConnection->prepare($fetchStatusQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($currentStatus);
    $stmt->fetch();
    $stmt->close();

    // Determine the new status based on the current status
    $newStatus = ($currentStatus == 'accepted') ? 'Pending' : 'accepted';

    // Update the accountStatus
    $updateUserQuery = "UPDATE useraccounts SET accountStatus = ? WHERE user_id = ?";
    $stmt = $dbConnection->prepare($updateUserQuery);
    $stmt->bind_param("si", $newStatus, $user_id);
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $dbConnection->close();

    echo json_encode(["status" => "success", "newStatus" => $newStatus]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
