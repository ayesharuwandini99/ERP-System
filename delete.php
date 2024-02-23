<?php
if(isset($_GET["id"])){
    $id =$_GET["id"];

    $servername="localhost";
    $username="root";
    $password="";
    $database="erp_db";

    //create connection
    $connection=new mysqli($servername, $username, $password, $database);

    $sql="DELETE FROM `customer` WHERE id=$id";
    $connection->query($sql);
}

    header("location: /sales/index.php");
    exit;
?>