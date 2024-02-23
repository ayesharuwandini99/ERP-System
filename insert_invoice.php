<?php
// Step 1: Establish a connection to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$database = "erp_db";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Initialize variables to store form data
$date = "";
$time = "";
$invoice_no = "";
$customer = "";
$quantity = ""; // Corrected variable name
$amount = "";

$errorMessage = "";
$successMessage = "";

//Fetch customer IDs from the database
$idQuery = "SELECT id FROM customer";
$idResult = $connection->query($idQuery);
$customerIDs = []; // Corrected variable name
if ($idResult) {
    while ($row = $idResult->fetch_assoc()) {
        $customerIDs[] = $row['id']; // Corrected variable name
    }
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $date  = $_POST["date"];
    $time = $_POST["time"];
    $invoice_no = $_POST["invoice_no"];
    $customer = $_POST["customer"];
    $quantity = $_POST["quantity"]; // Corrected variable name
    $amount = $_POST["amount"];

    // Validate form data
    if (empty($date) || empty($time) || empty($invoice_no) || empty($customer) || empty($quantity) || empty($amount)) {
        $errorMessage = "All fields are required";
    } else {
        // Insert data into database
        $sql = "INSERT INTO invoice(date, time, invoice_no, customer, quantity, amount) VALUES ('$date', '$time', '$invoice_no', '$customer', '$quantity', '$amount')";

        if ($connection->query($sql) === TRUE) {
            $successMessage = "Invoice added successfully";
        } else {
            $errorMessage = "Error: " . $sql . "<br>" . $connection->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <br><h1>Invoice</h1><br>

        <!-- Display error or success messages -->
        <?php
        if (!empty($errorMessage)) {
            echo "<div class='alert alert-danger' role='alert'>$errorMessage</div>";
        }
        if (!empty($successMessage)) {
            echo "<div class='alert alert-success' role='alert'>$successMessage</div>";
        }
        ?>

        <!-- Form for adding invoice report -->
        <form method="POST">
            <div class="row mb-3">
                <label for="date" class="col-sm-2 col-form-label">Date</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="date" name="date" value="<?php echo $date; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label for="time" class="col-sm-2 col-form-label">Time</label>
                <div class="col-sm-10">
                    <input type="time" class="form-control" id="time" name="time" value="<?php echo $time; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label for="invoice_no" class="col-sm-2 col-form-label">Invoice No</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="invoice_no" name="invoice_no" value="<?php echo $invoice_no; ?>">
                </div>
            </div>

            <div class="row mb-3 ">
                <label for="customer" class="col-sm-2 col-form-label">Customer</label>
                <div class="col-sm-10">
                    <select class="form-select" id="customer" name="customer">
                        <option value="">Select Customer</option>
                        <?php foreach ($customerIDs as $id) { ?>
                            <option value="<?php echo $id; ?>" <?php if ($customer == $id) echo 'selected="selected"'; ?>><?php echo $id; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $quantity; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="amount" name="amount" value="<?php echo $amount; ?>">
                </div>
            </div>

            <div class="row mb-3 ">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/sales/index2.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>

</body>
</html>

<?php
// Close the database connection
$connection->close();
?>
