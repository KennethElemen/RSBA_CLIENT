<?php
session_start();

// Include database connection
require_once('dbconn.php');

// Function to check user session and role
function checkSession($conn, $allowedRoles = []) {
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Prepare and bind
        $stmt = $conn->prepare("SELECT role FROM useraccounts WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        
        // Execute the statement
        $stmt->execute();
        
        // Store result
        $stmt->store_result();
        
        // Check if user exists
        if ($stmt->num_rows > 0) {
            // Bind result variable
            $stmt->bind_result($role);
            $stmt->fetch();

            // Check if the user's role is allowed
            if (in_array($role, $allowedRoles)) {
                return; // User has the required role
            } else {
                // User doesn't have permission, redirect based on role
                header("Location: ../Public/login.php"); // Redirect to login or a no access page
                exit();
            }
        } else {
            // User not found, redirect to login page
            header("Location: ../Public/login.php"); 
            exit();
        }

        // Close statement
        $stmt->close();
    } else {
        // No session found, redirect to login page
        header("Location: ../Public/login.php"); 
        exit();
    }
}
?>
