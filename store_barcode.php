<?php
include 'db_connect.php';

// Retrieve form data
$product = $_POST['product'];
$ptype = $_POST['ptype'];
$qperunit = $_POST['qperunit'];
$brand = $_POST['brand'];
$barcodes = $_POST['barcode'];

// Initialize arrays to store barcode statuses
$success_barcodes = [];
$duplicate_barcodes = [];

// Insert barcode data into the database
foreach ($barcodes as $barcode) {
    // Trim the barcode value and check if it's empty
    $barcode = trim($barcode);
    if (empty($barcode)) {
        continue; // Skip empty barcode
    }

    // Check if barcode already exists in the database for the same product and brand
    //$sql_check = "SELECT * FROM product_barcodes WHERE barcode = '$barcode' AND product = '$product' AND brand = '$brand'";
    $sql_check = "SELECT * FROM product_barcodes WHERE barcode = '$barcode'";
    $result_check = $conn->query($sql_check);
    if ($result_check->num_rows > 0) {
        // Barcode already exists, add to duplicate barcodes array
        $duplicate_barcodes[] = $barcode;
        continue; // Skip insertion for duplicate barcode
    }

    // Barcode is unique, insert into the database
    $sql = "INSERT INTO product_barcodes (product, ptype, qperunit, brand, barcode) VALUES ('$product', '$ptype', '$qperunit', '$brand', '$barcode')";
    if ($conn->query($sql) === TRUE) {
        // Barcode successfully inserted, add to success barcodes array
        $success_barcodes[] = $barcode;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();

// Redirect to addmaterial.php with success and duplicate barcode data as URL parameters
$success_barcodes_param = implode(",", $success_barcodes);
$duplicate_barcodes_param = implode(",", $duplicate_barcodes);
header("Location: addmaterial.php?success_barcodes=$success_barcodes_param&duplicate_barcodes=$duplicate_barcodes_param");
exit();
?>
