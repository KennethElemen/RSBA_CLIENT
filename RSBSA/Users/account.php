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

			// Fetch user account details for the current user
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

				// Start profile display structure
				echo '<div class="row gy-4">';
				
				// Personal Information Box
				echo '<div class="col-12 col-lg-6">';
				echo '<div class="app-card app-card-account shadow-sm d-flex flex-column">';
				echo '<div class="app-card-header p-3 border-bottom-0">';
				echo '<h4 class="app-card-title">Personal Information</h4>';
				echo '</div><!--//app-card-header-->';
				echo '<div class="app-card-body px-4 w-100">';

				// Profile Picture
				echo '<div class="item border-bottom py-3">';
				echo '<strong>Photo:</strong> <img class="profile-image" src="' . $row['profile_picture'] . '" alt="">';
				echo '</div><!--//item-->';

				// Full Name
				echo '<div class="item border-bottom py-3">';
				echo '<strong>Name:</strong> ' . $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['sur_name'];
				echo '</div><!--//item-->';

				// Email
				echo '<div class="item border-bottom py-3">';
				echo '<strong>Email:</strong> ' . $row['email'];
				echo '</div><!--//item-->';

				// Account Status
				echo '<div class="item border-bottom py-3">';
				echo '<strong>Account Status:</strong> <span class="badge bg-warning text-dark">' . $row['accountStatus'] . '</span>';
				echo '</div><!--//item-->';
				
				echo '</div><!--//app-card-body-->';
				echo '</div><!--//app-card-->';
				echo '</div><!--//col-->';

				// Location Details Box
				echo '<div class="col-12 col-lg-6">';
				echo '<div class="app-card app-card-account shadow-sm d-flex flex-column">';
				echo '<div class="app-card-header p-3 border-bottom-0">';
				echo '<h4 class="app-card-title">Location Details</h4>';
				echo '</div><!--//app-card-header-->';
				echo '<div class="app-card-body px-4 w-100">';

				// Birthplace
				echo '<div class="item border-bottom py-3">';
				echo '<strong>Birthplace:</strong> ' . $row['birth_municipality'] . ', ' . $row['birth_province'];
				echo '</div><!--//item-->';

				// Region
				echo '<div class="item border-bottom py-3">';
				echo '<strong>Region:</strong> ' . $row['region'];
				echo '</div><!--//item-->';
				
				echo '</div><!--//app-card-body-->';
				echo '</div><!--//app-card-->';
				echo '</div><!--//col-->';

				// Crop Information Box
				echo '<div class="col-12">';
				echo '<div class="app-card app-card-account shadow-sm d-flex flex-column">';
				echo '<div class="app-card-header p-3 border-bottom-0">';
				echo '<h4 class="app-card-title">Crop Information</h4>';
				echo '</div><!--//app-card-header-->';
				echo '<div class="app-card-body px-4 w-100">';

				// Job Role
				echo '<div class="item border-bottom py-3">';
				echo '<strong>Job Role:</strong> ' . $row['job_role'];
				echo '</div><!--//item-->';

				// Phone Number
				echo '<div class="item border-bottom py-3">';
				echo '<strong>Phone Number:</strong> ' . $row['phone_number'];
				echo '</div><!--//item-->';

				// Crop Name
				echo '<div class="item border-bottom py-3">';
				echo '<strong>Crop Name:</strong> ' . $row['crop_name'];
				echo '</div><!--//item-->';

				// Crop Area
				echo '<div class="item border-bottom py-3">';
				echo '<strong>Crop Area (hectares):</strong> ' . $row['crop_area_hectares'];
				echo '</div><!--//item-->';

				// Benefits
				echo '<div class="item border-bottom py-3">';
				echo '<strong>Benefits:</strong> ' . $row['benefits'];
				echo '</div><!--//item-->';

				echo '</div><!--//app-card-body-->';
				echo '</div><!--//app-card-->';
				echo '</div><!--//col-->';

				echo '</div><!--//row-->';
			} else {
				echo '<p>No user details found.</p>';
			}
			?>
		</div>
	</div>
</div>

</div>
				

 

	<?php include 'components/script.php'; ?>

</body>
</html> 

