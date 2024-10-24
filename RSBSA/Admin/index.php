<!DOCTYPE html>
<html lang="en"> 
<?php include 'components/head.php'; ?>
<body class="app">   	
<?php include 'components/header.php'; ?>

    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    <h1 class="app-page-title">Overview</h1>
				
			    <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
				    <div class="inner">
					    <div class="app-card-body p-3 p-lg-4">
						    <h3 class="mb-3">Welcome, Admin!</h3>
						    <div class="row gx-5 gy-3">
						        <div class="col-12 col-lg-9">
							        
							        <div></div>
							    </div><!--//col-->
							    <div class="col-12 col-lg-3">
							    </div><!--//col-->
						    </div><!--//row-->
						    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					    </div><!--//app-card-body-->
					    
				    </div><!--//inner-->
			    </div><!--//app-card-->
			
				    
			    <div class="row g-4 mb-4">
					
				<a class="weatherwidget-io" href="https://forecast7.com/en/15d32120d83/san-antonio/" data-label_1="SAN ANTONIO" data-label_2="WEATHER" data-theme="pure" >SAN ANTONIO WEATHER</a>
									<script>
									!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
									</script>
				     <!-- Clock Section -->
				
					 <div class="col-6 col-lg-3">
						<div class="app-card app-card-stat shadow-sm h-100">
							<div class="app-card-body p-3 p-lg-4 text-center">
								<h4 class="app-card-title">Real-time Clock</h4>
								<div class="stats-figure" id="clock" style="font-size: 30px; font-weight: bold; color: green;"></div>
							</div><!--//app-card-body-->
							<a class="app-card-link-mask" href="#"></a>
						</div><!--//app-card-->
					</div><!--//col-->


				    <?php
					// Assuming you have a database connection file included
					include '../includes/dbconn.php';

					// Query to count total staff (users with role 'staff')
					$staffQuery = "SELECT COUNT(*) as total_staff FROM useraccounts WHERE role = 'staff'";
					$staffResult = mysqli_query($conn, $staffQuery);
					$staffCount = mysqli_fetch_assoc($staffResult)['total_staff'];

					// Query to count total users
					$usersQuery = "SELECT COUNT(*) as total_users FROM useraccounts";
					$usersResult = mysqli_query($conn, $usersQuery);
					$usersCount = mysqli_fetch_assoc($usersResult)['total_users'];

					// Query to count registered land (crops with benefits marked as 'qualified')
					$cropsQuery = "SELECT COUNT(*) as total_registered_land FROM crops WHERE benefits = 'qualified'";
					$cropsResult = mysqli_query($conn, $cropsQuery);
					$cropsCount = mysqli_fetch_assoc($cropsResult)['total_registered_land'];

					// Query to count pending user accounts
					$pendingUsersQuery = "SELECT COUNT(*) as pending_users FROM useraccounts WHERE accountStatus = 'pending'";
					$pendingUsersResult = mysqli_query($conn, $pendingUsersQuery);
					$pendingUsersCount = mysqli_fetch_assoc($pendingUsersResult)['pending_users'];

					// Query to count crops with benefits not marked as 'qualified'
					$notQualifiedCropsQuery = "SELECT COUNT(*) as not_qualified_land FROM crops WHERE benefits != 'qualified'";
					$notQualifiedCropsResult = mysqli_query($conn, $notQualifiedCropsQuery);
					$notQualifiedCropsCount = mysqli_fetch_assoc($notQualifiedCropsResult)['not_qualified_land'];
					?>

					<div class="col-6 col-lg-3">
						<div class="app-card app-card-stat shadow-sm h-100">
							<div class="app-card-body p-3 p-lg-4">
								<h4 class="stats-type mb-1">TOTAL STAFF</h4>
								<div class="stats-figure"><?php echo $staffCount; ?></div>
							</div><!--//app-card-body-->
							<a class="app-card-link-mask" href="#"></a>
						</div><!--//app-card-->
					</div><!--//col-->
					<div class="col-6 col-lg-3">
						<div class="app-card app-card-stat shadow-sm h-100">
							<div class="app-card-body p-3 p-lg-4">
								<h4 class="stats-type mb-1">TOTAL USERS</h4>
								<div class="stats-figure"><?php echo $usersCount; ?></div>
								<div class="stats-meta">Open</div>
							</div><!--//app-card-body-->
							<a class="app-card-link-mask" href="#"></a>
						</div><!--//app-card-->
					</div><!--//col-->
					<div class="col-6 col-lg-3">
						<div class="app-card app-card-stat shadow-sm h-100">
							<div class="app-card-body p-3 p-lg-4">
								<h4 class="stats-type mb-1">TOTAL REGISTERED LAND</h4>
								<div class="stats-figure"><?php echo $cropsCount; ?></div>
								<div class="stats-meta">New</div>
							</div><!--//app-card-body-->
							<a class="app-card-link-mask" href="#"></a>
						</div><!--//app-card-->
					</div><!--//col-->
					<div class="col-6 col-lg-3">
						<div class="app-card app-card-stat shadow-sm h-100">
							<div class="app-card-body p-3 p-lg-4">
								<h4 class="stats-type mb-1">PENDING USER ACCOUNTS</h4>
								<div class="stats-figure"><?php echo $pendingUsersCount; ?></div>
							</div><!--//app-card-body-->
							<a class="app-card-link-mask" href="#"></a>
						</div><!--//app-card-->
					</div><!--//col-->
					<div class="col-6 col-lg-3">
						<div class="app-card app-card-stat shadow-sm h-100">
							<div class="app-card-body p-3 p-lg-4">
								<h4 class="stats-type mb-1">NOT QUALIFIED BENEFITS</h4>
								<div class="stats-figure"><?php echo $notQualifiedCropsCount; ?></div>
							</div><!--//app-card-body-->
							<a class="app-card-link-mask" href="#"></a>
						</div><!--//app-card-->
					</div><!--//col-->
			 
			    <div class="row g-4 mb-4">
				    <div class="col-12 col-lg-4">
					    <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
						    <div class="app-card-header p-3 border-bottom-0">
						        <div class="row align-items-center gx-3">
							        <div class="col-auto">
								        <div class="app-icon-holder">
										    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-receipt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z"/>
  <path fill-rule="evenodd" d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
</svg>
									    </div><!--//icon-holder-->
						                
							        </div><!--//col-->
							        <div class="col-auto">
								        <h4 class="app-card-title">Announcement</h4>
							        </div><!--//col-->
						        </div><!--//row-->
						    </div><!--//app-card-header-->
						    <div class="app-card-body px-4">
							    
							    <div class="intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet eros vel diam semper mollis.</div>
						    </div><!--//app-card-body-->
						    <div class="app-card-footer p-4 mt-auto">
								<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#announcementModal">
									Post New Announcement
								</button>
						    </div><!--//app-card-footer-->
						</div><!--//app-card-->
				    </div><!--//col-->
				    
							        
			    
		    </div><!--//container-fluid-->
			<?php include 'modals.php' ?>
	    </div><!--//app-content-->
	    
		<?php include 'components/footer.php' ?>
	  
    </div><!--//app-wrapper-->    					

 
	<script>
    // Clock Script
    function updateTime() {
        const clockElement = document.getElementById('clock');
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        clockElement.innerText = timeString;
    }

    // Update the time every second
    setInterval(updateTime, 1000);
    updateTime(); // Initial call
	

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<?php include 'components/script.php'; ?>


</body>
</html> 

