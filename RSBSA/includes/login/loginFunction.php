<?php
session_start(); // Start the session

include '../includes/dbconn.php';
// Database connection
$dbConnection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve the user input
    $email = $dbConnection->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT * FROM UserAccounts WHERE email = '$email'";
    $result = $dbConnection->query($sql);

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if account is pending
        if ($user['accountStatus'] == 'pending') {
            echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Account Pending',
                    text: 'Your account is still pending. Please wait for approval.',
                });
            </script>";
        } else {
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
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: 'Invalid password. Please try again.',
                    });
                </script>";
            }
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: 'No account found with that email address.',
            });
        </script>";
    }
}

// Close the database connection
$dbConnection->close();
?>
