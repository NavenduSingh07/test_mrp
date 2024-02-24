<?php include 'db_connect.php';
// Retrieve success and duplicate barcode data from URL parameters
$success_barcodes = isset($_GET['success_barcodes']) ? explode(",", $_GET['success_barcodes']) : [];
$duplicate_barcodes = isset($_GET['duplicate_barcodes']) ? explode(",", $_GET['duplicate_barcodes']) : [];
?>

<!doctype html>
<html lang="en">

<head>
  <title>Product Barcode Scanner</title>
  <link rel="icon" href="images/title.png" type="image/icon type">
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <style>
    .custom-navbar {
      background-color: #A20000;
      /* Add any other custom styles here */

    }
  </style>
  <style>
    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
      font-family: 'Lato', sans-serif;
    }

    .scan_input {
      padding: 10px;
      border: 2px dashed white;
      /* display: flex; */
      display: inline;
      justify-content: space-between;
      /* align-items:start; */
      font-weight: bold;
    }

    /*  input field styling */
    input[type="number"],
    input[type="text"] {
      padding: 6px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
      margin-bottom: 10px;
    }

    /* Highlight input fields on focus */
    input[type="number"]:focus,
    input[type="text"]:focus {
      border-color: #E08476;
      box-shadow: 0 0 5px rgba(224, 132, 118, 0.7);
    }
  </style>

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body style="background:#F5F5DC">
  <header>
    <!-- Navbar (You can customize this based on your needs) -->
    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar ">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <!-- Add your logo image here -->
          <img src="images/logo.png" alt="Your Logo" height="40" width="auto">
        </a>
      </div>
    </nav>
  </header>
  <br>
  <h2 class="text-center">Add Raw Material to Inventory</h2><br><br>

  <?php
  //Concatenate success and duplicate barcode messages
  $message = "";
  if (!empty($success_barcodes)) {
    $message .= "Barcodes successfully stored:\\n" . implode("\\n", $success_barcodes) . "\\n\\n";
  }

  if (!empty($duplicate_barcodes)) {
    $message .= "Duplicate Barcodes:\\n" . implode("\\n", $duplicate_barcodes) . "\\n\\n";
  }

  // Display popup with concatenated message
  if (!empty($message)) {
    echo "<script>alert('$message');</script>";
  }
  ?>


  <div class="container">
    <div class="row">
      <div class="col-9">
        <form id="barcodeForm" method="post" action="store_barcode.php" class="row gy-2 gx-3">
          <!-- <label for="product">Select Raw Material:</label>
                <select name="product" id="product">
                    <?php
                    $material_query = "SELECT * FROM materiallist";
                    $material_result = mysqli_query($conn, $material_query);

                    while ($row = mysqli_fetch_assoc($material_result)) {
                      echo "<option value='" . $row['material_id'] . "'>" . $row['material_name'] . "</option>";
                    }
                    ?>
                </select> -->
          <label for="product" style="font-weight: bold;">Select Raw Material:</label>
          <select name="product" id="product"
            style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            $material_query = "SELECT * FROM materiallist";
            $material_result = mysqli_query($conn, $material_query);

            while ($row = mysqli_fetch_assoc($material_result)) {
              echo "<option value='" . $row['material_id'] . "'>" . $row['material_name'] . "</option>";
            }
            ?>
          </select>

          <br>
          <label for="ptype" style="font-weight: bold;">Select Type:</label>
          <select name="ptype" id="ptype" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 5px;"
            disabled>
            <!-- Options will be dynamically populated based on the selected product -->
          </select>
          <br>
          <label for="brand" style="font-weight: bold;">Select Brand:</label>
          <select name="brand" id="brand" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 5px;"
            disabled>
            <!-- Options will be dynamically populated based on the selected product -->
          </select>
          <br>
          <label for="qperunit" style="font-weight: bold;">Quantity Per Unit:</label>
          <input type="text" name="qperunit" id="qperunit"
            style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 5px;" pattern="\d+(\.\d{1,2})?"
            title="Please enter a valid decimal number with up to two decimal points" required>
          <br>
          <div id="barcodeInputs"><br>
            <label for="barcode" class="scan_input">Scan Serial No.:</label>
            <input type="text" name="barcode[]" id="barcodeInput" autofocus>
            <br>
          </div>
          <br><br><br>
          <button type="button" id="addBarcodeBtn" class="btn btn-success">Add Units</button>
          <br>
      </div>

      <div class="col-2">
        <br>
        <input type="submit" name="submit" value="Submit" id="submitButton" class="btn btn-danger">

      </div>
      </form>
      <br>
      <div class="col-1">
        <div id="totalBox">
          <br>
          <label class="h3 text-danger">Total:</label>
          <span id="totalValue" class="text-primary">0</span>
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
</body>

</html>