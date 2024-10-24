<?php
include '../includes/dbconn.php';

$dbConnection = new mysqli($servername, $username, $password, $dbname);
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

$limit = 10; 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query = "SELECT 
        ua.user_id, 
        ua.email, 
        ua.accountStatus, 
        ua.account_id,
        ua.role,  -- Retrieve the role from useraccounts
        u.first_name,
        u.middle_name,
        u.sur_name,
        u.date_of_birth,
        u.sex,
        u.birth_municipality,
        u.birth_province,
        u.profile_picture,  -- Include the profile picture here
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
        contacts co ON ua.user_id = co.user_id
    WHERE 
        ua.accountStatus IN ('accepted', 'Pending') 
        AND ua.role = 'staff'  -- Add this condition to filter for staff role
    GROUP BY 
        ua.user_id, ua.email, ua.accountStatus, ua.account_id, ua.role, u.first_name, u.middle_name, u.sur_name, u.date_of_birth, u.profile_picture
    LIMIT $limit OFFSET $offset";

$result = $dbConnection->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td class="cell"><span class="truncate">' . htmlspecialchars($row['account_id']) . '</span></td>';
        echo '<td class="cell">' . htmlspecialchars($row['email']) . '</td>';
        echo '<td class="cell">' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['middle_name']) . ' ' . htmlspecialchars($row['sur_name']) . '</td>';
    
        // Display status with appropriate badge
        if ($row['accountStatus'] == 'Pending') {
            echo '<td class="cell"><span class="badge bg-warning">' . ucfirst(htmlspecialchars($row['accountStatus'])) . '</span></td>';
        } elseif ($row['accountStatus'] == 'accepted') {
            echo '<td class="cell"><span class="badge bg-success">' . ucfirst(htmlspecialchars($row['accountStatus'])) . '</span></td>';
        }
        
        // Add View button with unique data attributes
        echo '<td>
                <button type="button" class="btn btn-primary btn-sm px-2"
                    data-bs-toggle="modal" 
                    data-bs-target="#viewModal" 
                    data-userid="' . $row['user_id'] . '" 
                    data-email="' . $row['email'] . '"
                    data-full-name="' . htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['sur_name']) . '"
                    data-account-status="' . htmlspecialchars($row['accountStatus']) . '"
                    data-phone-number="' . htmlspecialchars($row['phone_number']) . '"
                    data-date-of-birth="' . htmlspecialchars($row['date_of_birth']) . '"
                    data-sex="' . htmlspecialchars($row['sex']) . '"
                    data-birth-place="' . htmlspecialchars($row['birth_municipality'] . ',' . $row['birth_province']) . '"
                    data-region="' . htmlspecialchars($row['region']) . '"
                    data-province="' . htmlspecialchars($row['province']) . '"
                    data-city-municipality="' . htmlspecialchars($row['city_municipality']) . '"
                    data-barangay="' . htmlspecialchars($row['barangay']) . '"
                    data-street-number="' . htmlspecialchars($row['street_number']) . '"
                    data-purok="' . htmlspecialchars($row['purok']) . '"
                    data-crop-name="' . htmlspecialchars($row['crop_name']) . '"
                    data-crop-area="' . htmlspecialchars($row['crop_area_hectares']) . '"
                    data-benefits="' . htmlspecialchars($row['benefits']) . '"
                    data-reference="' . htmlspecialchars($row['reference']) . '"
                    data-profile-picture="' . htmlspecialchars($row['profile_picture']) . '">  
                    <i class="fa-solid fa-eye text-white"></i>
                </button>
            </td>';
        
        echo '<td>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $row['user_id'] . ')">
                    Reject
                </button>
            </td>';
        echo '</tr>';
        
    }
} else {
    echo '<tr><td colspan="9" class="text-center">No users found</td></tr>';
}

// Fetch total records for pagination
$totalResult = $dbConnection->query("SELECT COUNT(*) as total FROM useraccounts WHERE accountStatus IN ('accepted', 'Pending') AND role = 'staff'");
$totalRecords = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);
?>
