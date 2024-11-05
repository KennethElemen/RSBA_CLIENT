
<?php
// Pagination logic for 'Not Qualified Orders Tab'
$limit_not_qualified = 10;
$page_not_qualified = isset($_GET['page_not_qualified']) ? $_GET['page_not_qualified'] : 1;
$offset_not_qualified = ($page_not_qualified - 1) * $limit_not_qualified;

$not_qualified_query =  "SELECT 
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
    AND (c.benefits IS NULL OR c.benefits = '')  -- Filter to show only 'Not Qualified' based on empty benefits
GROUP BY 
    ua.user_id, ua.email, ua.accountStatus, ua.account_id, u.first_name, u.middle_name, u.sur_name, u.date_of_birth
LIMIT $limit_not_qualified OFFSET $offset_not_qualified";

$result_not_qualified = $dbConnection->query($not_qualified_query);

if ($result_not_qualified->num_rows > 0) {
    while ($row_not_qualified = $result_not_qualified->fetch_assoc()) {
        // Check if fields are not null before using them
        $user_id = htmlspecialchars($row_not_qualified['user_id'] ?? '');
        $email = htmlspecialchars($row_not_qualified['email'] ?? '');
        $full_name = htmlspecialchars(($row_not_qualified['first_name'] ?? '') . ' ' . ($row_not_qualified['middle_name'] ?? '') . ' ' . ($row_not_qualified['sur_name'] ?? ''));
        $account_status = htmlspecialchars($row_not_qualified['accountStatus'] ?? '');
        $phone_number = htmlspecialchars($row_not_qualified['phone_number'] ?? '');
        $date_of_birth = htmlspecialchars($row_not_qualified['date_of_birth'] ?? '');
        $sex = htmlspecialchars($row_not_qualified['sex'] ?? '');
        $birth_place = htmlspecialchars(($row_not_qualified['birth_municipality'] ?? '') . ', ' . ($row_not_qualified['birth_province'] ?? ''));
        $region = htmlspecialchars($row_not_qualified['region'] ?? '');
        $province = htmlspecialchars($row_not_qualified['province'] ?? '');
        $city_municipality = htmlspecialchars($row_not_qualified['city_municipality'] ?? '');
        $barangay = htmlspecialchars($row_not_qualified['barangay'] ?? '');
        $street_number = htmlspecialchars($row_not_qualified['street_number'] ?? '');
        $purok = htmlspecialchars($row_not_qualified['purok'] ?? '');
        $crop_name = htmlspecialchars($row_not_qualified['crop_name'] ?? '');
        $crop_area = htmlspecialchars($row_not_qualified['crop_area_hectares'] ?? '');
        $benefits = htmlspecialchars($row_not_qualified['benefits'] ?? '');
        $reference = htmlspecialchars($row_not_qualified['reference'] ?? '');
        $job_role = htmlspecialchars($row_not_qualified['job_role'] ?? '');
        $profile_picture = htmlspecialchars($row_not_qualified['profile_picture'] ?? '');

        // Determine benefits status as 'Not Qualified'
        $benefits_status = '<span class="badge bg-secondary">Not Qualified</span>';

        echo '<tr>';
        echo '<td class="cell"><span class="truncate">' . htmlspecialchars($row_not_qualified['account_id'] ?? '') . '</span></td>';
        echo '<td class="cell">' . $email . '</td>';
        echo '<td class="cell">' . $full_name . '</td>';
        echo '<td class="cell"><span class="badge bg-success">' . ucfirst($account_status) . '</span></td>';
        echo '<td class="cell">' . $benefits_status . '</td>';

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
        
        // Reject button
        echo '<td>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $user_id . ')">
                    Reject
                </button>
            </td>';

        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6" class="text-center">No Not Qualified users found</td></tr>';
}

// Calculate total pages for 'not qualified' users in Not Qualified Orders Tab
$totalResult_not_qualified = $dbConnection->query("SELECT COUNT(*) as total FROM useraccounts ua LEFT JOIN Crops c ON ua.user_id = c.user_id WHERE ua.accountStatus = 'accepted' AND ua.role = 'user' AND (c.benefits IS NULL OR c.benefits = '')");
$totalRecords_not_qualified = $totalResult_not_qualified->fetch_assoc()['total'];
$totalPages_not_qualified = ceil($totalRecords_not_qualified / $limit_not_qualified);
?>
