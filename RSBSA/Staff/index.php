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
						    <h3 class="mb-3">Welcome, staff!</h3>
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
			 <hr>
					<div class="row g-4 mb-4">
						<div class="col-12 col-lg-4">
							<div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
								<div class="app-card-header p-3 border-bottom-0">
									<div class="row align-items-center gx-3">
										<div class="col-auto">
											<div class="app-icon-holder">
												<!-- Announcement icon (Speaker icon for announcement) -->
												<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-megaphone" viewBox="0 0 16 16">
													<path d="M7 6.5c0 .795-.504 1.47-1.215 1.75v.5c0 .552-.448 1-1 1s-1-.448-1-1v-.5A1.75 1.75 0 1 1 7 6.5zM5.285 6h1.43c.157-.252.285-.535.285-.875s-.128-.623-.285-.875h-1.43c.157.252.285.535.285.875s-.128.623-.285.875z"/>
													<path fill-rule="evenodd" d="M8 6a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H5.5a.5.5 0 0 0 0 1H7v1H5.5a.5.5 0 0 0 0 1H8zm5-3H8.246C8.09 1.667 7.64 1 7 1s-1.09.667-1.246 1.5H3.5C2.672 2.5 2 3.172 2 4v6c0 .828.672 1.5 1.5 1.5h.254c.156.833.606 1.5 1.246 1.5s1.09-.667 1.246-1.5H13c.828 0 1.5-.672 1.5-1.5V4c0-.828-.672-1.5-1.5-1.5zM14 4v6H2V4h12z"/>
												</svg>
											</div>
										</div>
										<div class="col-auto">
											<h4 class="app-card-title">Announcement</h4>
										</div>
									</div>
								</div>
								<div class="app-card-body px-4">
									<p class="intro mb-3">
										Use this section to create and post important announcements that will be visible to all team members or clients. Click the button below to open a modal window where you can add the details of the announcement, set its visibility, and publish it instantly.
									</p>
								</div>
								<div class="app-card-footer p-4 mt-auto">
									<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#announcementModal">
										Post New Announcement
									</button>
								</div>
							</div>
						</div>
						
						<div class="col-12 col-lg-4">
							<div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
								<div class="app-card-header p-3 border-bottom-0">
									<div class="row align-items-center gx-3">
										<div class="col-auto">
											<div class="app-icon-holder icon-holder-mono">
												<!-- Help icon (Headset icon for support) -->
												<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-headset" viewBox="0 0 16 16">
													<path d="M8 1a5 5 0 0 0-5 5v4.5H2V6a6 6 0 1 1 12 0v4.5h-1V6a5 5 0 0 0-5-5z"/>
													<path d="M11 8a1 1 0 0 1 1-1h2v4a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V8zM5 8a1 1 0 0 0-1-1H2v4a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V8z"/>
													<path fill-rule="evenodd" d="M13.5 8.5a.5.5 0 0 1 .5.5v3a2.5 2.5 0 0 1-2.5 2.5H8a.5.5 0 0 1 0-1h3.5A1.5 1.5 0 0 0 13 12V9a.5.5 0 0 1 .5-.5z"/>
													<path d="M6.5 14a1 1 0 0 1 1-1h1a1 1 0 1 1 0 2h-1a1 1 0 0 1-1-1z"/>
												</svg>
											</div>
										</div>
										<div class="col-auto">
											<h4 class="app-card-title">Staff Message Center</h4>
										</div>
									</div>
								</div>
								<div class="app-card-body px-4">
									<div class="intro mb-3">
										Access the live chat platform to check client inquiries and respond to user messages in real-time. Click the button below to view and manage ongoing chats with clients.
									</div>
								</div>
								<div class="app-card-footer p-4 mt-auto">
									<!-- Button for staff to open the live chat in a new tab -->
									<a class="btn app-btn-secondary" href="https://www.tidio.com/" target="_blank" rel="noopener noreferrer">Open Message Center</a>
								</div>
							</div>
						</div>
					</div><!--//row-->

					
					

			    
		    </div><!--//container-fluid-->
			<?php include 'modals.php' ?>
	    </div><!--//app-content-->
	    
		<?php include 'components/footer.php' ?>
	  
    </div><!--//app-wrapper-->    					

 <script>
						document.addEventListener("DOMContentLoaded", function () {
							const chatMessagesElement = document.getElementById("chat-messages");
							const chatInputElement = document.getElementById("chatInput");
							const sendMessageBtn = document.getElementById("sendMessageBtn");
							const userId = 101; // Replace with the actual user ID (dynamic value)

							// Function to fetch chat history
							async function fetchChatHistory() {
								try {
									const response = await fetch('/api/messages?user_id=' + userId); // API endpoint to fetch messages
									const messages = await response.json();

									chatMessagesElement.innerHTML = ''; // Clear previous messages
									messages.forEach(message => {
										const messageDiv = document.createElement('div');
										messageDiv.classList.add('d-flex', 'mb-3');
										const msgContent = message.reply ? message.reply : message.message; // Show reply if exists
										messageDiv.innerHTML = `
											<div class="p-2 ${message.user_id === userId ? 'bg-primary text-white' : 'bg-secondary text-white'} rounded-3">
												${msgContent}
											</div>
										`;
										chatMessagesElement.appendChild(messageDiv);
									});

									chatMessagesElement.scrollTop = chatMessagesElement.scrollHeight; // Scroll to the bottom
								} catch (error) {
									console.error("Error fetching chat history:", error);
								}
							}

							// Function to send a message
							async function sendMessage() {
								const messageContent = chatInputElement.value.trim();
								if (messageContent === '') return; // Prevent sending empty messages

								try {
									const response = await fetch('/api/messages', {
										method: 'POST',
										headers: {
											'Content-Type': 'application/json',
										},
										body: JSON.stringify({
											user_id: userId,
											message: messageContent,
											parent_id: null, // Set parent_id as null for top-level messages
										}),
									});

									if (response.ok) {
										chatInputElement.value = ''; // Clear input field
										fetchChatHistory(); // Refresh chat history
									} else {
										console.error("Error sending message:", response.statusText);
									}
								} catch (error) {
									console.error("Error sending message:", error);
								}
							}

							// Event listeners
							sendMessageBtn.addEventListener("click", sendMessage);
							chatInputElement.addEventListener("keypress", function (event) {
								if (event.key === 'Enter') {
									sendMessage();
								}
							});

							// Initial fetch of chat history when modal opens
							$('#liveChatModal').on('show.bs.modal', fetchChatHistory);
						});
					</script>




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

