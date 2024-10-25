<head>

<?php
// Include the session checking function
require_once('../includes/check_session.php');

checkSession($conn, ['user']);

// Fetch the user_id from the session
$user_id = $_SESSION['user_id']; // Adjust according to your session variable

// Prepare and execute the query to fetch first_name and profile_picture
$query = "SELECT first_name, profile_picture FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id); // Assuming user_id is an integer
$stmt->execute();
$result = $stmt->get_result();

// Initialize variables
$first_name = '';
$profile_picture = '../assets/images/default_user.png'; // Default image if no picture found

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    $profile_picture = $row['profile_picture'];
}
$stmt->close();

// Query to fetch the latest announcement
$announcement_text = 'No announcements available.';
$announcement_query = "SELECT content FROM announcements ORDER BY created_at DESC LIMIT 1"; // Assuming 'created_at' or similar timestamp column exists
$announcement_result = $conn->query($announcement_query);

if ($announcement_result->num_rows > 0) {
    $announcement_row = $announcement_result->fetch_assoc();
    $announcement_text = $announcement_row['content'];
}

// Close the connection
$conn->close();
?>

    <title>Agriland</title>
    
    <!-- Meta -->
       <!-- Meta -->
       <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="Agriland">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="../assets/finallogo.jpg"> 
  

    <!-- FontAwesome JS-->
    <script  src="../assets/plugins/fontawesome/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="../assets/css/portal.css">
    <script src="//code.tidio.co/whhoiinc3ptom2zrpyvxytjiw5k5skbj.js" async></script>
</head> 