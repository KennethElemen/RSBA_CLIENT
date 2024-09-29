


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
    <link rel="shortcut icon" href="../favicon.ico"> 
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- FontAwesome JS-->
    <script defer src="../assets/plugins/fontawesome/js/all.min.js"></script>
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="../assets/css/portal.css">

</head> 
<body class="app app-reset-password p-0"> 
    
<?php
session_start();
include '../includes/mailer.php'; 
include '../includes/dbconn.php'; // Include database connection

// Function to generate a random OTP    
function generateOTP() {
    return rand(100000, 999999);
}

// Function to send OTP email
function sendOTP($email) {
    $otp = generateOTP();
    $subject = 'Your OTP for Reset Password';
    $message = '
    <html>
    <head><title>OTP for Reset Password</title></head>
    <body>
        <h1>Reset Password</h1>
        <p>Your OTP is <strong>' . $otp . '</strong>. It is valid for 2 minutes.</p>
    </body>
    </html>';

    if (sendEmail($email, $subject, $message)) {
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiry'] = time() + (2 * 60); // OTP valid for 2 minutes
        return true;
    }
    return false;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists in the useraccounts table
    $query = $conn->prepare("SELECT * FROM useraccounts WHERE email = ?");
    if (!$query) {
        die("Query preparation failed: " . $conn->error);
    }

    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result === false) {
        die("Query execution failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $_SESSION['email'] = $email; // Store email in session

        echo "<script>
            Swal.fire({
                title: 'Email Found!',
                text: 'Sending OTP...',
                icon: 'info',
                showConfirmButton: false,
                timer: 1500
            });
        </script>";
        
        if (sendOTP($email)) {
            echo "<script>
                Swal.fire({
                    title: 'OTP Sent Successfully!',
                    text: 'Please check your email for the OTP.',
                    icon: 'success'
                }).then(function() {
                    window.location.href = 'passwordOTP.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to send OTP. Please try again.',
                    icon: 'error'
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Email not found. Please enter a valid email.',
                icon: 'error'
            });
        </script>";
    }
}
?>

<div class="row g-0 app-auth-wrapper d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
        <div class="d-flex flex-column align-content-end">
            <div class="app-auth-body mx-auto">
                <div class="app-auth-branding mb-4">
                    <a class="app-logo" href="index.html">
                        <img class="logo-icon me-2" src="../assets/images/sane_logo.png" alt="logo">
                    </a>
                </div>
                <h2 class="auth-heading text-center mb-4">Password Reset</h2>

                <div class="auth-intro mb-4 text-center">Enter your email address below. We'll email you a link to a page where you can easily create a new password.</div>

                <div class="auth-form-container text-left">
                    <form class="auth-form resetpass-form" action="" method="POST">
                        <div class="email mb-3">
                            <label class="sr-only" for="reg-email">Your Email</label>
                            <input id="reg-email" name="email" type="email" class="form-control login-email" placeholder="Your Email" required="required">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn app-btn-primary btn-block theme-btn mx-auto">Reset Password</button>
                        </div>
                    </form>

                    <div class="auth-option text-center pt-5">
                        <a class="app-link" href="login.php">Log in</a>
                        <span class="px-2">|</span>
                        <a class="app-link" href="../../registration/colorlib-wizard-14/register.php">Sign up</a>
                    </div>
                </div><!--//auth-form-container-->
            </div><!--//auth-body-->

            <footer class="app-auth-footer">
                <div class="container text-center py-3">
                    <!-- Footer content -->
                </div>
            </footer><!--//app-auth-footer-->
        </div><!--//flex-column-->
    </div><!--//auth-main-col-->
</div><!--//row-->



</body>
</html> 

