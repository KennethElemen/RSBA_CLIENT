
    

<?php

include '../dbconn.php';

$dbConnection = new mysqli($servername, $username, $password, $dbname);
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

// Ensure the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'You must be logged in to post an announcement!',a
        }).then(() => {
            window.location.href = 'login.php'; // Redirect to login
        });
    </script>";
    exit;
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID

// Validate that the user is admin or staff
$checkRoleQuery = "SELECT role FROM useraccounts WHERE user_id = ?";
$stmt = $dbConnection->prepare($checkRoleQuery);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !in_array($user['role'], ['admin', 'staff'])) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Unauthorized',
            text: 'You are not authorized to post announcements!',
        }).then(() => {
            window.location.href = 'dashboard.php'; // Redirect to dashboard
        });
    </script>";
    exit;
}

// Handle form data
$title = mysqli_real_escape_string($dbConnection, $_POST['title']);
$content = mysqli_real_escape_string($dbConnection, $_POST['content']);
$expiration_date = !empty($_POST['expiration_date']) ? $_POST['expiration_date'] : NULL;
$attachment_url = NULL;

// Handle file upload
if (!empty($_FILES['attachment']['name'])) {
    $target_dir = "../../assets/images/announcement/";  // Updated directory
    $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allow certain file formats
    $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
    if (!in_array($fileType, $allowedTypes)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid File Type',
                text: 'Only JPG, JPEG, PNG, and PDF files are allowed!',
            });
        </script>";
        exit;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["attachment"]["size"] > 5000000) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'File Too Large',
                text: 'Your file is too large (limit 5MB).',
            });
        </script>";
        exit;
    }

    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
        $attachment_url = $target_file; // Save the file URL to the database
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Upload Error',
                text: 'There was an error uploading your file.',
            });
        </script>";
        exit;
    }
}

// Insert the announcement into the database
$insertQuery = "INSERT INTO announcements (title, content, expiration_date, status, attachment_url, posted_by, role) 
                VALUES (?, ?, ?, 'active', ?, ?, ?)";
$stmt = $dbConnection->prepare($insertQuery);
$stmt->bind_param('ssssss', $title, $content, $expiration_date, $attachment_url, $user_id, $user['role']);

if ($stmt->execute()) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Announcement posted successfully!',
        }).then(() => {
            window.location.href = 'announcements.php'; // Redirect to announcements page
        });
    </script>";
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Database Error',
            text: 'Error: {$stmt->error}',
        });
    </script>";
}

// Close the connection
$stmt->close();
$dbConnection->close();
?>
