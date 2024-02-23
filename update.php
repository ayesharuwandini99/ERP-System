<?php
$servername="localhost";
$username="root";
$password="";
$database="erp_db";

//create connection
$connection=new mysqli($servername, $username, $password, $database);

$id="";
$title="";
$first_name="";
$middle_name="";
$last_name="";
$contact_no="";
$district="";

$errorMessage="";
$successMessage="";

// Fetch item district from the database
$idQuery = "SELECT id FROM district";
$idResult = $connection->query($idQuery);
$categories = [];
if ($idResult) {
    while ($row = $idResult->fetch_assoc()) {
        $categories[] = $row['id'];
    }
}

if($_SERVER['REQUEST_METHOD']=='GET'){
    //get method:show the data of the customer

    if(!isset($_GET["id"])){
        header("location: /sales/index.php");
        exit;
    }
    $id =$_GET["id"];

    //read the row of the selected customer from database table
    $sql="SELECT * FROM customer WHERE id='$id'";
    $result=$connection->query($sql);
    $row=$result->fetch_assoc();

    if(!$row){
        header("location: /sales/index.php");
        exit;
    }
    
    $title=$row["title"];
    $first_name=$row["first_name"];
    $middle_name=$row["middle_name"];
    $last_name=$row["last_name"];
    $contact_no=$row["contact_no"];
    $district=$row["district"];
}
else{
    //post method: update data of the customer

    $id = $_POST["id"];
    $title=$_POST["title"];
    $first_name=$_POST["first_name"];
    $middle_name=$_POST["middle_name"];
    $last_name=$_POST["last_name"];
    $contact_no=$_POST["contact_no"];
    $district=$_POST["district"];

    do{
        if(empty($title)||empty($first_name)||empty($middle_name)||empty($last_name)||empty($contact_no)||empty($district)){
            $errorMessage="All the fields are required";
            break;
        }

        $sql= "UPDATE `customer` SET `title`='$title',`first_name`='$first_name',`middle_name`='$middle_name',`last_name`='$last_name',`contact_no`='$contact_no',`district`='$district' WHERE id='$id'";

        $result=$connection->query($sql);

        if(!$result){
            $errorMessage="Invalid query:".$connection->error;
            break;
        }

        $successMessage="Customer updated correctly";

        header("location: /sales/index.php");
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
        <br><h1>Update Customer Details</h1><br>
        
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
                    <label for="title" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                    <select class="form-control" id="title" name="title" value="<?php echo $title;?>">
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Miss">Miss</option>
                        <option value="Dr">Dr</option>
                    </select>
                    </div>
                </div>

                <div class="row mb-3 ">
                    <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" value="<?php echo $first_name;?>">
                    </div>
                </div>

                <div class="row mb-3 ">
                    <label for="middle_name" class="col-sm-2 col-form-label">Middle Name</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter Middle Name" value="<?php echo $middle_name;?>">
                    </div>
                </div>

                <div class="row mb-3 ">
                    <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" value="<?php echo $last_name;?>">
                    </div>
                </div>

                <div class="row mb-3 ">
                    <label for="contact_no" class="col-sm-2 col-form-label">Contact No</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Enter Contact Number" value="<?php echo $contact_no;?>">
                    </div>
                </div>

                <div class="row mb-3 ">
                    <label for="district" class="col-sm-2 col-form-label">District</label>
                    <div class="col-sm-10">
                    <select class="form-select" id="district" name="district">
                            <option value="">District</option>
                            <?php foreach ($categories as $id) { ?>
                                <option value="<?php echo $id; ?>" <?php if ($district == $id) echo 'selected="selected"'; ?>><?php echo $id; ?></option>
                            <?php } ?>
                    </select>
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

