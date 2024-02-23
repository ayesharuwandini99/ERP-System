<?php
$servername="localhost";
$username="root";
$password="";
$database="erp_db";

//create connection
$connection=new mysqli($servername, $username, $password, $database);

$id="";
$item_code="";
$invoice_no="";
$item_name="";
$item_category="";
$item_subcategory="";
$quantity="";
$unit_price="";

$errorMessage="";
$successMessage="";

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

if($_SERVER['REQUEST_METHOD']=='GET'){
    //get method:show the data of the item

    if(!isset($_GET["id"])){
        header("location: /sales/index1.php");
        exit;
    }
    $id =$_GET["id"];

    //read the row of the selected item from database table
    $sql="SELECT * FROM item WHERE id=$id";
    $result=$connection->query($sql);
    $row=$result->fetch_assoc();

    if(!$row){
        header("location: /sales/index1.php");
        exit;
    }
    
    $item_code=$row["item_code"];
    $invoice_no=$row["invoice_no"];
    $item_name=$row["item_name"];
    $item_category=$row["item_category"];
    $item_subcategory=$row["item_subcategory"];
    $quantity=$row["quantity"];
    $unit_price=$row["unit_price"];
}
else{
    //post method: update data of the item

    $id = $_POST["id"];
    $item_code=$_POST["item_code"];
    $invoice_no=$_POST["invoice_no"];
    $item_name=$_POST["item_name"];
    $item_category=$_POST["item_category"];
    $item_subcategory=$_POST["item_subcategory"];
    $quantity=$_POST["quantity"];
    $unit_price=$_POST["unit_price"];

    do{
        if(empty($item_code)||empty($invoice_no)|| empty($item_name)||empty($item_category)||empty($item_subcategory)||empty($quantity)||empty($unit_price)){
            $errorMessage="All the fields are required";
            break;
        }

        $sql= "UPDATE `item` SET `item_code`='$item_code',`invoice_no`='$invoice_no',`item_category`='$item_category',`item_subcategory`='$item_subcategory',`item_name`='$item_name',`quantity`='$quantity',`unit_price`='$unit_price' WHERE id='$id'";

        $result=$connection->query($sql);

        if(!$result){
            $errorMessage="Invalid query:".$connection->error;
            break;
        }

        $successMessage="Item updated correctly";

        header("location: /sales/index1.php");
        exit;

    }while(true);
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
        <br><h1>Update Item Details</h1><br>
        
        <?php
        if(!empty($errorMessage)){
            echo"
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type=''button' class='btn-close' data-bs-dismiss='alert' aria-label='close'>
            </div>
            ";
        }
        ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            
            <div class="row mb-3 ">
                    <label for="item_code" class="col-sm-2 col-form-label">Item Code</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="item_code" name="item_code" placeholder="Enter Item Code" value="<?php echo $item_code;?>">
                    </div>
                </div>

                <div class="row mb-3">
                <label for="invoice_no" class="col-sm-2 col-form-label">Invoice No</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="invoice_no" name="invoice_no" value="<?php echo $invoice_no; ?>">
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
                    <input type="text" class="form-control" id="unit_price" name="unit_price"  placeholder="Enter Quantity" value="<?php echo $unit_price;?>">
                    </div>
                </div>
            
            <?php
            if(!empty($successMessage)){
                echo"
                <div class='row mb-3 '>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type=''button' class='btn-close' data-bs-dismiss='alert' aria-label='close'>
                        </div>
                    </div>
                </div>
            ";
            }
            ?>

            <div class="row mb-3 p">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/sales/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>

</body>
</html>

