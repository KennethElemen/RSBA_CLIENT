<?php
    // Pagination logic for 'No Benefits Pending Orders Tab'
    $limit_no_benefits = 10;
    $page_no_benefits = isset($_GET['page_no_benefits']) ? $_GET['page_no_benefits'] : 1;
    $offset_no_benefits = ($page_no_benefits - 1) * $limit_no_benefits;

    // Query to get pending users with no benefits and role = 'user'
    $no_benefits_query =  "SELECT 
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
        c.benefits = 'Pending'
       
    GROUP BY 
        ua.user_id, ua.email, ua.accountStatus, ua.account_id, u.first_name, u.middle_name, u.sur_name, u.date_of_birth
    LIMIT $limit_no_benefits OFFSET $offset_no_benefits"; 

    $result_no_benefits = $dbConnection->query($no_benefits_query);

    if ($result_no_benefits->num_rows > 0) {
        while ($row_no_benefits = $result_no_benefits->fetch_assoc()) {
            // Check if fields are not null before using them
            $user_id = htmlspecialchars($row_no_benefits['user_id'] ?? '');
            $email = htmlspecialchars($row_no_benefits['email'] ?? '');
            $full_name = htmlspecialchars($row_no_benefits['first_name'] . ' ' . $row_no_benefits['middle_name'] . ' ' . $row_no_benefits['sur_name'] ?? '');
            $account_status = htmlspecialchars($row_no_benefits['accountStatus'] ?? '');
            $phone_number = htmlspecialchars($row_no_benefits['phone_number'] ?? '');
            $date_of_birth = htmlspecialchars($row_no_benefits['date_of_birth'] ?? '');
            $sex = htmlspecialchars($row_no_benefits['sex'] ?? '');
            $birth_place = htmlspecialchars(($row_no_benefits['birth_municipality'] ?? '') . ', ' . ($row_no_benefits['birth_province'] ?? ''));
            $region = htmlspecialchars($row_no_benefits['region'] ?? '');
            $province = htmlspecialchars($row_no_benefits['province'] ?? '');
            $city_municipality = htmlspecialchars($row_no_benefits['city_municipality'] ?? '');
            $barangay = htmlspecialchars($row_no_benefits['barangay'] ?? '');
            $street_number = htmlspecialchars($row_no_benefits['street_number'] ?? '');
            $purok = htmlspecialchars($row_no_benefits['purok'] ?? '');
            $crop_name = htmlspecialchars($row_no_benefits['crop_name'] ?? '');
            $crop_area = htmlspecialchars($row_no_benefits['crop_area_hectares'] ?? '');
            $reference = htmlspecialchars($row_no_benefits['reference'] ?? '');
            $job_role = htmlspecialchars($row_no_benefits['job_role'] ?? '');
            $profile_picture = htmlspecialchars($row_no_benefits['profile_picture'] ?? '');

            echo '<tr>';
            echo '<td class="cell"><span class="truncate">' . htmlspecialchars($row_no_benefits['account_id']) . '</span></td>';
            echo '<td class="cell">' . $email . '</td>';
            echo '<td class="cell">' . $full_name . '</td>';
            echo '<td class="cell"><span class="badge bg-warning">' . ucfirst($account_status) . '</span></td>';
            
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
                        data-reference="' . $reference . '" 
                        data-job-role="' . $job_role . '"
                        data-profile-picture="' . $profile_picture . '">
                        <i class="fa-solid fa-eye text-white"></i>
                    </button>
                </td>';

            // Add the Reject button with confirmation
            echo '<td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $row_no_benefits['user_id'] . ')">
                        Reject
                    </button>
                </td>';
            
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="6" class="text-center">No pending users without benefits found</td></tr>';
    }

    // Calculate total pages for 'no benefits' pending users in No Benefits Pending Orders Tab
    $totalResult_no_benefits = $dbConnection->query("SELECT COUNT(*) as total FROM useraccounts ua LEFT JOIN Crops c ON ua.user_id = c.user_id WHERE ua.accountStatus = 'pending' AND ua.role = 'user' AND (c.benefits IS NULL OR c.benefits = '')");
    $totalRecords_no_benefits = $totalResult_no_benefits->fetch_assoc()['total'];
    $totalPages_no_benefits = ceil($totalRecords_no_benefits / $limit_no_benefits);
?>
