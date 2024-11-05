<?php
// Database connection
include '../includes/dbconn.php'; // Make sure this path is correct

// Fetch data from the database using INNER JOIN
$query = "
    SELECT 
        ua.account_id, 
        ua.email, 
        CONCAT(u.first_name, ' ', u.middle_name, ' ', u.sur_name) AS full_name, 
        ua.accountStatus, 
        MAX(c.benefits) AS benefits,
        MAX(j.job_role) AS job_role,
        MAX(a.region) AS region, 
        MAX(a.province) AS province, 
        MAX(a.city_municipality) AS city_municipality, 
        MAX(a.barangay) AS barangay, 
        MAX(a.street_number) AS street_number, 
        MAX(a.purok) AS purok, 
        MAX(co.phone_number) AS phone_number,
        u.birth_municipality,  -- Retrieve birth_municipality from Users table
        u.birth_province       -- Retrieve birth_province from Users table
    FROM 
        useraccounts ua
    INNER JOIN 
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
        AND ua.role = 'user'
    GROUP BY 
        ua.account_id, ua.email, ua.accountStatus
"; // Adjusted query to include birthplace fields from Users

$result = mysqli_query($conn, $query);

// Check if there are results
if (mysqli_num_rows($result) > 0) {
    // Set headers for Excel file
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename=data_export.xls');

    // Output the column headers
    echo '<table border="1">';
    echo '<tr>'; 
    echo '<th>Account ID</th>';
    echo '<th>Email</th>';
    echo '<th>Full Name</th>';
    echo '<th>Status</th>';
    echo '<th>Benefits</th>';
    echo '<th>Job Role</th>';
    echo '<th>Farm Address</th>'; // Consolidated address column
    echo '<th>Birthplace</th>'; // Concatenated birthplace column
    echo '<th>Phone Number</th>';
    echo '</tr>';

    // Write data rows
    while ($row = mysqli_fetch_assoc($result)) {
        // Consolidate address into one column
        $address = trim(implode(', ', array_filter([
            $row['street_number'] ?? '',
            $row['barangay'] ?? '',
            $row['city_municipality'] ?? '',
            $row['province'] ?? '',
            $row['region'] ?? ''
        ])));

        // Concatenate birthplace into one column
        $birthplace = trim(implode(', ', array_filter([
            $row['birth_municipality'] ?? '',
            $row['birth_province'] ?? ''
        ])));

        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['account_id']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . htmlspecialchars($row['full_name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['accountStatus']) . '</td>';
        echo '<td>' . htmlspecialchars($row['benefits'] ?? 'Not Available') . '</td>'; // Default to 'Not Available' if null
        echo '<td>' . htmlspecialchars($row['job_role'] ?? 'Not Available') . '</td>';
        echo '<td>' . htmlspecialchars($address ?: 'Not Available') . '</td>'; // Output consolidated address
        echo '<td>' . htmlspecialchars($birthplace ?: 'Not Available') . '</td>'; // Birthplace column
        echo '<td>' . htmlspecialchars($row['phone_number'] ?? 'Not Available') . '</td>';
        echo '</tr>';
    }

    echo '</table>';
    exit(); // Stop further script execution
} else {
    // No data available for export
    echo "No data available for export.";
}
?>
