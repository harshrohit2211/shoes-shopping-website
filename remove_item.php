<?php
include("db.php");

$id = $_GET['id'];
mysqli_query($conn,
    "DELETE FROM order_details WHERE orderdetail_id='$id'");

header("Location: cart.php");
