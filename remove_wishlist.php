<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: wishlist.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = (int)$_GET['id'];

/* Delete only that user's wishlist item */
mysqli_query($conn, "
    DELETE FROM wishlist 
    WHERE user_id = '$user_id' 
    AND product_id = '$product_id'
");

header("Location: wishlist.php");
exit();
?>