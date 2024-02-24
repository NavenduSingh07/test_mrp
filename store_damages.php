<?php
include 'db_connect.php';

// Retrieve form data
$ptype = $_POST['ptype'];
$qperunit = $_POST['qperunit'];
$brand = $_POST['brand'];
$barcodes = $_POST['barcode'];

// Initialize arrays to store barcode statuses
$success_barcodes = [];

// Insert barcode data into the database
foreach ($barcodes as $barcode) {
    // Trim the barcode value and check if it's empty
    $barcode = trim($barcode);
    if (empty($barcode)) {
        continue; // Skip empty barcode
    }

}
// Barcode is unique, insert into the database for record purpose
$sql = "INSERT INTO damage_barcodes (ptype, qperunit, brand, barcode) VALUES ('$ptype', '$qperunit', '$brand', '$barcode')";
if ($conn->query($sql) === TRUE) {
    // Barcode successfully inserted, add to success barcodes array
    $success_barcodes[] = $barcode;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();

// Redirect to addmaterial.php with success and duplicate barcode data as URL parameters
$success_barcodes_param = implode(",", $success_barcodes);
// $duplicate_barcodes_param = implode(",", $duplicate_barcodes);
header("Location: damages.php?success_barcodes=$success_barcodes_param");
exit();
?>