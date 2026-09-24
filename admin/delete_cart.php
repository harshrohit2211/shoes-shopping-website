<?php
session_start();
include("../db.php");

/* =============================
   ADMIN SECURITY
============================= */
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin'){
    header("Location: ../index.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: carts.php");
    exit();
}

$orderdetail_id = (int)$_GET['id'];

/* =============================
   GET ORDER ID FIRST
============================= */
$result = mysqli_query($conn,"
    SELECT order_id 
    FROM order_details 
    WHERE orderdetail_id='$orderdetail_id'
");

$data = mysqli_fetch_assoc($result);

if(!$data){
    header("Location: carts.php");
    exit();
}

$order_id = $data['order_id'];

/* =============================
   DELETE ITEM
============================= */
mysqli_query($conn,"
    DELETE FROM order_details 
    WHERE orderdetail_id='$orderdetail_id'
");

/* =============================
   UPDATE ORDER TOTAL
============================= */
mysqli_query($conn,"
    UPDATE orders
    SET total_amount = (
        SELECT IFNULL(SUM(subtotal),0)
        FROM order_details
        WHERE order_id='$order_id'
    )
    WHERE order_id='$order_id'
");

/* =============================
   OPTIONAL: DELETE EMPTY ORDER
============================= */
$check = mysqli_query($conn,"
    SELECT * FROM order_details 
    WHERE order_id='$order_id'
");

if(mysqli_num_rows($check) == 0){
    mysqli_query($conn,"
        DELETE FROM orders 
        WHERE order_id='$order_id'
    ");
}

header("Location: carts.php");
exit();
?>