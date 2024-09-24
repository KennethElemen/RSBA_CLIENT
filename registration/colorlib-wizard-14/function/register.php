<?php
include '../../../RSBSA/includes/dbconn.php';

// Create a database connection
$dbConnection = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user input
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $middle_name = $conn->real_escape_string($_POST['middle_name']);
    $sur_name = $conn->real_escape_string($_POST['sur_name']);
    $sex = $conn->real_escape_string($_POST['sex']);
    $date_of_birth = $conn->real_escape_string($_POST['dateOfBirth']);
    $birth_municipality = $conn->real_escape_string($_POST['birthMunicipaltiy']);
    $birth_province = $conn->real_escape_string($_POST['birthProvince']);
    
    // Handling profile picture upload
    if (isset($_FILES['your_picture']) && $_FILES['your_picture']['error'] === 0) {
        $target_dir = "uploads/";
        $profile_picture = $target_dir . basename($_FILES["your_picture"]["name"]);
        move_uploaded_file($_FILES["your_picture"]["tmp_name"], $profile_picture);
    } else {
        $profile_picture = null;
    }

    // Insert into Users table
    $sql_users = "INSERT INTO Users (first_name, middle_name, sur_name, sex, date_of_birth, birth_municipality, birth_province, profile_picture)
                  VALUES ('$first_name', '$middle_name', '$sur_name', '$sex', '$date_of_birth', '$birth_municipality', '$birth_province', '$profile_picture')";

    if ($conn->query($sql_users) === TRUE) {
        $user_id = $conn->insert_id; // Get the last inserted user ID
        
        // Insert into Addresses table (home address)
        $region = $conn->real_escape_string($_POST['region']);
        $province = $conn->real_escape_string($_POST['province']);
        $city = $conn->real_escape_string($_POST['city']);
        $barangay = $conn->real_escape_string($_POST['barangay']);
        $street_number = $conn->real_escape_string($_POST['street_number']);
        $purok = $conn->real_escape_string($_POST['purok']);
        
        $sql_address = "INSERT INTO Addresses (user_id, region, province, city_municipality, barangay, street_number, purok, address_type)
                        VALUES ('$user_id', '$region', '$province', '$city', '$barangay', '$street_number', '$purok', 'home')";
        $conn->query($sql_address);

        // Insert into Contacts table (personal and emergency)
        $personal_phone = $conn->real_escape_string($_POST['number']);
        $emergency_phone = $conn->real_escape_string($_POST['emergencyNumber']);
        
        $sql_contact_personal = "INSERT INTO Contacts (user_id, phone_number, contact_type)
                                 VALUES ('$user_id', '$personal_phone', 'personal')";
        $sql_contact_emergency = "INSERT INTO Contacts (user_id, phone_number, contact_type)
                                  VALUES ('$user_id', '$emergency_phone', 'emergency')";
        $conn->query($sql_contact_personal);
        $conn->query($sql_contact_emergency);

        // Insert into Crops table
        $crop_name = $conn->real_escape_string($_POST['crop_name']);
        $crop_area = $conn->real_escape_string($_POST['crop_area']);
        
        $sql_crop = "INSERT INTO Crops (user_id, crop_name, crop_area_hectares)
                     VALUES ('$user_id', '$crop_name', '$crop_area')";
        $conn->query($sql_crop);

        // Insert into JobRoles table
        $job_role = $conn->real_escape_string($_POST['job']);
        $sql_job = "INSERT INTO JobRoles (user_id, job_role)
                    VALUES ('$user_id', '$job_role')";
        $conn->query($sql_job);

        // Insert into UserAccounts table
        $email = $conn->real_escape_string($_POST['email']);
        $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT);
        
        $sql_account = "INSERT INTO UserAccounts (user_id, email, password)
                        VALUES ('$user_id', '$email', '$password')";
        $conn->query($sql_account);
        header("Location: ../../../RSBSA/Public/login.php"); 
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $sql_users . "<br>" . $conn->error;
    }
}

$conn->close();
?>
