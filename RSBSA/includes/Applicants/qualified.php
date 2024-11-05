<?php

include '../includes/dbconn.php';

$dbConnection = new mysqli($servername, $username, $password, $dbname);
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

// Pagination logic for 'Paid Orders Tab'
$limit_paid = 10; 
$page_paid = isset($_GET['page_paid']) ? $_GET['page_paid'] : 1;
$offset_paid = ($page_paid - 1) * $limit_paid;

// Query to fetch paid orders
$paid_query =  "SELECT 
    ua.user_id,     
    ua.email, 
    ua.accountStatus, 
    ua.account_id,
    u.first_name,
    u.middle_name,
    u.sur_name,
    u.date_of_birth,
    u.sex,
    u.birth_municipality,
    u.birth_province,
    u.profile_picture,
    MAX(a.region) AS region, 
    MAX(a.province) AS province, 
    MAX(a.city_municipality) AS city_municipality, 
    MAX(a.barangay) AS barangay, 
    MAX(a.street_number) AS street_number, 
    MAX(a.purok) AS purok, 
    MAX(c.crop_name) AS crop_name, 
    MAX(c.crop_area_hectares) AS crop_area_hectares, 
    MAX(c.benefits) AS benefits, 
    MAX(c.reference) AS reference, 
    MAX(j.job_role) AS job_role, 
    MAX(co.phone_number) AS phone_number
FROM 
    useraccounts ua
JOIN 
    Users u ON ua.user_id = u.user_id
LEFT JOIN 
    Addresses a ON ua.user_id = a.user_id
LEFT JOIN 
    Crops c ON ua.user_id = c.user_id
LEFT JOIN 
    JobRoles j ON ua.user_id = j.user_id
LEFT JOIN 
    contacts co ON ua.user_id = co.user_id
WHERE 
    ua.accountStatus = 'accepted'
    AND ua.role = 'user'  -- Filter to include only users with role 'user'
GROUP BY 
    ua.user_id, ua.email, ua.accountStatus, ua.account_id, u.first_name, u.middle_name, u.sur_name, u.date_of_birth
LIMIT $limit_paid OFFSET $offset_paid"; // Corrected pagination variables

$result_paid = $dbConnection->query($paid_query);

if ($result_paid->num_rows > 0) {
    while ($row_paid = $result_paid->fetch_assoc()) {
        // Check if fields are not null before using them
        $user_id = htmlspecialchars($row_paid['user_id'] ?? '');
        $email = htmlspecialchars($row_paid['email'] ?? '');
        $full_name = htmlspecialchars(($row_paid['first_name'] ?? '') . ' ' . ($row_paid['middle_name'] ?? '') . ' ' . ($row_paid['sur_name'] ?? ''));
        $account_status = htmlspecialchars($row_paid['accountStatus'] ?? '');
        $phone_number = htmlspecialchars($row_paid['phone_number'] ?? '');
        $date_of_birth = htmlspecialchars($row_paid['date_of_birth'] ?? '');
        $sex = htmlspecialchars($row_paid['sex'] ?? '');
        $birth_place = htmlspecialchars(($row_paid['birth_municipality'] ?? '') . ', ' . ($row_paid['birth_province'] ?? ''));
        $region = htmlspecialchars($row_paid['region'] ?? '');
        $province = htmlspecialchars($row_paid['province'] ?? '');
        $city_municipality = htmlspecialchars($row_paid['city_municipality'] ?? '');
        $barangay = htmlspecialchars($row_paid['barangay'] ?? '');
        $street_number = htmlspecialchars($row_paid['street_number'] ?? '');
        $purok = htmlspecialchars($row_paid['purok'] ?? '');
        $crop_name = htmlspecialchars($row_paid['crop_name'] ?? '');
        $crop_area = htmlspecialchars($row_paid['crop_area_hectares'] ?? '');
        $benefits = htmlspecialchars($row_paid['benefits'] ?? 'Not Available'); // Display 'Not Available' if null
        $reference = htmlspecialchars($row_paid['reference'] ?? '');
        $job_role = htmlspecialchars($row_paid['job_role'] ?? '');
        $profile_picture = htmlspecialchars($row_paid['profile_picture'] ?? '');

        echo '<tr>';
        echo '<td class="cell"><span class="truncate">' . htmlspecialchars($row_paid['account_id'] ?? '') . '</span></td>';
        echo '<td class="cell">' . $email . '</td>';
        echo '<td class="cell">' . $full_name . '</td>';
        echo '<td class="cell"><span class="badge bg-success">' . ucfirst($account_status) . '</span></td>';
        echo '<td class="cell">' . $benefits . '</td>'; // Echoing actual benefits value

        // Button to open the modal with user details
        echo '<td class="cell">
                <button type="button" class="btn btn-primary btn-sm px-2"
                    data-bs-toggle="modal" 
                    data-bs-target="#viewModal" 
                    data-userid="' . $user_id . '" 
                    data-email="' . $email . '"
                    data-full-name="' . $full_name . '"
                    data-account-status="' . $account_status . '" 
                    data-phone-number="' . $phone_number . '"
                    data-date-of-birth="' . $date_of_birth . '" 
                    data-sex="' . $sex . '"
                    data-birth-place="' . $birth_place . '"
                    data-region="' . $region . '" 
                    data-province="' . $province . '" 
                    data-city-municipality="' . $city_municipality . '" 
                    data-barangay="' . $barangay . '" 
                    data-street-number="' . $street_number . '" 
                    data-purok="' . $purok . '" 
                    data-crop-name="' . $crop_name . '" 
                    data-crop-area="' . $crop_area . '" 
                    data-benefits="' . $benefits . '" 
                    data-reference="' . $reference . '" 
                    data-job-role="' . $job_role . '"
                    data-profile-picture="' . $profile_picture . '">
                    <i class="fa-solid fa-eye text-white"></i>
                </button>
            </td>';
        
        

        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6" class="text-center">No accepted users found</td></tr>';
}

// Calculate total pages for 'accepted' users in Paid Orders Tab
$totalResult_paid = $dbConnection->query("SELECT COUNT(*) as total FROM useraccounts WHERE accountStatus = 'accepted' AND role = 'user'");
$totalRecords_paid = $totalResult_paid->fetch_assoc()['total'];
$totalPages_paid = ceil($totalRecords_paid / $limit_paid);
?>