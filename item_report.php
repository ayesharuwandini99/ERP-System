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

// Initialize variables to store form data and errors
$item_category = "";
$item_subcategory = "";
$errors = [];

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $item_category = trim($_POST["item_category"]);
    $item_subcategory = trim($_POST["item_subcategory"]);

    // Validate form data
    if (empty($item_category)) {
        $errors[] = "Please enter an item category.";
    }
    if (empty($item_subcategory)) {
        $errors[] = "Please enter an item subcategory.";
    }

    // If no errors, prepare and execute the SQL query
    if (empty($errors)) {
        $sql = "SELECT * FROM `item` WHERE item_category = ? AND item_subcategory = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $item_category, $item_subcategory);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are any results
        if ($result->num_rows > 0) {
            // Display the fetched invoice data
            echo "<center><h2>Item Report</h2></center>";
            echo "<center><table class='table table-striped table-hover' border='4'>";
            echo "<tr>
                    <th>Item Name</th>
                    <th>Item Category</th>
                    <th>Item Subcategory</th>
                    <th>Quantity</th>
                </tr>";

            // Loop through the result set and output data
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["item_name"] . "</td>";
                echo "<td>" . $row["item_category"] . "</td>";
                echo "<td>" . $row["item_subcategory"] . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "</tr>";
            }

            echo "</table></center>";
        } else {
            echo "No item data found for the given category and subcategory.";
        }

        $stmt->close();
    } else {
        // Display validation errors
        echo "<center><ul style='color: red;'>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul></center>";
    }
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Item Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <br><br><h1><center>Item Report</center></h1><br>

    <center>
        <form method="post" action="">
            
            <label for="item_category">Item Category</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" id="item_category" name="item_category" value="<?php echo $item_category; ?>" required>
            <br><br>
            
            <label for="item_subcategory">Item SubCategory</label>
            <input type="text" id="item_subcategory" name="item_subcategory" value="<?php echo $item_subcategory; ?>" required>
            <br><br>

        <div class="row mb-10">
                <div class="offset-sm-6 col-sm-1 d-grid">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
        </div>
        </form>
    </center>
</body>
</html>


