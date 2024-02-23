<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "erp_db";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

$item_code = "";
$invoice_no="";
$item_name = "";
$item_category = "";
$item_subcategory = "";
$quantity = "";
$unit_price = "";

$errorMessage = "";
$successMessage = "";

// Fetch item categories from the database
$idQuery = "SELECT id FROM item_category";
$idResult = $connection->query($idQuery);
$categories = [];
if ($idResult) {
    while ($row = $idResult->fetch_assoc()) {
        $categories[] = $row['id'];
    }
}

// Fetch item subcategories from the database
$idQuery = "SELECT id FROM item_subcategory";
$idResult = $connection->query($idQuery);
$categories = []; // Fix: Use a different variable name
if ($idResult) {
    while ($row = $idResult->fetch_assoc()) {
        $categories[] = $row['id']; // Fix: Corrected variable name
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_code = $_POST["item_code"];
    $invoice_no = $_POST["invoice_no"];
    $item_name = $_POST["item_name"];
    $item_category = $_POST["item_category"];
    $item_subcategory = $_POST["item_subcategory"];
    $quantity = $_POST["quantity"];
    $unit_price = $_POST["unit_price"];

    do {
        if (empty($item_code) || empty($item_code)|| empty($item_name) || empty($item_category) || empty($item_subcategory) || empty($quantity) || empty($unit_price)) {
            $errorMessage = "All the fields are required";
            break;
        }

        // Add new item to database
        $sql = "INSERT INTO item (`item_code`, `invoice_no`, `item_name`, `item_category`, `item_subcategory`, `quantity`, `unit_price`)" . "VALUES('$item_code', '$invoice_no','$item_name', '$item_category', '$item_subcategory', '$quantity', '$unit_price')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query:" . $connection->error;
            break;
        }

        $item_code = "";
        $invoice_no="";
        $item_name = "";
        $item_category = "";
        $item_subcategory = "";
        $quantity = "";
        $unit_price = "";

        $successMessage = "Item added successfully";

        header("location:/sales/index1.php");
        exit;
    } while (false);
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
        <br><h1>New Item</h1><br>
        
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
            </div>
            ";
        }
        ?>

        <form method="POST">
                <div class="row mb-3 ">
                    <label for="item_code" class="col-sm-2 col-form-label">Item Code</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="item_code" name="item_code" placeholder="Enter Item Code" value="<?php echo $item_code;?>">
                    </div>
                </div>

                <div class="row mb-3 ">
                    <label for="invoice_no" class="col-sm-2 col-form-label">Invoice No</label>
                    <div class="col-sm-10">
                    <input type="number" class="form-control" id="invoice_no" name="invoice_no" placeholder="Enter Invoice No" value="<?php echo $invoice_no;?>">
                    </div>
                </div>

                <div class="row mb-3 ">
                    <label for="item_name" class="col-sm-2 col-form-label">Item Name</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Enter Item Name" value="<?php echo $item_name;?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="item_category" class="col-sm-2 col-form-label">Item Category</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="item_category" name="item_category">
                            <option value="">Select Item Category</option>
                            <?php foreach ($categories as $id) { ?>
                                <option value="<?php echo $id; ?>" <?php if ($item_category == $id) echo 'selected="selected"'; ?>><?php echo $id; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>


                <div class="row mb-3 ">
                    <label for="item_subcategory" class="col-sm-2 col-form-label">Item Sub Category</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="item_subcategory" name="item_subcategory">
                            <option value="">Select Item Sub Category</option>
                            <?php foreach ($categories as $id) { ?>
                                <option value="<?php echo $id; ?>" <?php if ($item_subcategory == $id) echo 'selected="selected"'; ?>><?php echo $id; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3 ">
                    <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" value="<?php echo $quantity;?>">
                    </div>
                </div>

                <div class="row mb-3 ">
                    <label for="unit_price" class="col-sm-2 col-form-label">Unit Price</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="unit_price" name="unit_price"  placeholder="Enter Unit Price" value="<?php echo $unit_price;?>">
                    </div>
                </div>

            <?php
            if(!empty($successMessage)){
                echo"
                <div class='row mb-3 '>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
                        </div>
                    </div>
                </div>
            ";
            }
            ?>

            <div class="row mb-3 ">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/sales/index1.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>

</body>
</html>
