


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
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="../assets/css/portal.css">

</head> 
<body class="app app-reset-password p-0"> 

<?php
session_start(); // Start the session

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted OTP
    $submitted_otp = $_POST['otp'];

    // Get the OTP stored in the session
    $stored_otp = $_SESSION['otp'] ?? '';

    // Check if OTP matches
    if ($submitted_otp == $stored_otp) {
        // OTP is correct, redirect to update password page
        header('Location: updatepassword.php'); // This will take them to the password update form
        exit();
    } else {
        // OTP is incorrect, display error message using Swal
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Incorrect OTP',
                    text: 'Please try again.'
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

                <div class="auth-intro mb-4 text-center">Enter the OTP code from the email we sent to you. This code is valid for <strong id="timer">02:00</strong></div>

                <div class="auth-form-container text-left">
                    <form class="auth-form resetpass-form" action="" method="POST">
                        <div class="email mb-3">
                            <label class="sr-only" for="token">Your Email</label>
                            <input type="number" class="form-control" name="otp" id="token" placeholder="OTP" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn app-btn-primary btn-block theme-btn mx-auto">Reset Password</button>
                        </div>
                    </form>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Countdown timer for 2 minutes
        const twoMinutes = 2 * 60;
        let timeLeft = twoMinutes;

        const countdownTimer = setInterval(function() {
            const minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;

            seconds = seconds < 10 ? '0' + seconds : seconds;

            // Display the countdown timer
            document.getElementById('timer').textContent = `${minutes}:${seconds}`;
            console.log(`Time Left: ${timeLeft}`); // Log time left for debugging

            // Check if time is up
            if (timeLeft <= 0) {
                clearInterval(countdownTimer);
                // Redirect back to cancelation.php using SweetAlert
                Swal.fire({
                    icon: 'info',
                    title: 'Time Expired',
                    text: 'Your OTP session has expired. Redirecting back to cancellation page.',
                    timer: 3000, // 3 seconds
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.href = 'login.php';
                    }
                });
            } else {
                timeLeft--; // Decrease time left
            }
        }, 1000);
    });
</script>





</body>
</html> 

