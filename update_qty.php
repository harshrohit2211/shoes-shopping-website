<?php
include("db.php");

$id = $_POST['orderdetail_id'];

$q = mysqli_query($conn,
    "SELECT * FROM order_details WHERE orderdetail_id='$id'");
$row = mysqli_fetch_assoc($q);

$qty = $row['quantity'];

if(isset($_POST['plus'])){
    $qty++;
}
if(isset($_POST['minus']) && $qty > 1){
    $qty--;
}

$new_sub = $qty * $row['subtotal'] / $row['quantity'];

mysqli_query($conn,
    "UPDATE order_details 
     SET quantity='$qty', subtotal='$new_sub'
     WHERE orderdetail_id='$id'");

header("Location: cart.php");
