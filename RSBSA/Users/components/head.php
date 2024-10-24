<head>

<?php
// Include the session checking function
require_once('../includes/check_session.php');


checkSession($conn, ['user']);

// Fetch the user_id from the session
$user_id = $_SESSION['user_id']; // Adjust according to your session variable

// Prepare and execute the query to fetch the profile_picture
$query = "SELECT profile_picture FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id); // Assuming user_id is an integer
$stmt->execute();
$result = $stmt->get_result();

// Check if a result is returned
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $profile_picture = $row['profile_picture'];
} else {
    $profile_picture = '../assets/images/default_user.png'; // Default image if no picture found
}

// Close the statement and connection
$stmt->close();
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
    <link rel="shortcut icon" href="favicon.ico"> 
  

    <!-- FontAwesome JS-->
    <script  src="../assets/plugins/fontawesome/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="../assets/css/portal.css">
    <script src="//code.tidio.co/whhoiinc3ptom2zrpyvxytjiw5k5skbj.js" async></script>
</head> 