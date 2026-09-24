<?php
session_start();
include("db.php");
include("header.php");

$type = isset($_GET['type']) ? $_GET['type'] : '';

// Base query (men Shoes)
$query = "
    SELECT p.* 
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_name = 'Women Shoes'
";

// Filter by shoe type
if ($type != '') {
    $query .= " AND p.shoe_type = '$type'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Women Shoes</title>

    <!-- Same CSS as index & men -->
    <link rel="stylesheet" href="css/index.css">

    <style>
     /* ===============================
   SHOP LAYOUT
================================*/
.shop-layout{
    display:flex;
    gap:25px;
    padding:30px;
    background:#f8f5fb;
    min-height:100vh;
}

/* ===============================
   SIDEBAR
================================*/
.sidebar{
    width:230px;
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
}

.sidebar h3{
    margin-bottom:15px;
    font-size:18px;
    color:#333;
    border-bottom:2px solid #f0bd31;
    padding-bottom:6px;
}

.sidebar ul{
    list-style:none;
}

.sidebar ul li{
    margin-bottom:8px;
}

.sidebar ul li a{
    display:block;
    text-decoration:none;
    color:#555;
    font-size:14px;
    padding:8px 12px;
    border-radius:6px;
    transition:0.3s;
}

.sidebar ul li a:hover{
    background:#f0bd31;
    color:#fff;
}

/* ===============================
   MAIN CONTENT
================================*/
.main-content{
    flex:1;
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
}

.main-content h1{
    margin-bottom:25px;
    font-size:24px;
    color:#333;
    border-bottom:2px solid #f0bd31;
    display:inline-block;
    padding-bottom:5px;
}

/* ===============================
   PRODUCTS GRID
================================*/
.products{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(230px,1fr));
    gap:25px;
}

/* ===============================
   PRODUCT CARD
================================*/
.product{
    position:relative;
    background:#fff;
    padding:15px;
    border-radius:12px;
    box-shadow:0 6px 16px rgba(0,0,0,0.08);
    text-align:center;
    transition:0.3s;
}

.product:hover{
    transform:translateY(-6px);
}

/* Remove link style */
.product-link{
    text-decoration:none;
    color:inherit;
}

/* ===============================
   PRODUCT IMAGE
================================*/
.product img{
    width:100%;
    height:200px;
    object-fit:contain; /* FIXED cropping problem */
    background:#fafafa;
    border-radius:8px;
    padding:10px;
}

/* ===============================
   PRODUCT NAME
================================*/
.product h4{
    margin-top:10px;
    font-size:15px;
    color:#333;
}

/* ===============================
   DISCOUNT BADGE
================================*/
.discount-badge{
    position:absolute;
    top:12px;
    left:12px;
    background:#f0bd31;
    color:#fff;
    padding:5px 10px;
    font-size:12px;
    font-weight:bold;
    border-radius:20px;
    box-shadow:0 3px 8px rgba(0,0,0,0.15);
}

/* ===============================
   PRICE SECTION
================================*/
.price-box{
    margin-top:8px;
}

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

.normal-price{
    font-size:18px;
    font-weight:bold;
    color:#333;
}

/* ===============================
   RESPONSIVE
================================*/
@media(max-width:900px){

.shop-layout{
    flex-direction:column;
}

.sidebar{
    width:100%;
}

.products{
    grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
}

}

@media(max-width:500px){

.products{
    grid-template-columns:1fr;
}

}    
    </style>
</head>

<body>

<div class="shop-layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h3>Filter By</h3>
        <ul>
            <li><a href="Women.php">All</a></li>
            <li><a href="Women.php?type=Partywear">Partywear</a></li>
            <li><a href="Women.php?type=Casual">Casual</a></li>
            <li><a href="Women.php?type=Sports">Sports</a></li>
            <li><a href="Women.php?type=Formal">Formal</a></li>
        </ul>
    </aside>

    <!-- PRODUCTS -->
    <main class="main-content">
        <h1>Women's Collection</h1>

        <div class="products">

        <?php while($row = mysqli_fetch_assoc($result)){ 

            $price = (float)$row['price'];
            $discount = isset($row['discount']) ? (int)$row['discount'] : 0;
            $final_price = $price;

            if($discount > 0){
                $final_price = $price - ($price * $discount / 100);
            }
        ?>

            <div class="product">

                <a href="product.php?id=<?php echo $row['product_id']; ?>" class="product-link">

                    <?php if($discount > 0){ ?>
                        <span class="discount-badge">
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
    </main>

</div>

<?php include("footer.php"); ?>
