<?php
include '../includes/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    
    // Ensure the required data is received
    if (isset($user_id)) {
        // Prepare and execute the query to update the account status to 'accepted'
        $stmt = $dbConnection->prepare("UPDATE useraccounts SET accountStatus = 'accepted' WHERE user_id = ?");
        $stmt->bind_param('i', $user_id);

        if ($stmt->execute()) {
            // Status successfully updated
            echo 'success';
        } else {
            // Error executing the query
            echo 'error';
        }

        $stmt->close();
        $dbConnection->close();
    } else {
        echo 'invalid data';
    }
} else {
    echo 'invalid request';
}
?>
