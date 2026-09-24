<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$items = mysqli_query($conn,"
    SELECT p.* 
    FROM wishlist w
    JOIN products p ON w.product_id = p.product_id
    WHERE w.user_id='$user_id'
");
?>

<?php include("header.php"); ?>

<!DOCTYPE html>
<html>
<head>
<title>My Wishlist</title>
<style>
body{
    background:#fff;
    font-family:'Segoe UI', sans-serif;
    color:#111;
}

.wishlist-section{
    max-width:1400px;
    margin:100px auto;
    padding:0 40px;
}

.wishlist-title{
    font-size:28px;
    letter-spacing:3px;
    margin-bottom:50px;
}

.wishlist-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
    gap:40px;
}

.wishlist-card{
    transition:0.3s ease;
}

.wishlist-card:hover{
    transform:translateY(-6px);
}

.wishlist-img{
    background:#f5f5f5;
    overflow:hidden;
}

.wishlist-img img{
    width:100%;
    height:380px;
    object-fit:cover;
    transition:0.4s;
}

.wishlist-img:hover img{
    transform:scale(1.05);
}

.wishlist-content{
    padding:20px 0;
}

.wishlist-content h4{
    font-size:14px;
    letter-spacing:2px;
    margin-bottom:10px;
}

.price{
    font-size:16px;
    font-weight:600;
    margin-bottom:20px;
}

.wishlist-actions{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.btn-view{
    text-align:center;
    padding:14px;
    background:#000;
    color:#fff;
    text-decoration:none;
    font-size:12px;
    letter-spacing:2px;
    transition:0.3s;
}

.btn-view:hover{
    background:#333;
}

.btn-remove{
    text-align:center;
    padding:12px;
    border:1px solid #000;
    color:#000;
    text-decoration:none;
    font-size:12px;
    letter-spacing:2px;
    transition:0.3s;
}

.btn-remove:hover{
    background:#000;
    color:#fff;
}

.empty-state{
    text-align:center;
    margin-top:100px;
}

.shop-btn{
    display:inline-block;
    margin-top:20px;
    padding:15px 30px;
    background:#000;
    color:#fff;
    text-decoration:none;
    letter-spacing:2px;
    transition:0.3s;
}

.shop-btn:hover{
    background:#333;
}</style>
</head>
<body>

<section class="wishlist-section">

<h2 class="wishlist-title">MY FAVORITES</h2>

<?php if(mysqli_num_rows($items) > 0){ ?>

<div class="wishlist-grid">

<?php while($row = mysqli_fetch_assoc($items)){ ?>

<div class="wishlist-card">

    <div class="wishlist-img">
        <a href="product.php?id=<?php echo $row['product_id']; ?>">
            <img src="images/<?php echo $row['image1']; ?>">
        </a>
    </div>

    <div class="wishlist-content">
        <h4><?php echo strtoupper($row['product_name']); ?></h4>
        <p class="price">₹<?php echo number_format($row['price'],0); ?></p>

        <div class="wishlist-actions">
            <a href="product.php?id=<?php echo $row['product_id']; ?>" class="btn-view">
                VIEW PRODUCT
            </a>
            <a href="remove_wishlist.php?id=<?php echo $row['product_id']; ?>" class="btn-remove">
                REMOVE
            </a>
        </div>
    </div>

</div>

<?php } ?>

</div>

<?php } else { ?>

<div class="empty-state">
    <h3>YOU HAVEN’T ADDED ANY FAVORITES YET.</h3>
    <a href="index.php" class="shop-btn">START SHOPPING</a>
</div>

<?php } ?>

</section>

<?php include("footer.php"); ?>
</body>
</html>