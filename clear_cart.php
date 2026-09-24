<?php
session_start();
include("db.php");

// ✅ Check login first
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Find pending order
$order = mysqli_query($conn,
    "SELECT order_id FROM orders 
     WHERE user_id='$user_id' AND status='Pending'");
$o = mysqli_fetch_assoc($order);

if($o){
    $oid = $o['order_id'];

    // Delete cart items
    mysqli_query($conn,
        "DELETE FROM order_details WHERE order_id='$oid'");

    // Delete order
    mysqli_query($conn,
        "DELETE FROM orders WHERE order_id='$oid'");
}

// Redirect back to cart
header("Location: cart.php");
exit();
