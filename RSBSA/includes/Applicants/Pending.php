<?php
    // Pagination logic for 'Pending Orders Tab'
    $limit_pending = 10;
    $page_pending = isset($_GET['page_pending']) ? $_GET['page_pending'] : 1;
    $offset_pending = ($page_pending - 1) * $limit_pending;

    $pending_query =  "SELECT 
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
        ua.accountStatus IN ('pending') 
    GROUP BY 
        ua.user_id, ua.email, ua.accountStatus, ua.account_id, u.first_name, u.middle_name, u.sur_name, u.date_of_birth
    LIMIT $limit_pending OFFSET $offset_pending"; 

    $result_pending = $dbConnection->query($pending_query);

    if ($result_pending->num_rows > 0) {
        while ($row_pending = $result_pending->fetch_assoc()) {
            // Check if fields are not null before using them
            $user_id = htmlspecialchars($row_pending['user_id'] ?? '');
            $email = htmlspecialchars($row_pending['email'] ?? '');
            $full_name = htmlspecialchars($row_pending['first_name'] . ' ' . $row_pending['middle_name'] . ' ' . $row_pending['sur_name'] ?? '');
            $account_status = htmlspecialchars($row_pending['accountStatus'] ?? '');
            $phone_number = htmlspecialchars($row_pending['phone_number'] ?? '');
            $date_of_birth = htmlspecialchars($row_pending['date_of_birth'] ?? '');
            $sex = htmlspecialchars($row_pending['sex'] ?? '');
            $birth_place = htmlspecialchars(($row_pending['birth_municipality'] ?? '') . ', ' . ($row_pending['birth_province'] ?? ''));
            $region = htmlspecialchars($row_pending['region'] ?? '');
            $province = htmlspecialchars($row_pending['province'] ?? '');
            $city_municipality = htmlspecialchars($row_pending['city_municipality'] ?? '');
            $barangay = htmlspecialchars($row_pending['barangay'] ?? '');
            $street_number = htmlspecialchars($row_pending['street_number'] ?? '');
            $purok = htmlspecialchars($row_pending['purok'] ?? '');
            $crop_name = htmlspecialchars($row_pending['crop_name'] ?? '');
            $crop_area = htmlspecialchars($row_pending['crop_area_hectares'] ?? '');
            $benefits = htmlspecialchars($row_pending['benefits'] ?? '');
            $reference = htmlspecialchars($row_pending['reference'] ?? '');
            $job_role = htmlspecialchars($row_pending['job_role'] ?? '');
            $profile_picture = htmlspecialchars($row_pending['profile_picture'] ?? '');

            echo '<tr>';
            echo '<td class="cell"><span class="truncate">' . htmlspecialchars($row_pending['account_id']) . '</span></td>';
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
                        data-benefits="' . $benefits . '" 
                        data-reference="' . $reference . '" 
                        data-job-role="' . $job_role . '"
                        data-profile-picture="' . $profile_picture . '">
                        <i class="fa-solid fa-eye text-white"></i>
                    </button>
                </td>';

            // Add the Reject button with confirmation
            echo '<td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $row_pending['user_id'] . ')">
                        Reject
                    </button>
                </td>';
            
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="6" class="text-center">No pending users found</td></tr>';
    }

    // Calculate total pages for 'pending' users in Pending Orders Tab
    $totalResult_pending = $dbConnection->query("SELECT COUNT(*) as total FROM useraccounts WHERE accountStatus = 'pending'");
    $totalRecords_pending = $totalResult_pending->fetch_assoc()['total'];
    $totalPages_pending = ceil($totalRecords_pending / $limit_pending);
?>
