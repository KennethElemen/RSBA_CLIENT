<?php
include '../includes/dbconn.php';

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
    
    // Initialize an array to hold user data
    $userData = [];

    // Fetch user details from Users table
    $userQuery = $dbConnection->prepare("SELECT first_name, middle_name, sur_name, sex, date_of_birth, birth_municipality, birth_province FROM users WHERE user_id = ?");
    $userQuery->bind_param("i", $user_id);
    $userQuery->execute();
    $userResult = $userQuery->get_result();
    
    if ($userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();
    }
    
    // Fetch address
    $addressQuery = $dbConnection->prepare("SELECT CONCAT(street_number, ' ', purok, ', ', barangay, ', ', city_municipality, ', ', province, ', ', region) as address FROM addresses WHERE user_id = ? AND address_type = 'home'");
    $addressQuery->bind_param("i", $user_id);
    $addressQuery->execute();
    $addressResult = $addressQuery->get_result();
    
    if ($addressResult->num_rows > 0) {
        $userData['address'] = $addressResult->fetch_assoc()['address'];
    }

    // Fetch contact details
    $contactQuery = $dbConnection->prepare("SELECT phone_number FROM contacts WHERE user_id = ? AND contact_type = 'personal'");
    $contactQuery->bind_param("i", $user_id);
    $contactQuery->execute();
    $contactResult = $contactQuery->get_result();
    
    if ($contactResult->num_rows > 0) {
        $userData['contact_number'] = $contactResult->fetch_assoc()['phone_number'];
    }

    // Fetch job role
    $jobRoleQuery = $dbConnection->prepare("SELECT job_role FROM jobroles WHERE user_id = ?");
    $jobRoleQuery->bind_param("i", $user_id);
    $jobRoleQuery->execute();
    $jobRoleResult = $jobRoleQuery->get_result();
    
    if ($jobRoleResult->num_rows > 0) {
        $userData['job_role'] = $jobRoleResult->fetch_assoc()['job_role'];
    }

    // Fetch crops
    $cropsQuery = $dbConnection->prepare("SELECT GROUP_CONCAT(crop_name SEPARATOR ', ') as crops FROM crops WHERE user_id = ?");
    $cropsQuery->bind_param("i", $user_id);
    $cropsQuery->execute();
    $cropsResult = $cropsQuery->get_result();
    
    if ($cropsResult->num_rows > 0) {
        $userData['crops'] = $cropsResult->fetch_assoc()['crops'];
    }

    // Return the data as JSON
    echo json_encode($userData);
}
?>
