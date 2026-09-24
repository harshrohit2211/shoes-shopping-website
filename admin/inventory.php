<?php
session_start();
include("../db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin'){
    header("Location: ../index.php");
    exit();
}

/* STOCK COUNTS */
$total_products = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM products"));
$out_of_stock   = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM products WHERE stock = 0"));
$low_stock      = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM products WHERE stock > 0 AND stock <= 5"));

$products = mysqli_query($conn,"SELECT * FROM products ORDER BY stock ASC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Inventory Management</title>
<link rel="stylesheet" href="admin.css">
<style>

.stock-card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

.stock-badge{
    padding:5px 12px;
    border-radius:20px;
    color:#fff;
    font-size:12px;
}

.in-stock{ background:#28a745; }
.low-stock{ background:#ff9800; }
.out-stock{ background:#dc3545; }

/* ===== RESET ===== */
*{
    box-sizing:border-box;
}

/* ===== BODY ===== */
body{
    margin:0;
    font-family: Arial, sans-serif;
    display:flex;
    background:#f4f6f9;
}

/* ===== SIDEBAR ===== */
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

/* ===== MAIN CONTENT ===== */
.main{
    margin-left:220px;
    flex:1;
    padding:30px;
}

/* ===== DASHBOARD CARDS ===== */
.cards{
    display:flex;
    gap:20px;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.card{
    flex:1 1 250px;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

.card.orange h2{ color:orange; }
.card.green h2{ color:green; }

/* ===== TABLE ===== */
.table-wrapper{
    overflow-x:auto;
}

table{
    width:100%;
    background:white;
    border-collapse:collapse;
    border-radius:10px;
    overflow:hidden;
    min-width:700px;
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

/* ============================= */
/* ===== RESPONSIVE DESIGN ===== */
/* ============================= */

/* Tablet */
@media(max-width:992px){

    .cards{
        flex-direction:column;
    }
}

/* Mobile */
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
        font-size:14px;
    }

    th, td{
        padding:8px;
    }
}
</style>
</head>
<body>

<?php include("sidebar.php"); ?>

<div class="main">

<h2>Inventory Dashboard</h2>

<div class="cards">

<div class="card">
<h3>Total Products</h3>
<h2><?php echo $total_products; ?></h2>
</div>

<div class="card orange">
<h3>Low Stock (≤5)</h3>
<h2><?php echo $low_stock; ?></h2>
</div>

<div class="card green">
<h3>Out of Stock</h3>
<h2><?php echo $out_of_stock; ?></h2>
</div>

</div>

<div class="stock-card">
<h3>Product Stock Details</h3>

<table>
<tr>
<th>ID</th>
<th>Product</th>
<th>Stock</th>
<th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($products)){ ?>

<tr>
<td><?php echo $row['product_id']; ?></td>
<td><?php echo $row['product_name']; ?></td>
<td><?php echo $row['stock']; ?></td>
<td>

<?php
if($row['stock'] == 0){
    echo "<span class='stock-badge out-stock'>Out of Stock</span>";
}
elseif($row['stock'] <= 5){
    echo "<span class='stock-badge low-stock'>Low Stock</span>";
}
else{
    echo "<span class='stock-badge in-stock'>In Stock</span>";
}
?>

</td>
</tr>

<?php } ?>

</table>

</div>

</div>
</body>
</html>