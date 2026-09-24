<?php
session_start();
include("../db.php");

if($_SESSION['role'] != 'Admin'){
    header("Location: ../index.php");
    exit();
}

$result = mysqli_query($conn, "
    SELECT products.*, categories.category_name
    FROM products
    JOIN categories ON products.category_id = categories.category_id
    ORDER BY product_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>All Products</title>
<style>
/* ===== RESET ===== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family: Arial, sans-serif;
    background:#f4f6f9;
    display:flex;
    min-height:100vh;
}

/* ===== SIDEBAR ===== */
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
    transition:0.3s;
}

.sidebar a:hover,
.sidebar a.active{
    background:#2f7f63;
}

/* ===== MAIN CONTENT ===== */
.main{
    flex:1;
    padding:30px;
}

/* ===== DASHBOARD CARDS ===== */
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

.card.orange h2{
    color:orange;
}

.card.green h2{
    color:green;
}

/* ===== ADD BUTTON ===== */
.add-btn{
    display:inline-block;
    margin-bottom:15px;
    background:#1e4d3d;
    color:white;
    padding:8px 15px;
    text-decoration:none;
    border-radius:6px;
    transition:0.3s;
}

.add-btn:hover{
    background:#2f7f63;
}

/* ===== TABLE ===== */
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

/* ===== STATUS ===== */
.active{
    background:green;
    color:white;
    padding:4px 10px;
    border-radius:20px;
    font-size:12px;
}

.inactive{
    background:red;
    color:white;
    padding:4px 10px;
    border-radius:20px;
    font-size:12px;
}

.status{
    padding:5px 10px;
    background:#2f7f63;
    color:white;
    border-radius:20px;
    font-size:12px;
}

/* ===== ACTION LINKS ===== */
.edit{
    color:blue;
    margin-right:10px;
    text-decoration:none;
}

.delete{
    color:red;
    text-decoration:none;
}

/* ===== RESPONSIVE ===== */
@media(max-width:900px){

    body{
        flex-direction:column;
    }

    .sidebar{
        width:100%;
        height:auto;
    }

    .main{
        padding:20px;
    }

    .cards{
        flex-direction:column;
    }

    table{
        font-size:14px;
    }

} </style>
</head>
<body>

<?php include("sidebar.php"); ?>

<div class="main">

<h2>All Products</h2>

<a href="add_product.php" class="add-btn">+ Add Product</a>

<table>
<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Category</th>
    <th>Type</th>
    <th>Price</th>
    <th>Discount</th>
    <th>Final Price</th>
    <th>Stock</th>
    <th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){

    $final_price = $row['price'] - ($row['price'] * $row['discount'] / 100);
?>

<tr>
    <td>
        <img src="../images/<?php echo $row['image1']; ?>" width="60">
    </td>

    <td><?php echo $row['product_name']; ?></td>

    <td><?php echo $row['category_name']; ?></td>

    <td><?php echo $row['shoe_type']; ?></td>

    <td>₹<?php echo $row['price']; ?></td>

    <td><?php echo $row['discount']; ?>%</td>

    <td>₹<?php echo number_format($final_price,0); ?></td>

    <td><?php echo $row['stock']; ?></td>

  

    <td>
        <a href="edit_product.php?id=<?php echo $row['product_id']; ?>" class="edit">✏</a>
        <a href="delete_product.php?id=<?php echo $row['product_id']; ?>" class="delete">🗑</a>
    </td>
</tr>

<?php } ?>

</table>

</div>
</body>
</html>