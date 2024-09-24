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
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "No account found with that email address.";
    }
}

// Close the database connection
$dbConnection->close();
?>



<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Portal - Bootstrap 5 Admin Dashboard Template For Developers</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="../favicon.ico"> 

    <!-- FontAwesome JS-->
    <script defer src="../assets/plugins/fontawesome/js/all.min.js"></script>
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="../assets/css/portal.css">

</head> 

<body class="app app-login p-0">    	
    <div class="row g-0 app-auth-wrapper">
		<div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5 mx-auto d-flex justify-content-center align-items-center h-100" >
			<div class="d-flex flex-column align-content-center">
				<div class="app-auth-body mx-auto">    
					<div class="app-auth-branding mb-4">
						<a class="app-logo" href="index.html">
							<img class="logo-icon me-2" src="../assets/images/sane_logo.png" alt="logo">
						</a>
					</div>
					<h2 class="auth-heading text-center mb-5">Log in to Portal</h2>
					<div class="auth-form-container text-start">
					<form class="auth-form login-form" method="POST" action="">         
							<div class="email mb-3">
								<label class="sr-only" for="signin-email">Email</label>
								<input id="signin-email" name="email" type="email" class="form-control signin-email" placeholder="Email address" required="required">
							</div>
							<div class="password mb-3">
								<label class="sr-only" for="signin-password">Password</label>
								<input id="signin-password" name="password" type="password" class="form-control signin-password" placeholder="Password" required="required">
								<div class="extra mt-3 row justify-content-between">
									<div class="col-6">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="RememberPassword">
											<label class="form-check-label" for="RememberPassword">Remember me</label>
										</div>
									</div>
									<div class="col-6">
										<div class="forgot-password text-end">
											<a href="reset-password.html">Forgot password?</a>
										</div>
									</div>
								</div>
							</div>
							<div class="text-center">
								<button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Log In</button>
							</div>
						</form>

						<div class="auth-option text-center pt-5">
							No Account? Sign up <a class="text-link" href="../../registration/colorlib-wizard-14/register.php" >here</a>.
						</div>
					</div>    
				</div>
				<footer class="app-auth-footer">
					<div class="container text-center py-3">
						
					</div>
				</footer>
			</div>   
		</div>
		
	    <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
		    <div class="auth-background-holder">
		    </div>
		    <div class="auth-background-mask"></div>
		    <div class="auth-background-overlay p-3 p-lg-5">
			    <div class="d-flex flex-column align-content-end h-100">
				    <div class="h-100"></div>
				    
				</div>
		    </div><!--//auth-background-overlay-->
	    </div><!--//auth-background-col-->
    
    </div><!--//row-->

	
</body>
</html> 

