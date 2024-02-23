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
$start_date = "";
$end_date = "";
$invoice_no = "";

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $invoice_no = $_POST["invoice_no"];

    // Fetch invoice data within the specified date range from the database
    $sql = "SELECT invoice.*, item.item_name, item.invoice_no, item.item_code, item.item_category, item.unit_price FROM invoice JOIN item ON invoice.invoice_no = item.invoice_no WHERE invoice.date BETWEEN '$start_date' AND '$end_date' AND item.invoice_no = '$invoice_no'";
    $result = $connection->query($sql);

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Display the fetched invoice data
        echo "<center><h2>Invoice Item Report<br>From $start_date to $end_date - invoice_no: $invoice_no</h2></center>";
        echo "<center><table border='1'>";
        echo "<tr>
                <th>Invoice No</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Item Name</th>
                <th>Item Code</th>
                <th>Item Category</th>
                <th>Unit Price</th>
            </tr>";

        // Loop through the result set and output data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["invoice_no"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["customer"] . "</td>";
            echo "<td>" . $row["item_name"] . "</td>";
            echo "<td>" . $row["item_code"] . "</td>";
            echo "<td>" . $row["item_category"] . "</td>";
            echo "<td>" . $row["unit_price"] . "</td>";
            echo "</tr>";
        }

        echo "</table></center>";
    } else {
        echo "No invoice data found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Invoice Item Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <br><br><h1><center>Invoice Item Report</center></h1><br>

    <!-- Form for selecting date range and searching -->
    <center>
    <form method="post" action="">
        <h3>Date Range</h3>
            
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>" required>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
        
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>" required><br><br>
            
                <br>
            <h3>Item</h3>
            <div class="col-sm-10 ">
                <label for="invoice_no">Invoice No</label>
                <input type="text" id="invoice_no" name="invoice_no" value="<?php echo $invoice_no; ?>" required><br><br>
            </div>

        <div class="row mb-10">
                <div class="offset-sm-6 col-sm-1 d-grid">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
        </div>
        </form>
    </center>
</body>
</html>

<?php
// Close the database connection
$connection->close();
?>
