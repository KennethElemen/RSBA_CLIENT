<?php
    session_start(); // Start the session

    // Unset only the session variables related to the user
    unset($_SESSION['user_id']);  // Assuming 'user_id' is the session variable for logged-in user
    unset($_SESSION['username']); // Unset other relevant session variables like 'username'

    // Optionally, you can add any other session variable that should be cleared

    // Redirect to the login page
    header("Location: ../Public/login.php");
    exit(); // Ensure the script ends here
?>
