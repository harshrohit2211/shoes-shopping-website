<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if(isset($_GET['order_id'])){

    $order_id = (int)$_GET['order_id'];
    $user_id = $_SESSION['user_id'];

    // Check order belongs to user
    $check = mysqli_query($conn,
        "SELECT * FROM orders 
         WHERE order_id='$order_id' 
         AND user_id='$user_id'"
    );

    if(mysqli_num_rows($check) > 0){

        $order = mysqli_fetch_assoc($check);

        // Only allow cancel if Pending
        if($order['status'] == 'Processing'){

            mysqli_query($conn,
                "UPDATE orders 
                 SET status='Cancelled' 
                 WHERE order_id='$order_id'"
            );

            header("Location: order_details.php?cancel=success");
            exit();

        } else {

            header("Location: order_details.php?cancel=notallowed");
            exit();
        }

    } else {

        header("Location: order_details.php");
        exit();
    }
}

header("Location: order_details.php");
exit();
?>
