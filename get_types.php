<?php
// Include database connection file
include 'db_connect.php';

// Check if material_id is set and not empty
if (isset($_GET['material_id']) && !empty($_GET['material_id'])) {
    // Sanitize material_id to prevent SQL injection
    $material_id = mysqli_real_escape_string($conn, $_GET['material_id']);

    // Query to fetch types based on material_id
    $type_query = "SELECT * FROM materialtype WHERE material_id = $material_id";
    $type_result = mysqli_query($conn, $type_query);

    // Check if there are any types
    if (mysqli_num_rows($type_result) > 0) {
        // Output options for types
        while ($row = mysqli_fetch_assoc($type_result)) {
            echo "<option value='" . $row['mtype'] . "'>" . $row['mtype'] . "</option>";
        }
    } else {
        echo "<option value=''>No types found</option>";
    }
} else {
    // If material_id is not set or empty, output an error option
    echo "<option value=''>Invalid material</option>";
}

// Close database connection
mysqli_close($conn);
?>