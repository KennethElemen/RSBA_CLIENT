



<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Agriland</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="../assets/finallogo.jpg">  
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- FontAwesome JS-->
    <script defer src="../assets/plugins/fontawesome/js/all.min.js"></script>
    <!-- Add the Font Awesome CDN in your HTML head section -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="../assets/css/portal.css">

</head> 
<body class="app app-reset-password p-0"> 
<!-- Add the Font Awesome CDN in your HTML head section -->

<?php
session_start();
include '../includes/dbconn.php'; // Include your database connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Check if email session exists
    $email = $_SESSION['email'] ?? null; // Retrieve email from session

    if ($email === null) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Session expired. Please try again.'
                }).then(function() {
                    window.location.href = 'resetpassword.php'; // Redirect to reset password page
                });
              </script>";
        exit();
    }

    // Retrieve the submitted password and confirm password
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'Passwords do not match. Please try again.'
                });
              </script>";
        exit();
    }

    // Hash the password before saving
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update the password in the database
    $query = $conn->prepare("UPDATE useraccounts SET password = ? WHERE email = ?");
    if (!$query) {
        die("Query preparation failed: " . $conn->error);
    }

    $query->bind_param("ss", $hashed_password, $email);
    $result = $query->execute();

    if ($result) {
        // If the password update is successful
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Password Updated',
                    text: 'Your password has been updated successfully.'
                }).then(function() {
                    window.location.href = 'login.php'; // Redirect to login page
                });
              </script>";
    } else {
        // If the update failed
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update the password. Please try again.'
                });
              </script>";
    }
}
?>


<div class="row g-0 app-auth-wrapper d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #f8f9fa;">
    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5" style="background-color: #fff; box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1); border-radius: 8px;">
        <div class="d-flex flex-column align-items-center">
            <div class="app-auth-body w-100">
                <div class="app-auth-branding mb-4 text-center">
                    <a class="app-logo" href="index.html">
                        <img class="logo-icon me-2" src="../assets/images/sane_logo.png" alt="logo" style="max-width: 150px;">
                    </a>
                </div>
                <h2 class="auth-heading text-center mb-4" style="font-size: 2rem; font-weight: 600;">Password Reset</h2>

                <div class="auth-intro mb-4 text-center">
    Your about to change the password for <strong><?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?></strong>
</div>


                <div class="auth-form-container w-100 text-center">
                    <form method="post" action="">
                        <div class="form-group mb-3 text-start"> <!-- Text-start ensures labels are aligned left -->
                            
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" placeholder="New password" required oninput="validatePasswordMatch()">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="togglePasswordIcon"></i> <!-- Font Awesome eye icon -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3 text-start" mt-4> <!-- Text-start ensures labels are aligned left -->
                          
                            <div class="input-group">
                                <input type="password" class="form-control" name="confirm_password" id="Conpassword" placeholder="Confirm password" required oninput="validatePasswordMatch()">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="cursor: pointer;" onclick="togglePassword1()">
                                        <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i> <!-- Font Awesome eye icon -->
                                    </div>
                                </div>
                            </div>
                            <small id="passwordHelpBlock" class="form-text text-danger"></small>
                            <small id="passwordMatchMessage" class="form-text text-danger"></small> <!-- Error message placeholder -->
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="button" class="btn btn-light px-4">Cancel</button>
                            <button type="submit" class="btn btn-gradient-primary px-4" style="background-color: #007bff; border: none;">Submit</button>
                          
                        </div>
                    </form>
                </div><!--//auth-form-container-->
            </div><!--//auth-body-->

            <footer class="app-auth-footer mt-4">
                <div class="container text-center py-3" style="font-size: 0.875rem; color: #6c757d;">
                    &copy; 2024 Your Company Name. All Rights Reserved.
                </div>
            </footer><!--//app-auth-footer-->
        </div><!--//flex-column-->
    </div><!--//auth-main-col-->
</div><!--//row-->


<!-- JavaScript for toggling password visibility -->
<script>
function togglePassword() {
    var passwordField = document.getElementById('password');
    var toggleIcon = document.getElementById('togglePasswordIcon');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

function togglePassword1() {
    var confirmPasswordField = document.getElementById('Conpassword');
    var toggleIcon = document.getElementById('toggleConfirmPasswordIcon');
    if (confirmPasswordField.type === 'password') {
        confirmPasswordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        confirmPasswordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>


<script>
    function togglePassword() {
        var passwordInput = document.getElementById('password');
        passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
    }
    function togglePassword1() {
        var passwordInput = document.getElementById('Conpassword');
        passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
    }
</script>
<script>
   
      document.getElementById("password").addEventListener("input", function() {
        var password = this.value;
        var passwordHelpBlock = document.getElementById("passwordHelpBlock");
        var hasUppercase = /[A-Z]/.test(password);
        var hasLowercase = /[a-z]/.test(password);
        var hasNumber = /\d/.test(password);
        var hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

        if (password.length < 8) {
            passwordHelpBlock.textContent = "Password must be at least 8 characters long.";
            passwordHelpBlock.classList.add("text-danger"); // Using Bootstrap's text-danger class for red color
        } else if (!hasUppercase) {
            passwordHelpBlock.textContent = "Password must contain at least one uppercase letter.";
            passwordHelpBlock.classList.add("text-danger"); // Using Bootstrap's text-danger class for red color
        } else if (!hasLowercase) {
            passwordHelpBlock.textContent = "Password must contain at least one lowercase letter.";
            passwordHelpBlock.classList.add("text-danger"); // Using Bootstrap's text-danger class for red color
        } else if (!hasNumber) {
            passwordHelpBlock.textContent = "Password must contain at least one number.";
            passwordHelpBlock.classList.add("text-danger"); // Using Bootstrap's text-danger class for red color
        } else if (!hasSpecialChar) {
            passwordHelpBlock.textContent = "Password must contain at least one special character.";
            passwordHelpBlock.classList.add("text-danger"); // Using Bootstrap's text-danger class for red color
        } else {
            passwordHelpBlock.textContent = "";
            passwordHelpBlock.classList.remove("text-danger"); // Remove text-danger class if all criteria met
        }
    });
     function validatePasswordMatch() {
        var newPassword = document.getElementById("password").value;
        var confirmPassword = document.getElementById("Conpassword").value;
        var passwordMatchMessage = document.getElementById("passwordMatchMessage");

        if (newPassword !== confirmPassword) {
            passwordMatchMessage.textContent = "New password and confirm password do not match";
            passwordMatchMessage.classList.add("text-danger"); // Using Bootstrap's text-danger class for red color
        } else {
            passwordMatchMessage.textContent = "";
            passwordMatchMessage.classList.remove("text-danger"); // Remove text-danger class if passwords match
        }
    }
</script>


</body>
</html> 

