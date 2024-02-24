<?php
include 'db_connect.php'; // Include your database connection file

// Define variables
$barcode = "";
$ptype = "";
$qperunit = "";
$brand = "";
$datetime = "";

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If the retrieve details button is clicked
    if (isset($_POST['submit'])) {
        // Retrieve barcode from form
        $barcode = $_POST['barcode'];

        // Query to retrieve details of the product from stock_barcodes table
        $sql = "SELECT ptype, qperunit, brand, datetime FROM stock_barcodes WHERE barcode = '$barcode'";
        $result = $conn->query($sql);

        // If a record is found, retrieve and display details
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $ptype = $row['ptype'];
            $qperunit = $row['qperunit'];
            $brand = $row['brand'];
            $datetime = $row['datetime'];
        } else {
            // If no record is found, display a message
            $message = "No details found for the scanned barcode.";
        }
    }

    // If the remove button is clicked
    if (isset($_POST['remove'])) {
        // Retrieve barcode from form
        $barcode = $_POST['barcode'];

        // Query to delete the stock entry associated with the scanned barcode
        $sql_delete = "DELETE FROM stock_barcodes WHERE barcode = '$barcode'";
        if ($conn->query($sql_delete) === TRUE) {
            // Store ptype, brand, and qperunit before clearing the variables
            $ptype = $_POST['ptype'];
            $brand = $_POST['brand'];
            $qperunit = $_POST['qperunit'];

            // Clear the variables
            $datetime = "";

            // Query to add material to buffer stock
            $sql2 = "INSERT INTO bufferstock_barcodes (ptype, qperunit, brand, barcode) VALUES ('$ptype', '$qperunit', '$brand', '$barcode')";
            if ($conn->query($sql2) === FALSE) {
                $message = "Error updating bufferstock_barcodes: " . $conn->error;
            }

            // Query to update the total 
            $sql3 = "UPDATE `stock` SET `quantity` = Quantity - $qperunit WHERE `ptype` = '$ptype' AND `brand` = '$brand'";
            if ($conn->query($sql3) === TRUE) {
                $message = "Stock Updated successfully.";
            } else {
                $message = "Error updating stock quantity: " . $conn->error;
            }
        } else {
            $message = "Error removing stock: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Out from Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #A20000;
            font-weight: bold;
            text-align: center;
        }

        form {
            margin: 20px auto;
            padding: 20px;
            max-width: 400px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .ret{
            background-color: #A20000;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .assign{
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .ret:hover {
            background-color: #bd2e2e;
        }

        .assign:hover {
            background-color: #218838;
        }

        h3 {
            color: #A20000;
            font-weight: bold;
            text-align: center;
        }

        p {
            margin-bottom: 10px;
            text-align: center;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>
    <h2>Assign Stock from Inventory for Manufacturing</h2>
    <!-- Form to scan barcode -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="barcode">Scan Barcode:</label>
        <input type="text" name="barcode" id="barcodeInput" autofocus>
        <br><br>
        <input class="ret" type="submit" name="submit" value="Retrieve Details">
    </form>

    <!-- Display product details -->
    <?php if ($barcode != ""): ?>
        <h3>Product Details</h3>
        <p>Product Type:
            <?php echo $ptype; ?>
        </p>
        <p>Quantity Per Unit:
            <?php echo $qperunit; ?>
        </p>
        <p>Brand:
            <?php echo $brand; ?>
        </p>
        <p>Datetime:
            <?php echo $datetime; ?>
        </p>
        <!-- Form to remove stock -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="barcode" value="<?php echo $barcode; ?>">
            <input type="hidden" name="ptype" value="<?php echo $ptype; ?>">
            <input type="hidden" name="brand" value="<?php echo $brand; ?>">
            <input type="hidden" name="qperunit" value="<?php echo $qperunit; ?>">
            <input class="assign" type="submit" name="remove" value="Assign Stock">
        </form>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        <?php if (isset($message)): ?>
            Swal.fire({
                icon: '<?php echo (strpos($message, "successfully") !== false) ? "success" : "error"; ?>',
                title: '<?php echo $message; ?>'
            });
        <?php endif; ?>
    </script>
</body>

</html>