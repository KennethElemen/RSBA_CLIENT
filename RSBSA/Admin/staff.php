
<?php
include '../includes/dbconn.php';

// Create a database connection
$dbConnection = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user input
    $first_name = $dbConnection->real_escape_string($_POST['first_name']);
    $middle_name = $dbConnection->real_escape_string($_POST['middle_name']);
    $sur_name = $dbConnection->real_escape_string($_POST['sur_name']);
    $sex = $dbConnection->real_escape_string($_POST['sex']);
    $date_of_birth = $dbConnection->real_escape_string($_POST['dateOfBirth']);
    $birth_municipality = $dbConnection->real_escape_string($_POST['birthMunicipality']); // Fixed spelling
    $birth_province = $dbConnection->real_escape_string($_POST['birthProvince']);
    
    $temp_profile_picture = null; // Initialize the variable

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $file_size = $_FILES['profile_picture']['size'];
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_type = $_FILES['profile_picture']['type'];
        $file_ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
    
        // Define allowed file extensions and size limit
        $allowed_extensions = ['jpeg', 'jpg', 'png'];
        $max_file_size = 5 * 1024 * 1024; // 5 MB
    
        // Check file size and extension
        if ($file_size > $max_file_size) {
            echo "Error: File size exceeds the 5 MB limit.";
            exit;
        }
        if (!in_array($file_ext, $allowed_extensions)) {
            echo "Error: Only JPEG, JPG, and PNG files are allowed.";
            exit;
        }
    
        // Temporarily store the profile picture path
        $target_dir = "../assets/images/profiles/";
        $temp_profile_picture = $target_dir . basename($_FILES["profile_picture"]["name"]);
        if (!move_uploaded_file($file_tmp, $temp_profile_picture)) {
            echo "Error uploading file.";
            exit; // Exit if file upload fails
        }
    }
    
    

        // Insert into Users table (initial insertion before renaming the profile picture)
        $sql_users = "INSERT INTO Users (first_name, middle_name, sur_name, sex, date_of_birth, birth_municipality, birth_province, profile_picture)
        VALUES ('$first_name', '$middle_name', '$sur_name', '$sex', '$date_of_birth', '$birth_municipality', '$birth_province', null)";

        if ($dbConnection->query($sql_users) === TRUE) {
        $user_id = $dbConnection->insert_id; // Get the last inserted user ID

        // Now rename the profile picture with the correct naming convention
        if ($temp_profile_picture) {
        $new_filename = "profile_" . $user_id . "." . $file_ext; // e.g., profile_123.jpg
        $new_file_path = $target_dir . $new_filename;

        // Rename the file
        if (rename($temp_profile_picture, $new_file_path)) {
            $profile_picture = $new_file_path;

            // Update the Users table with the correct profile picture path
            $sql_update_picture = "UPDATE Users SET profile_picture = '$profile_picture' WHERE user_id = '$user_id'";
            $dbConnection->query($sql_update_picture);
        } else {
            echo "Error renaming profile picture.";
            exit;
        }
        }


        // Insert into Addresses table (home address)
        $region = $dbConnection->real_escape_string($_POST['region']);
        $province = $dbConnection->real_escape_string($_POST['province']);
        $city = $dbConnection->real_escape_string($_POST['city']);
        $barangay = $dbConnection->real_escape_string($_POST['barangay']);
        $street_number = $dbConnection->real_escape_string($_POST['street_number']);
        $purok = $dbConnection->real_escape_string($_POST['purok']);
        
        $sql_address = "INSERT INTO Addresses (user_id, region, province, city_municipality, barangay, street_number, purok, address_type)
                        VALUES ('$user_id', '$region', '$province', '$city', '$barangay', '$street_number', '$purok', 'home')";
        if (!$dbConnection->query($sql_address)) {
            echo "Error: " . $dbConnection->error;
        }

        // Insert into Contacts table (personal and emergency)
        $personal_phone = $dbConnection->real_escape_string($_POST['number']);
        $emergency_phone = $dbConnection->real_escape_string($_POST['emergencyNumber']);
        
        $sql_contact_personal = "INSERT INTO Contacts (user_id, phone_number, contact_type)
                                 VALUES ('$user_id', '$personal_phone', 'personal')";
        $sql_contact_emergency = "INSERT INTO Contacts (user_id, phone_number, contact_type)
                                  VALUES ('$user_id', '$emergency_phone', 'emergency')";
        $dbConnection->query($sql_contact_personal);
        $dbConnection->query($sql_contact_emergency);

        // Insert into UserAccounts table
        $email = $dbConnection->real_escape_string($_POST['email']);
        $password = password_hash($dbConnection->real_escape_string($_POST['password']), PASSWORD_DEFAULT);

        $accountStatus = "accepted"; // Set accountStatus to "accepted" directly
        $role = "staff"; // Set role to "staff" directly
        
        $sql_account = "INSERT INTO UserAccounts (user_id, email, password, accountStatus, role)
                        VALUES ('$user_id', '$email', '$password', '$accountStatus', '$role')";
        if ($dbConnection->query($sql_account) === FALSE) {
            echo "Error: " . $dbConnection->error;
        }

      
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $sql_users . "<br>" . $dbConnection->error;
    }
}
$dbConnection->close();
?>




<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">

<?php include 'components/head.php'; ?>
<body class="app">   
<?php include 'components/header.php'; ?>

<div class="app-wrapper">
    
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            
            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0">Staff</h1>
                </div>
                <div class="col-auto">
                    <div class="page-utilities">
                        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                            
                            <div class="col-auto">
                                <a class="btn app-btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#createStaffModal">Create Staff</a>
                            </div>
                        </div><!--//row-->
                    </div><!--//table-utilities-->
                </div><!--//col-auto-->
            </div><!--//row-->

            <div class="app-card app-card-orders-table shadow-sm mb-5">
                <div class="app-card-body">
                    <div class="table-responsive">
                        <table class="table app-table-hover mb-0 text-left">
                            <thead>
                                <tr>
                                <th class="cell">accountID</th>
                                <th class="cell">Email</th>
                                <th class="cell">Full Name</th>
                                <th class="cell">Status</th>
                                <th class="cell">action</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php include '../includes/Applicants/allstaff.php'?>
                            </tbody> 
                        </table>
                    </div><!--//table-responsive-->
                </div><!--//app-card-body-->     
            </div><!--//app-card-->
<!-- Pagination -->
            <nav class="app-pagination">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div><!--//container-fluid-->
    </div><!--//app-content-->
    
    <?php include 'components/footer.php' ?>
    
</div><!--//app-wrapper-->    


<div class="modal fade" id="createStaffModal" tabindex="-1" aria-labelledby="createStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="createStaffModalLabel">Create Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4 justify-content-center">
                    <!-- StaffInformation Card -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <strong>Staff Information</strong>
                            </div>
                            <div class="card-body">
                                <form id="createStaffForm" method="POST" enctype="multipart/form-data" action="">
                                    <div class="row g-3">
                                        <!-- Profile Picture Section -->
                                        <div class="col-lg-4 d-flex flex-column align-items-start">
                                            <label for="profile_picture" class="text-center mb-2">
                                                <img id="modal-profile-picture" src="https://via.placeholder.com/150" alt="Profile Picture" class="rounded-circle img-fluid border border-primary" style="width: 40vh; cursor: pointer;">
                                            </label>
                                            <input type="file" id="profile_picture" name="profile_picture" accept=".jpeg, .jpg, .png" style="display: none;" onchange="previewImage(event)">
                                            <small class="text-muted">Click the image to upload a profile picture</small>
                                            <div id="image-error" class="text-danger" style="display: none;"></div>
                                        </div>

                                        <!-- Other Input Fields -->
                                        <div class="col-lg-8">
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label for="first_name" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" name="first_name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="middle_name" class="form-label">Middle Name</label>
                                                    <input type="text" class="form-control" name="middle_name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="sur_name" class="form-label">Surname</label>
                                                    <input type="text" class="form-control" name="sur_name" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" class="form-control" name="password" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="number" class="form-label">Personal Phone Number</label>
                                                    <input type="tel" class="form-control" name="number" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="emergencyNumber" class="form-label">Emergency Phone Number</label>
                                                    <input type="tel" class="form-control" name="emergencyNumber" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="sex" class="form-label">Sex</label>
                                                    <select name="sex" class="form-control" required>
                                                        <option value="">Select Sex</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="dateOfBirth" class="form-label">Date of Birth</label>
                                                    <input type="date" class="form-control" name="dateOfBirth" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="birthProvince" class="form-label">Birth Province</label>
                                                    <select name="birthProvince" id="birthProvince" class="form-control" required>
                                                        <option value="">PROVINCE</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="birthMunicipality" class="form-label">Birth Municipality</label>
                                                    <select name="birthMunicipality" id="birthMunicipality" class="form-control" required>
                                                        <option value="">CITY/MUNICIPALITY</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information Card -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <strong>Address Information</strong>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="region" class="form-label">Region</label>
                                        <select name="region" id="region" class="form-control" required>
                                            <option value="">REGION</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="province" class="form-label">Province</label>
                                        <select name="province" id="province" class="form-control" required>
                                            <option value="">PROVINCE</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city" class="form-label">City</label>
                                        <select name="city" id="city" class="form-control" required>
                                            <option value="">CITY/MUNICIPALITY</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="barangay" class="form-label">Barangay</label>
                                        <select name="barangay" id="barangay" class="form-control" required>
                                            <option value="">BARANGAY</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="street_number" class="form-label">Street Number</label>
                                        <input type="text" class="form-control" name="street_number" placeholder="STREET/SITIO/SUBDV." required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="purok" class="form-label">Purok</label>
                                        <input type="text" class="form-control" name="purok" placeholder="HOUSE/LOT/BLDG. NO./PUROK" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" form="createStaffForm" onclick="validateForm()">Create Staff</button>
            </div>
        </div>
    </div>
</div>


<?php include 'modals.php'; ?>
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const imageError = document.getElementById('image-error');
        const profilePicture = document.getElementById('modal-profile-picture');

        if (file) {
            // Validate file type (jpg, jpeg, png)
            const allowedTypes = ['image/jpeg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                imageError.textContent = "Invalid file type. Only JPEG, JPG, and PNG are allowed.";
                imageError.style.display = 'block';
                profilePicture.src = "https://via.placeholder.com/150"; // Reset to default placeholder
                return;
            }
            
            // Validate file size (limit to 5MB)
            const maxFileSize = 5 * 1024 * 1024; // 5 MB
            if (file.size > maxFileSize) {
                imageError.textContent = "File size exceeds the 5MB limit.";
                imageError.style.display = 'block';
                profilePicture.src = "https://via.placeholder.com/150"; // Reset to default placeholder
                return;
            }

            // If validation passes, hide the error and display the preview
            imageError.style.display = 'none';

            const reader = new FileReader();
            reader.onload = function(e) {
                profilePicture.src = e.target.result; // Set the image preview
            }
            reader.readAsDataURL(file);
        } else {
            profilePicture.src = "https://via.placeholder.com/150"; // Reset to default placeholder
        }
    }
</script>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        const imageError = document.getElementById('image-error');
        imageError.style.display = 'none';

        if (file) {
            if (!allowedTypes.includes(file.type)) {
                imageError.textContent = 'Please upload a valid image (JPEG, JPG, or PNG).';
                imageError.style.display = 'block';
                document.getElementById('modal-profile-picture').src = 'https://via.placeholder.com/150'; // Reset to default
                return;
            }

            if (file.size > maxSize) {
                imageError.textContent = 'File size must be less than 2MB.';
                imageError.style.display = 'block';
                document.getElementById('modal-profile-picture').src = 'https://via.placeholder.com/150'; // Reset to default
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('modal-profile-picture').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    function validateForm() {
        const form = document.getElementById('createStaffForm');
        if (form.checkValidity() === false) {
            // Trigger validation UI
            Array.from(form.elements).forEach(element => {
                if (!element.checkValidity()) {
                    element.classList.add('is-invalid');
                } else {
                    element.classList.remove('is-invalid');
                }
            });
            form.reportValidity(); // Show validation messages
        } else {
            form.submit(); // Submit the form if all inputs are valid
        }
    }


</script>

<script>
        document.addEventListener("DOMContentLoaded", function () {
            const birthProvinceSelect = document.getElementById('birthProvince');
            const birthMunicipalitySelect = document.getElementById('birthMunicipality');
            const provinceUrl = 'https://psgc.cloud/api/provinces';

            // Function to show loading indicator
            function showLoadingIndicator() {
                const loadingIndicator = document.createElement('div');
                loadingIndicator.textContent = 'Loading...';
                loadingIndicator.id = 'loadingIndicator';
                document.body.appendChild(loadingIndicator);
            }

            // Function to hide loading indicator
            function hideLoadingIndicator() {
                const loadingIndicator = document.getElementById('loadingIndicator');
                if (loadingIndicator) loadingIndicator.remove();
            }

            // Fetch provinces on page load
            fetch(provinceUrl)
                .then(response => {
                    showLoadingIndicator();
                    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    hideLoadingIndicator();
                    birthProvinceSelect.innerHTML = '<option value="">PROVINCE</option>'; // Clear previous options
                    data.forEach(province => {
                        const option = document.createElement('option');
                        option.value = province.name; // Set the value to the province name
                        option.textContent = province.name; // Display the province name
                        birthProvinceSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    hideLoadingIndicator();
                    console.error('Error fetching provinces:', error);
                });

            // Fetch municipalities when a province is selected
            birthProvinceSelect.addEventListener('change', function() {
                const selectedProvince = this.value;
                birthMunicipalitySelect.innerHTML = '<option value="">CITY/MUNICIPALITY</option>'; // Clear previous options

                if (selectedProvince) {
                    // You may need to adjust this URL based on your actual API endpoint for cities
                    const citiesUrl = `https://psgc.cloud/api/provinces/${selectedProvince}/cities-municipalities`;

                    fetch(citiesUrl)
                        .then(response => {
                            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                            return response.json();
                        })
                        .then(data => {
                            data.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.name; // Set the value to the city name
                                option.textContent = city.name; // Display the city name
                                birthMunicipalitySelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching cities:', error));
                }
            });
        });

</script>

<script>
// orders.php

function confirmDelete(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to reject this user? This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, reject!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX request to reject_user.php
            $.ajax({
                url: 'reject_user.php', // Point to the correct PHP file
                type: 'POST',
                data: { user_id: userId }, // Send user ID for deletion
                dataType: 'json',  // Expecting JSON in response
                success: function(response) {
                    console.log('Server Response:', response);  // Debugging
                    if (response.success) {
                        Swal.fire({
                            title: 'Rejected!',
                            text: 'The user has been rejected successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();  // Reload to reflect changes
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message || 'An unknown error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);  // Log errors
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while rejecting the user. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
}

</script>
<?php include 'components/script.php'; ?>


</body>
</html>
