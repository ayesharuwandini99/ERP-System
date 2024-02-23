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

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    // Fetch invoice data within the specified date range from the database
    $sql = "SELECT * FROM invoice WHERE date BETWEEN '$start_date' AND '$end_date'";
    $result = $connection->query($sql);

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Display the fetched invoice data
        echo "<center><h2>Invoice Report <br>$start_date to $end_date</h2></center>";
        echo "<center><table class='table table-striped table-hover' border='4'>";
        echo "<tr>
                <th>Date</th>
                <th>Time</th>
                <th>Invoice No</th>
                <th>Customer</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>";

        // Loop through the result set and output data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["time"] . "</td>";
            echo "<td>" . $row["invoice_no"] . "</td>";
            echo "<td>" . $row["customer"] . "</td>";
            echo "<td>" . $row["quantity"] . "</td>";
            echo "<td>" . $row["amount"] . "</td>";
            echo "</tr>";
        }

        echo "</table></center>";
    } else {
        echo "No invoice data found for the selected date range.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Invoice Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <br><br><h1><center>Invoice Report</center></h1><br>

    <!-- Form for selecting date range and searching -->
    <div class="container">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="row mb-3">

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="col-sm-3">
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>" required>
                </div>
                <div class="col-sm-3">
                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>" required>
                </div>
                <div class="col-sm-2 d-grid">
                    <button type="submit" class="btn btn-primary">Search</button>
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
