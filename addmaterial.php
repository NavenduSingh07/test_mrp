<?php include 'db_connect.php';
// Retrieve success and duplicate barcode data from URL parameters
$success_barcodes = isset($_GET['success_barcodes']) ? explode(",", $_GET['success_barcodes']) : [];
$duplicate_barcodes = isset($_GET['duplicate_barcodes']) ? explode(",", $_GET['duplicate_barcodes']) : [];
?>

<!doctype html>
<html lang="en">

<head>
    <title>Add to Inventory</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            margin-top: 30px;
        }

        h2 {
            color: #A20000 !important;
            font-weight: bold !important;
        }

        /* Form Styles */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        select,
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        select:disabled {
            background-color: #f8f9fa;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        #totalBox {
            background-color: #A20000;
            padding: 10px;
            border-radius: 4px ;
            text-align: center;
            color:#fff;
        }

        /* Button Style */
        #submitButton {
            padding: 10px 20px;
            background-color: #28a745;
            /* Green color */
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #submitButton:hover {
            background-color: #218838;
            /* Darker green color on hover */
        }


        /* Responsive Styles */
        @media (max-width: 768px) {
            .col-8 {
                width: 100%;
                margin-bottom: 20px;
            }

            .col {
                text-align: center;
            }
        }
    </style>

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>


    <h2 class="text-center">Add Raw Material to Inventory</h2>


    <?php
    // Concatenate success and duplicate barcode messages
    $message = "";
    if (!empty($success_barcodes)) {
        $message .= "Barcodes successfully stored:\\n" . implode("\\n", $success_barcodes) . "\\n\\n";
    }

    if (!empty($duplicate_barcodes)) {
        $message .= "Duplicate Barcodes:\\n" . implode("\\n", $duplicate_barcodes) . "\\n\\n";
    }

    // Display SweetAlert2 with concatenated message
    if (!empty($message)) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Message',
                html: '$message',
                icon: 'info'
            });
        });
    </script>";
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <form id="barcodeForm" method="post" action="store_barcode.php">
                    <label for="product">Select Raw Material:</label>
                    <select name="product" id="product">
                        <?php
                        $material_query = "SELECT * FROM materiallist";
                        $material_result = mysqli_query($conn, $material_query);

                        while ($row = mysqli_fetch_assoc($material_result)) {
                            echo "<option value='" . $row['material_id'] . "'>" . $row['material_name'] . "</option>";
                        }
                        ?>
                    </select>
                    <br><br>
                    <label for="ptype">Select Type:</label>
                    <select name="ptype" id="ptype" disabled>
                        <!-- Options will be dynamically populated based on the selected product -->
                    </select>
                    <br><br>
                    <label for="brand">Select Brand:</label>
                    <select name="brand" id="brand" disabled>
                        <!-- Options will be dynamically populated based on the selected product -->
                    </select>
                    <br><br>
                    <label for="qperunit">Quantity Per Unit:</label>
                    <input type="text" name="qperunit" id="qperunit" pattern="\d+(\.\d{1,2})?"
                        title="Please enter a valid decimal number with up to two decimal points" required>
                    <br><br>
                    <div id="barcodeInputs">
                        <label for="barcode">Scan Serial No.:</label>
                        <input type="text" name="barcode[]" id="barcodeInput" autofocus>
                        <br><br>
                    </div>
                    <button type="button" id="addBarcodeBtn">Add Units</button>
                    <br><br>
            </div>
            <div class="col">
                <input type="submit" name="submit" value="Submit" id="submitButton">
            </div>
            </form>
            <br>
            <div class="col">
                <div id="totalBox">
                    <label>Total:</label>
                    <span id="totalValue">0</span>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('product').addEventListener('change', function () {
            var productId = this.value;
            var typeDropdown = document.getElementById('ptype');
            var brandDropdown = document.getElementById('brand');

            // Enable dropdowns
            typeDropdown.disabled = false;
            brandDropdown.disabled = false;

            // Clear existing options
            typeDropdown.innerHTML = '<option value="">Select Type</option>';
            brandDropdown.innerHTML = '<option value="">Select Brand</option>';

            // Fetch types based on selected product using AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    typeDropdown.innerHTML += xhr.responseText;
                }
            };
            xhr.open("GET", "get_types.php?material_id=" + productId, true);
            xhr.send();

            // Fetch brands based on selected product using AJAX
            var xhr2 = new XMLHttpRequest();
            xhr2.onreadystatechange = function () {
                if (xhr2.readyState == 4 && xhr2.status == 200) {
                    brandDropdown.innerHTML += xhr2.responseText;
                }
            };
            xhr2.open("GET", "get_brands.php?material_id=" + productId, true);
            xhr2.send();
        });

        // Function to handle barcode scanning
        function handleBarcodeScan(event) {
            // Get the value of the barcode input field
            var barcodeValue = document.getElementById("barcodeInput").value.trim();
            // Check if the barcode value is not empty
            if (barcodeValue !== "") {
                // Trigger "Add Barcode" button click when a non-blank barcode is scanned
                document.getElementById("addBarcodeBtn").click();
            }
            // Clear the barcode input field
            document.getElementById("barcodeInput").value = "";
            // Set focus back to the original barcode input field
            document.getElementById("barcodeInput").focus();
        }

        // Add event listener to barcode input field
        document.getElementById("barcodeInput").addEventListener("keydown", function (event) {
            // Check if the "Enter" key was pressed (key code 13) or a Tab (key code 9)
            if (event.keyCode === 13 || event.keyCode === 9) {
                // Prevent the default behavior of "Enter" key or Tab
                event.preventDefault();
                // Handle barcode scan
                handleBarcodeScan(event);
            }
        });

        // Add event listener to "Add Barcode" button
        document.getElementById("addBarcodeBtn").addEventListener("click", function (event) {
            var inputClone = document.querySelector('input[name="barcode[]"]').cloneNode(true);
            // Get the value of the cloned barcode input field
            var clonedBarcodeValue = inputClone.value.trim();
            // Check if the cloned barcode input field has a non-blank value
            if (clonedBarcodeValue !== "") {
                document.getElementById("barcodeInputs").appendChild(document.createElement("br"));
                document.getElementById("barcodeInputs").appendChild(inputClone);
                inputClone.focus(); // Focus on the new input field
                updateTotal(); // Update total quantity
            }
        });

        // Function to update total quantity
        function updateTotal() {
            var qperunit = parseFloat(document.getElementById("qperunit").value);
            var barcodeInputs = document.querySelectorAll('input[name="barcode[]"]');
            var total = qperunit * barcodeInputs.length - qperunit;
            document.getElementById("totalValue").innerText = total;
        }

        document.getElementById("barcodeInput").focus(); // Focus on the first input field initially
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>