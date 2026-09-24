<?php
session_start();
include("../db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin'){
    header("Location: ../index.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: products.php");
    exit();
}

$product_id = (int)$_GET['id'];

mysqli_query($conn,"DELETE FROM products WHERE product_id='$product_id'");

header("Location: products.php");
exit();
?>