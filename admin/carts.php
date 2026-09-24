<?php
session_start();
include("../db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin'){
    header("Location: ../index.php");
    exit();
}

$query = mysqli_query($conn,"
    SELECT od.orderdetail_id,
           p.product_id,
           p.product_name,
           p.image1,
           p.price,
           u.name,
           u.email,
           o.order_id,
           o.order_date,
           od.quantity,
           od.subtotal
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    JOIN order_details od ON o.order_id = od.order_id
    JOIN products p ON od.product_id = p.product_id
    WHERE o.status='Pending'
");

$total_items = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>All Cart Items</title>
<style>
/* ===============================
   RESET
=================================*/
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

/* ===============================
   BODY & LAYOUT
=================================*/
body{
    font-family:'Segoe UI', sans-serif;
    background:#f4f6f9;
    display:flex;
}

/* ===============================
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
    text-decoration:none;
    margin-bottom:10px;
    border-radius:6px;
    transition:0.3s;
}

.sidebar a:hover,
.sidebar .active{
    background:#2f7f63;
}

/* ===============================
   MAIN CONTENT
=================================*/
.main{
    margin-left:220px;
    flex:1;
    padding:30px;
}

/* ===============================
   CART CARD
=================================*/
.cart-card{
    background:#fff;
    border-radius:12px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    overflow:hidden;
}

.cart-header{
    background:#2f7f63;
    color:white;
    padding:15px 20px;
    font-weight:600;
    font-size:16px;
}

/* ===============================
   TABLE
=================================*/
.table-wrapper{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:900px;
}

th, td{
    padding:16px;
    border-bottom:1px solid #eee;
    text-align:left;
    font-size:14px;
}

th{
    background:#fafafa;
    font-size:13px;
    color:#666;
    text-transform:uppercase;
    letter-spacing:1px;
}

/* ===============================
   CUSTOMER SECTION
=================================*/
.customer{
    display:flex;
    align-items:center;
    gap:10px;
}

.avatar{
    width:40px;
    height:40px;
    border-radius:8px;
    background:#e3e9f2;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:600;
    color:#2f7f63;
}

.customer-info small{
    display:block;
    font-size:12px;
    color:#888;
}

/* ===============================
   PRODUCT SECTION
=================================*/
.product{
    display:flex;
    align-items:center;
    gap:12px;
}

.product img{
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:8px;
}

.product small{
    display:block;
    font-size:12px;
    color:#888;
}

/* ===============================
   QUANTITY
=================================*/
.qty-box{
    background:#f1f3f6;
    padding:6px 12px;
    border-radius:20px;
    text-align:center;
    width:40px;
    font-weight:600;
}

/* ===============================
   TOTAL
=================================*/
.total{
    color:#1ca64c;
    font-weight:600;
}

/* ===============================
   ACTION BUTTONS
=================================*/
.actions a{
    text-decoration:none;
    margin-right:8px;
    padding:6px 10px;
    border-radius:6px;
    font-size:14px;
    display:inline-block;
    transition:0.2s;
}

.edit{
    background:#e8f0fe;
    color:#1a73e8;
}

.delete{
    background:#fde8e8;
    color:#d93025;
}

.actions a:hover{
    opacity:0.8;
}

/* ===============================
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
    }

    table{
        font-size:13px;
    }
}
</style>
</head>
<body>

<?php include("sidebar.php"); ?>

<div class="main">

<div class="cart-card">

<div class="cart-header">
All Cart Items (<?php echo $total_items; ?>)
</div>

<table>
<tr>
<th>CART ITEM</th>
<th>CUSTOMER</th>
<th>PRODUCT</th>
<th>QUANTITY</th>
<th>TOTAL</th>
<th>UPDATED</th>
<th>ACTIONS</th>
</tr>

<?php while($row = mysqli_fetch_assoc($query)){ ?>

<tr>

<td>#<?php echo $row['orderdetail_id']; ?></td>

<td>
<div class="customer">
<div class="avatar">
<?php echo strtoupper(substr($row['name'],0,1)); ?>
</div>
<div class="customer-info">
<?php echo $row['name']; ?>
<small><?php echo $row['email']; ?></small>
</div>
</div>
</td>

<td>
<div class="product">
<img src="../images/<?php echo $row['image1']; ?>">
<div>
<?php echo $row['product_name']; ?>
<small>₹<?php echo number_format($row['price'],2); ?></small>
</div>
</div>
</td>

<td>
<div class="qty-box">
<?php echo $row['quantity']; ?>
</div>
</td>

<td class="total">
₹<?php echo number_format($row['subtotal'],2); ?>
</td>

<td>
<?php echo date("M d, Y H:i", strtotime($row['order_date'])); ?>
</td>

<td class="actions">

<a href="delete_cart.php?id=<?php echo $row['orderdetail_id']; ?>" 
   class="delete"
   onclick="return confirm('Are you sure you want to delete this cart item?')">
   🗑
</a>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>