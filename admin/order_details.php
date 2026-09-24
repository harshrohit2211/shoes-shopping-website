<?php
session_start();
include("../db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin'){
    header("Location: ../index.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: orders.php");
    exit();
}

$order_id = (int)$_GET['id'];

/* ===== FETCH ORDER + USER ===== */
$order_q = mysqli_query($conn,"
    SELECT o.*, u.name, u.email, u.phone, u.address
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    WHERE o.order_id='$order_id'
");

$order = mysqli_fetch_assoc($order_q);

if(!$order){
    echo "Order not found!";
    exit();
}

/* ===== FETCH ORDER ITEMS ===== */
$items = mysqli_query($conn,"
    SELECT od.*, p.product_name, p.image1, p.discount
    FROM order_details od
    JOIN products p ON od.product_id = p.product_id
    WHERE od.order_id='$order_id'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin - Order Details</title>

<style>
/* =================================
   RESET
=================================*/
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

/* =================================
   BODY
=================================*/
body{
    font-family:'Segoe UI', sans-serif;
    background:#f4f6f9;
    display:flex;
}

/* =================================
   SIDEBAR
=================================*/
.sidebar{
    width:220px;
    background:#1e4d3d;
    color:white;
    height:100vh;
    padding:20px;
    position:fixed;
    left:0;
    top:0;
}

.sidebar h2{
    margin-bottom:30px;
    font-size:20px;
}

.sidebar a{
    display:block;
    color:white;
    padding:10px;
    margin-bottom:10px;
    text-decoration:none;
    border-radius:6px;
    transition:0.3s;
}

.sidebar a:hover,
.sidebar .active{
    background:#2f7f63;
}

/* =================================
   MAIN CONTENT
=================================*/
.main{
    margin-left:220px;
    padding:30px;
    flex:1;
}

/* =================================
   CARD STYLE
=================================*/
.card{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    margin-bottom:25px;
}

/* =================================
   TABLE
=================================*/
.table-wrapper{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:700px;
}

th, td{
    padding:14px;
    border-bottom:1px solid #eee;
    text-align:center;
    font-size:14px;
}

th{
    background:#fafafa;
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:1px;
    color:#666;
}

tbody tr:hover{
    background:#f9fbfc;
}

/* =================================
   PRODUCT IMAGE
=================================*/
img{
    width:60px;
    border-radius:8px;
}

/* =================================
   TOTAL SECTION
=================================*/
.total-box{
    text-align:right;
    font-size:18px;
    font-weight:600;
    margin-top:20px;
}

/* =================================
   BACK BUTTON
=================================*/
.back-btn{
    display:inline-block;
    margin-bottom:20px;
    background:#1e4d3d;
    color:white;
    padding:8px 16px;
    border-radius:6px;
    text-decoration:none;
    transition:0.3s;
}

.back-btn:hover{
    background:#2f7f63;
}

/* =================================
   RESPONSIVE
=================================*/
@media(max-width:992px){
    .main{
        padding:20px;
    }
}

@media(max-width:768px){

    body{
        flex-direction:column;
    }

    .sidebar{
        width:100%;
        height:auto;
        position:relative;
    }

    .main{
        margin-left:0;
        padding:20px;
    }

    table{
        font-size:13px;
    }

    th, td{
        padding:10px;
    }
}
</style>
</head>

<body>

<?php include("sidebar.php"); ?>

<div class="main">

<a href="orders.php" class="back-btn">← Back</a>

<h2>Order #<?php echo $order['order_id']; ?></h2>

<!-- ===== CUSTOMER INFO ===== -->
<div class="card">
<h3>Customer Information</h3>
<p><b>Name:</b> <?php echo $order['name']; ?></p>
<p><b>Email:</b> <?php echo $order['email']; ?></p>
<p><b>Phone:</b> <?php echo $order['phone']; ?></p>
<p><b>Address:</b> <?php echo $order['address']; ?></p>
<p><b>Status:</b> <?php echo $order['status']; ?></p>
<p><b>Date:</b> <?php echo date("M d, Y H:i", strtotime($order['order_date'])); ?></p>
</div>

<!-- ===== ORDER ITEMS ===== -->
<div class="card">
<h3>Ordered Products</h3>

<table>
<tr>
<th>Product</th>
<th>Price</th>
<th>Qty</th>
<th>Total</th>
</tr>

<?php
$subtotal = 0;

while($row = mysqli_fetch_assoc($items)){

    $original_price = (float)$row['price'];
    $discount = (int)$row['discount'];

    $final_price = $original_price;

    if($discount > 0){
        $final_price = $original_price - ($original_price * $discount / 100);
    }

    $item_total = $final_price * $row['quantity'];
    $subtotal += $item_total;
?>

<tr>

<td>
<img src="../images/<?php echo $row['image1']; ?>"><br>
<b><?php echo $row['product_name']; ?></b><br>
<small>
Color: <?php echo $row['color']; ?> |
Size: <?php echo $row['size']; ?>
</small>
</td>

<td>
<?php if($discount > 0){ ?>
<span style="color:#e60023;font-weight:bold;">
₹<?php echo number_format($final_price,0); ?>
</span><br>
<small style="text-decoration:line-through;color:#888;">
₹<?php echo number_format($original_price,0); ?>
</small>
<?php } else { ?>
₹<?php echo number_format($original_price,0); ?>
<?php } ?>
</td>

<td><?php echo $row['quantity']; ?></td>

<td>₹<?php echo number_format($item_total,0); ?></td>

</tr>

<?php } ?>

</table>

<?php
$shipping = 10;
$grand_total = $subtotal + $shipping;
?>

<div class="total-box">
<p>Subtotal: ₹<?php echo number_format($subtotal,0); ?></p>
<p>Shipping: ₹<?php echo number_format($shipping,0); ?></p>
<hr>
<p><b>Grand Total: ₹<?php echo number_format($grand_total,0); ?></b></p>
</div>

</div>

</div>

</body>
</html>