<?php
session_start();
include("../db.php");

if($_SESSION['role'] != 'Admin'){
    header("Location: ../index.php");
    exit();
}

// Dashboard Data
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products"))['total'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"))['total'];
$pending_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE status='Pending'"))['total'];
$delivered_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE status='Delivered'"))['total'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
    body{
    margin:0;
    font-family: Arial, sans-serif;
    display:flex;
    background:#f4f6f9;
}

.sidebar{
    width:220px;
    background:#1e4d3d;
    color:white;
    height:100vh;
    padding:20px;
}

.sidebar h2{
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:white;
    padding:10px;
    text-decoration:none;
    margin-bottom:10px;
    border-radius:5px;
}

.sidebar a:hover,
.sidebar .active{
    background:#2f7f63;
}

.main{
    flex:1;
    padding:30px;
}

.cards{
    display:flex;
    gap:20px;
    margin-bottom:20px;
}

.card{
    flex:1;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

.card.orange h2{ color:orange; }
.card.green h2{ color:green; }

table{
    width:100%;
    background:white;
    border-collapse:collapse;
    border-radius:10px;
    overflow:hidden;
}

th, td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

th{
    background:#1e4d3d;
    color:white;
}

.status{
    padding:5px 10px;
    background:#2f7f63;
    color:white;
    border-radius:20px;
    font-size:12px;
}
    </style>
</head>

<body>

<div class="sidebar">
    <h2>ShoeStore</h2>
    <a class="active" href="#">Dashboard</a>
    <a href="inventory.php">Inventory Dashboard</a>
    <a href="products.php">Products</a>
    <a href="orders.php">Orders</a>
    <a href="users.php">Users</a> 
    <a href="contact_messages.php">Contact Messages</a>
    <a href="carts.php">carts</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">

    <h1>Dashboard</h1>

    <div class="cards">
        <div class="card">Total Users <h2><?php echo $total_users; ?></h2></div>
        <div class="card">Total Products <h2><?php echo $total_products; ?></h2></div>
        <div class="card">Total Orders <h2><?php echo $total_orders; ?></h2></div>
    </div>

    <div class="cards">
        <div class="card orange">Pending Orders <h2><?php echo $pending_orders; ?></h2></div>
        <div class="card green">Delivered Orders <h2><?php echo $delivered_orders; ?></h2></div>
    </div>

    <h2>Recent Orders</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
        </tr>

        <?php
        $orders = mysqli_query($conn, "SELECT orders.*, users.name 
                                       FROM orders 
                                       JOIN users ON orders.user_id = users.user_id
                                       ORDER BY order_id DESC LIMIT 5");

        while($row = mysqli_fetch_assoc($orders)){
        ?>
        <tr>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td>₹<?php echo (int)$row['total_amount']; ?></td>
            <td><span class="status"><?php echo $row['status']; ?></span></td>
            <td><?php echo $row['order_date']; ?></td>
        </tr>
        <?php } ?>
    </table>

</div>

</body>
</html>