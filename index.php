<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom JavaScript for form validation -->

</head>

<body>
    <div class="container">
        <br><h1>Customer Registration</h1><br>
        <a class="btn btn-primary" href="/sales/insert.php" role="button">New Customer</a>
        <br>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>First name</th>
                    <th>Middle name</th>
                    <th>Last name</th>
                    <th>Contact NO</th>
                    <th>District</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $servername="localhost";
                $username="root";
                $password="";
                $database="erp_db";

                //create connection
                $connection=new mysqli($servername, $username, $password, $database);

                //check connection
                if($connection->connect_error){
                    die("Connection failed:".$connection->connect_error);
                }

                //read all row from database table
                $sql="SELECT * FROM customer";
                $result=$connection->query($sql);

                if(!$result){
                    die("Invalid query:".$connection->error);
                }

                //read data of each row
                while($row=$result->fetch_assoc()){
                    echo"
                        <tr>
                            <td>$row[id]</td>
                            <td>$row[title]</td>
                            <td>$row[first_name]</td>
                            <td>$row[middle_name]</td>
                            <td>$row[last_name]</td>
                            <td>$row[contact_no]</td>
                            <td>$row[district]</td>

                            &nbsp;&nbsp;&nbsp;
                            
                            <td>
                                <a class='btn btn-primary btn-sm-6' href='/sales/update.php? id=$row[id]'>Update</a>
                                <a class='btn btn-danger btn-sm-6' href='/sales/delete.php? id=$row[id]'>Delete</a>
                            </td>
                        </tr>";
                }
                ?>

                
            </tbody>
        </table>
    </div>
</body>
</html>