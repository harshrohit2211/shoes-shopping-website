<?php 
session_start(); 
include("db.php"); 
include("header.php"); 
?>

<!DOCTYPE html>
<html>
<head>
<title>Shoe Store</title>
<style>
    *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: Arial, sans-serif;
}

html{
    scroll-behavior:smooth;
}

/* ================= HERO SECTION ================= */

.hero{
    position:relative;
    height:500px;
    overflow:hidden;
}

.hero-img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.hero::before{
    content:"";
    position:absolute;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
}

.hero-content{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    color:#fff;
    text-align:center;
}

.hero-content h1{
    font-size:55px;
    letter-spacing:3px;
}

.hero-content p{
    margin-top:10px;
    font-size:20px;
}

.shop-btn{
    display:inline-block;
    margin-top:25px;
    padding:12px 35px;
    background:#ffcc00;
    color:#000;
    text-decoration:none;
    font-weight:bold;
    border-radius:5px;
    transition:0.3s;
}

.shop-btn:hover{
    background:#fff;
}

/* ================= PRODUCTS SECTION ================= */

.products-section{
    background:#f3f3f3;
    padding:60px 5%;
    text-align:center;
}

.products-section h2{
    font-size:28px;
    letter-spacing:2px;
    margin-bottom:40px;
}

/* Grid Layout */

.products-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:30px;
}

/* Remove link style */

.product-link{
    text-decoration:none;
    color:inherit;
}

/* Product Card */

.product-card{
    position:relative;
    background:#fff;
    border-radius:12px;
    padding:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}

.product-card:hover{
    transform:translateY(-6px);
    box-shadow:0 12px 25px rgba(0,0,0,0.15);
}

/* Product Image */

.product-card img{
    width:100%;
    height:200px;
    object-fit:contain;   /* FIXED IMAGE DISPLAY */
    background:#f7f7f7;
    border-radius:8px;
    padding:10px;
}

/* Product Name */

.product-card h3{
    font-size:17px;
    margin:12px 0 6px;
}

/* Price */

.price-section{
    margin-top:5px;
}

.normal-price,
.new-price{
    color:#e60023;
    font-size:18px;
    font-weight:bold;
}

.old-price{
    text-decoration:line-through;
    color:#888;
    font-size:14px;
    margin-left:6px;
}

/* Discount Badge */

.badge{
    position:absolute;
    top:12px;
    left:12px;
    background:#d10000;
    color:#fff;
    padding:5px 10px;
    font-size:12px;
    border-radius:20px;
}

/* ================= HOME BANNER ================= */

.home-banner{
    position:relative;
    width:100%;
    height:500px;
    background:url('images/shoe2.jpg') center/cover no-repeat;
    display:flex;
    align-items:center;
    justify-content:flex-end;
    padding:50px;
}

.home-banner::before{
    content:"";
    position:absolute;
    right:0;
    width:60%;
    height:100%;
    background:linear-gradient(to right,transparent,rgba(0,0,0,0.8));
}

.banner-content{
    position:relative;
    color:#fff;
    max-width:500px;
}

.banner-content h1{
    font-size:42px;
    margin-bottom:15px;
}

.banner-content p{
    font-size:18px;
    margin-bottom:25px;
}

.btn-white{
    padding:12px 25px;
    background:#fff;
    color:#000;
    text-decoration:none;
    font-weight:600;
    border-radius:4px;
    transition:0.3s;
}

.btn-white:hover{
    background:#000;
    color:#fff;
}

/* ================= TRENDING PRODUCTS ================= */

.trending-section{
    padding:40px 5%;
    background:#f8f8f8;
}

.trending-section h2{
    margin-bottom:20px;
}

.trending-products{
    display:flex;
    gap:20px;
    overflow-x:auto;
}

.trend-card{
    position:relative;
    min-width:220px;
    background:#fff;
    padding:15px;
    border-radius:10px;
    box-shadow:0 6px 15px rgba(0,0,0,0.08);
    text-align:center;
    transition:0.3s;
}

.trend-card:hover{
    transform:translateY(-5px);
}

.trend-link{
    text-decoration:none;
    color:inherit;
}

.trend-card img{
    width:100%;
    height:180px;
    object-fit:contain;
}

/* Discount Badge */

.trend-badge{
    position:absolute;
    top:10px;
    left:10px;
    background:#f0bd31;
    color:#fff;
    padding:5px 10px;
    font-size:12px;
    border-radius:20px;
}

/* Price */

.price-box{
    margin-top:8px;
}

.new-price{
    color:#e60023;
    font-weight:bold;
}

.old-price{
    text-decoration:line-through;
    color:#888;
}

.normal-price{
    font-weight:bold;
}

/* ================= MOBILE ================= */

@media (max-width:768px){

.home-banner{
    justify-content:center;
    text-align:center;
    height:400px;
}

.home-banner::before{
    width:100%;
    background:rgba(0,0,0,0.6);
}

.banner-content h1{
    font-size:28px;
}

}

</style>
</head>
<body>

<!-- ===== HERO SECTION ===== -->
<section class="hero">
    <img src="images/login_bg.png" class="hero-img">
    <div class="hero-content">
        <h1>Premium Performance</h1>
        <p>Collection 2026</p>
        <a href="#products" class="shop-btn">SHOP NOW</a>
    </div>
</section>
<!-- ===== END HERO ===== -->
<!-- ===== PRODUCTS ===== -->

<section class="products-section" id="products">
    <h2>OUR PRODUCTS</h2>

    <div class="products-container">
        <!-- Your PHP loop product-card here -->
         <?php
$result = mysqli_query($conn, "SELECT * FROM products LIMIT 5");

while($row = mysqli_fetch_assoc($result)){

    $price = (float)$row['price'];
    $discount = isset($row['discount']) ? (int)$row['discount'] : 0;

    $discount_price = $price;

    if($discount > 0){
        $discount_price = $price - ($price * $discount / 100);
    }
?>
<a href="product.php?id=<?php echo $row['product_id']; ?>" class="product-link">
<div class="product-card">

    <?php if($discount > 0){ ?>
        <div class="badge"><?php echo $discount; ?>% OFF</div>
    <?php } ?>

    <img src="images/<?php echo $row['image1']; ?>" alt="">

    <h3><?php echo $row['product_name']; ?></h3>

    <div class="price-section">
        <?php if($discount > 0){ ?>
            <span class="new-price">₹<?php echo number_format($discount_price, 0); ?></span>
            <span class="old-price">₹<?php echo number_format($price, 0); ?></span>
        <?php } else { ?>
            <span class="normal-price">₹<?php echo number_format($price, 0); ?></span>
        <?php } ?>
    </div>

</div>

<?php } ?>

    </div>
</section>

<section class="home-banner">
    <div class="banner-content">
        
    <h1>OWN THE STREET</h1>
        <p>Fresh Drops. Bold Designs. Everyday Energy.</p>
        <div class="banner-buttons">
            <a href="men.php" class="btn-white">Shop Now</a>
        </div>
    </div>
</section>

<!-- ===== TRENDING NOW ===== -->
<section class="trending-section" id="trending">

    <h2>TRENDING NOW</h2>

    <div class="trending-products">

    <?php
    $result = mysqli_query($conn, 
        "SELECT * FROM products ORDER BY product_id DESC LIMIT 8"
    );

    while($row = mysqli_fetch_assoc($result)){

        $price = (float)$row['price'];
        $discount = isset($row['discount']) ? (int)$row['discount'] : 0;
        $final_price = $price;

        if($discount > 0){
            $final_price = $price - ($price * $discount / 100);
        }
    ?>

        <div class="trend-card">

            <a href="product.php?id=<?php echo $row['product_id']; ?>" class="trend-link">

                <?php if($discount > 0){ ?>
                    <span class="trend-badge">
                        <?php echo $discount; ?>% OFF
                    </span>
                <?php } ?>

                <img src="images/<?php echo $row['image1']; ?>" 
                     alt="<?php echo $row['product_name']; ?>">

                <h3><?php echo $row['product_name']; ?></h3>

                <div class="price-box">
                    <?php if($discount > 0){ ?>
                        <span class="new-price">
                            ₹<?php echo number_format($final_price,0); ?>
                        </span>

                        <span class="old-price">
                            ₹<?php echo number_format($price,0); ?>
                        </span>
                    <?php } else { ?>
                        <span class="normal-price">
                            ₹<?php echo number_format($price,0); ?>
                        </span>
                    <?php } ?>
                </div>

            </a>

        </div>

    <?php } ?>

    </div>

</section>

<?php include("footer.php"); ?>

</body>
</html>
