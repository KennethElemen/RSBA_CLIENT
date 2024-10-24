<!DOCTYPE html>
<html lang="en"> 

 

	<?php include 'components/head.php'; ?>
<body class="app">   	
    

	<?php include 'components/header.php'; ?>
    
    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <h1 class="app-page-title">My Account</h1>
				<?php

include '../includes/dbconn.php';

$dbConnection = new mysqli($servername, $username, $password, $dbname);
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

// Now you can fetch the user account details for the current user
$query = "SELECT 
            ua.user_id, 
            ua.email, 
            ua.accountStatus, 
            ua.account_id,
            u.first_name,
            u.middle_name,
            u.sur_name,
            u.date_of_birth,
            u.sex,
            u.birth_municipality,
            u.birth_province,
            u.profile_picture,
            MAX(a.region) AS region, 
            MAX(a.province) AS province, 
            MAX(a.city_municipality) AS city_municipality, 
            MAX(a.barangay) AS barangay, 
            MAX(a.street_number) AS street_number, 
            MAX(a.purok) AS purok, 
            MAX(c.crop_name) AS crop_name, 
            MAX(c.crop_area_hectares) AS crop_area_hectares, 
            MAX(c.benefits) AS benefits, 
            MAX(c.reference) AS reference, 
            MAX(j.job_role) AS job_role, 
            MAX(co.phone_number) AS phone_number
        FROM 
            useraccounts ua
        JOIN 
            Users u ON ua.user_id = u.user_id
        LEFT JOIN 
            Addresses a ON ua.user_id = a.user_id    
        LEFT JOIN 
            Crops c ON ua.user_id = c.user_id
        LEFT JOIN 
            JobRoles j ON ua.user_id = j.user_id
        LEFT JOIN 
            contacts co ON ua.user_id = co.user_id
        WHERE 
            ua.user_id = ? AND 
            ua.accountStatus IN ('accepted', 'Pending') 
        GROUP BY 
            ua.user_id, ua.email, ua.accountStatus, ua.account_id, 
            u.first_name, u.middle_name, u.sur_name, u.date_of_birth, 
            u.profile_picture";

// Prepare and bind the statement for fetching user details
$stmt = $dbConnection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Display the profile information
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Displaying the data in the HTML structure
    echo '<div class="row gy-4">';
    echo '<div class="col-12 col-lg-6">';
    echo '<div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">';
    echo '<div class="app-card-header p-3 border-bottom-0">';
    echo '<div class="row align-items-center gx-3">';
    echo '<div class="col-auto">';
    echo '<div class="app-icon-holder">';
    echo '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">';
    echo '<path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>';
    echo '</svg>';
    echo '</div><!--//icon-holder-->';
    echo '</div><!--//col-->';
    echo '<div class="col-auto">';
    echo '<h4 class="app-card-title">Profile</h4>';
    echo '</div><!--//col-->';
    echo '</div><!--//row-->';
    echo '</div><!--//app-card-header-->';
    echo '<div class="app-card-body px-4 w-100">';

    // Photo section
    echo '<div class="item border-bottom py-3">';
    echo '<div class="row justify-content-between align-items-center">';
    echo '<div class="col-auto">';
    echo '<div class="item-label mb-2"><strong>Photo</strong></div>';
    echo '<div class="item-data"><img class="profile-image" src="' . $row['profile_picture'] . '" alt=""></div>';
    echo '</div><!--//col-->';
    echo '<div class="col text-end">';
   
    echo '</div><!--//col-->';
    echo '</div><!--//row-->';
    echo '</div><!--//item-->';

    // Name section
    echo '<div class="item border-bottom py-3">';
    echo '<div class="row justify-content-between align-items-center">';
    echo '<div class="col-auto">';
    echo '<div class="item-label"><strong>Name</strong></div>';
    echo '<div class="item-data">' . $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['sur_name'] . '</div>';
    echo '</div><!--//col-->';
    echo '<div class="col text-end">';
 
    echo '</div><!--//col-->';
    echo '</div><!--//row-->';
    echo '</div><!--//item-->';

    // Email section
    echo '<div class="item border-bottom py-3">';
    echo '<div class="row justify-content-between align-items-center">';
    echo '<div class="col-auto">';
    echo '<div class="item-label"><strong>Email</strong></div>';
    echo '<div class="item-data">' . $row['email'] . '</div>';
    echo '</div><!--//col-->';
    echo '<div class="col text-end">';
   
    echo '</div><!--//col-->';
    echo '</div><!--//row-->';
    echo '</div><!--//item-->';

 

    // Location section
    echo '<div class="item border-bottom py-3">';
    echo '<div class="row justify-content-between align-items-center">';
    echo '<div class="col-auto">';
    echo '<div class="item-label"><strong>Location</strong></div>';
    echo '<div class="item-data">' . $row['birth_municipality'] . ', ' . $row['birth_province'] . '</div>';
    echo '</div><!--//col-->';
    echo '<div class="col text-end">';
   
    echo '</div><!--//col-->';
    echo '</div><!--//row-->';
    echo '</div><!--//item-->';

    // Additional details
    // Region
    echo '<div class="item border-bottom py-3">';
    echo '<div class="row justify-content-between align-items-center">';
    echo '<div class="col-auto">';
    echo '<div class="item-label"><strong>Region</strong></div>';
    echo '<div class="item-data">' . $row['region'] . '</div>';
    echo '</div><!--//col-->';
    echo '</div><!--//row-->';
    echo '</div><!--//item-->';

    // Job Role
    echo '<div class="item border-bottom py-3">';
    echo '<div class="row justify-content-between align-items-center">';
    echo '<div class="col-auto">';
    echo '<div class="item-label"><strong>Job Role</strong></div>';
    echo '<div class="item-data">' . $row['job_role'] . '</div>';
    echo '</div><!--//col-->';
    echo '</div><!--//row-->';
    echo '</div><!--//item-->';

    // Phone Number
    echo '<div class="item border-bottom py-3">';
    echo '<div class="row justify-content-between align-items-center">';
    echo '<div class="col-auto">';
    echo '<div class="item-label"><strong>Phone Number</strong></div>';
    echo '<div class="item-data">' . $row['phone_number'] . '</div>';
    echo '</div><!--//col-->';
    echo '</div><!--//row-->';
    echo '</div><!--//item-->';

    echo '</div><!--//app-card-body-->';
    echo '</div><!--//app-card-->';
    echo '</div><!--//col-->';
    echo '</div><!--//row-->';
} else {
    echo "No user data found.";
}

$stmt->close();
$dbConnection->close();

?>


	    
	    
		<?php include 'components/footer.php' ?>
	    
    </div><!--//app-wrapper-->    					

 

	<?php include 'components/script.php'; ?>

</body>
</html> 

