<?php
include("db.php");

$search = isset($_GET['query']) ? trim($_GET['query']) : '';

$products = [];

if($search != ''){

    $search = mysqli_real_escape_string($conn, $search);

    $query = "
        SELECT * FROM products 
        WHERE 
            product_name LIKE '%$search%' 
            OR color LIKE '%$search%' 
            OR size LIKE '%$search%' 
            OR shoe_type LIKE '%$search%'
    ";

    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Search Results</title>
<style>
.products-section {
    padding: 40px 5%;
    background: #f8f8f8;
}

.products-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
}

.product-link {
    text-decoration: none;
    color: inherit;
}

.product-card {
    position: relative;
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
    text-align: center;
    transition: 0.3s;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}

/* Discount Badge */
.discount-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: #f0bd31;
    color: white;
    padding: 5px 10px;
    font-size: 12px;
    border-radius: 20px;
}

/* Prices */
.new-price {
    color: #e60023;
    font-weight: bold;
}

.old-price {
    text-decoration: line-through;
    color: #888;
    margin-left: 6px;
}

.normal-price {
    font-weight: bold;
}

</style>
</head>
<body>

<?php include("header.php"); ?>

<section class="products-section">

<h2 style="text-align:center;margin:40px 0;">
Search Results for "<?php echo htmlspecialchars($search); ?>"
</h2>

<div class="products-container">

<?php 
if(isset($result) && mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){

        $price = (float)$row['price'];
        $discount = isset($row['discount']) ? (int)$row['discount'] : 0;
        $final_price = $price;

        if($discount > 0){
            $final_price = $price - ($price * $discount / 100);
        }
?>

<a href="product.php?id=<?php echo $row['product_id']; ?>" class="product-link">

    <div class="product-card">

        <?php if($discount > 0){ ?>
            <span class="discount-badge"><?php echo $discount; ?>% OFF</span>
        <?php } ?>

        <img src="images/<?php echo $row['image1']; ?>">

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

    </div>

</a>

<?php } 

} else {

    echo "<p style='text-align:center;font-size:18px;'>No products found.</p>";

}
?>

</div>
</section>

<?php include("footer.php"); ?>

</body>
</html>
