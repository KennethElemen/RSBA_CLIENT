<!DOCTYPE html>
<html lang="en"> 
<?php include 'components/head.php'; ?>
<body class="app">   	
<?php include 'components/header.php'; ?>
    
<div class="app-wrapper">
                    <?php
                        include '../includes/dbconn.php';

                        $dbConnection = new mysqli($servername, $username, $password, $dbname);
                        if ($dbConnection->connect_error) {
                            die("Connection failed: " . $dbConnection->connect_error);
                        }

                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $announcement_id = $_POST['announcement_id'];

                            // Prepare and execute the delete statement
                            $deleteQuery = "DELETE FROM announcements WHERE announcement_id = ?";
                            $stmt = $dbConnection->prepare($deleteQuery);
                            $stmt->bind_param('i', $announcement_id);

                            if ($stmt->execute()) {
                                echo "<script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'The announcement has been deleted successfully.',
                                    }).then(() => {
                                        window.location.href = 'annoucement.php'; // Redirect to announcement page
                                    });
                                </script>";
                            } else {
                                echo "<script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'There was an error deleting the announcement.',
                                    });
                                </script>";
                            }

                            // Close the connection
                            $stmt->close();
                        }

                        $dbConnection->close();
                    ?>

	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    <div class="position-relative mb-3">
				    <div class="row g-3 justify-content-between">
					    <div class="col-auto">
					        <h1 class="app-page-title mb-0">Notifications</h1>
					    </div>
				    </div>
			    </div>
			    
				<?php
                    include '../includes/dbconn.php';

                    $dbConnection = new mysqli($servername, $username, $password, $dbname);
                    if ($dbConnection->connect_error) {
                        die("Connection failed: " . $dbConnection->connect_error);
                    }

                    // Fetch announcements, user profile picture, user role, and concatenated full name from the database
                    $query = "SELECT a.announcement_id, a.title, a.content, a.expiration_date, a.attachment_url, a.created_at, ua.role, u.profile_picture, 
                            CONCAT(u.first_name, ' ', u.sur_name) AS full_name
                            FROM announcements a 
                            INNER JOIN useraccounts ua ON a.posted_by = ua.user_id
                            INNER JOIN users u ON ua.user_id = u.user_id
                            ORDER BY a.created_at DESC";

                    $result = $dbConnection->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['announcement_id']; // Get announcement ID for deletion
                            $title = $row['title'];
                            $content = $row['content'];
                            $created_at = strtotime($row['created_at']);
                            $role = ucfirst($row['role']); // Capitalize the first letter of the role
                            $attachment_url = $row['attachment_url']; // Attachment URL from the database
                            $profile_picture = $row['profile_picture']; // Profile picture from the users table
                            $full_name = $row['full_name']; // Full name (concatenated first_name + sur_name)

                            // Calculate time ago from created_at
                            $timeAgo = time() - $created_at;
                            $hoursAgo = round($timeAgo / 3600); // Convert seconds to hours

                            // If the profile picture is not set, use a default image
                            $image = $profile_picture ? $profile_picture : "assets/images/profiles/default-profile.png";

                            // HTML Output
                            echo "
                            <div class='app-card app-card-notification shadow-sm mb-4'>
                                <div class='app-card-header px-4 py-3'>
                                    <div class='row g-3 align-items-center'>
                                        <div class='col-12 col-lg-auto text-center text-lg-start' id='profile_picture'>                          
                                            <img class='profile-image' src='{$image}' alt='Profile Picture'>
                                        </div><!--//col-->
                                        <div class='col-12 col-lg-auto text-center text-lg-start'>
                                            <div class='notification-type mb-2'><span class='badge bg-info'>{$role}</span></div>
                                            <h4 class='notification-title mb-1'>{$title}</h4>
                                            
                                            <ul class='notification-meta list-inline mb-0'>
                                                <li class='list-inline-item'>{$hoursAgo} hrs ago</li>
                                                <li class='list-inline-item'>|</li>
                                                <li class='list-inline-item'>{$full_name}</li>
                                            </ul>
                                        </div><!--//col-->
                                    </div><!--//row-->
                                </div><!--//app-card-header-->
                                
                                <div class='app-card-body p-4'>
                                    <div class='notification-content'>{$content}</div>
                                </div><!--//app-card-body-->";

                            // Display the attachment image if it exists
                            if ($attachment_url) {
                                echo "
                                <div class='app-card-footer px-4 py-3'>
                                    <img src='{$attachment_url}' alt='Attachment' style='max-height: 400px; max-width: 300px;' />
                                </div><!--//app-card-footer-->";
                            }

                        
                            
                            echo "</div><!--//app-card-->";
                        }
                    } else {
                        echo "<p>No announcements found.</p>";
                    }

                    $dbConnection->close();
                    ?>

                  

                    <script>
                        document.querySelectorAll('.delete-announcement').forEach(form => {
                            form.addEventListener('submit', function(e) {
                                e.preventDefault(); // Prevent the default form submission

                                const form = this; // Get the current form

                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete it!',
                                    cancelButtonText: 'No, cancel!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        form.submit(); // Submit the form if confirmed
                                    }
                                });
                            });
                        });
                    </script>



				<div class="text-center mt-4"><a class="btn app-btn-secondary" href="#">Load more notifications</a></div>
			    
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
	    
	
	    
    </div><!--//app-wrapper-->    	
		<?php include 'components/footer.php' ?>
	    
    </div><!--//app-wrapper-->    					

 

	<?php include 'components/script.php'; ?>
</body>
</html> 

