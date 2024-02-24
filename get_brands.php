<?php
// Include database connection file
include 'db_connect.php';

// Check if material_id is set and not empty
if (isset($_GET['material_id']) && !empty($_GET['material_id'])) {
    // Sanitize material_id to prevent SQL injection
    $material_id = mysqli_real_escape_string($conn, $_GET['material_id']);

    // Query to fetch brands based on material_id
    $brand_query = "SELECT * FROM companylist WHERE material_id = $material_id";
    $brand_result = mysqli_query($conn, $brand_query);

    // Check if there are any brands
    if (mysqli_num_rows($brand_result) > 0) {
        // Output options for brands
        while ($row = mysqli_fetch_assoc($brand_result)) {
            echo "<option value='" . $row['cname'] . "'>" . $row['cname'] . "</option>";
        }
    } else {
        echo "<option value=''>No brands found</option>";
    }
} else {
    // If material_id is not set or empty, output an error option
    echo "<option value=''>Invalid material</option>";
}

// Close database connection
mysqli_close($conn);
?>