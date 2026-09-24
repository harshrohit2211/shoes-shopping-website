<?php
session_start();
include("db.php");

// Check if product ID is provided
if(!isset($_GET['id'])){
    header("Location: index.php");
    exit();
}

$product_id = (int)$_GET['id'];

// Fetch product with category
$sql = "SELECT p.*, c.category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.category_id
        WHERE p.product_id = $product_id";

$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if(!$product){
    echo "Product not found";
    exit();
}
/* =========================
   WISHLIST CHECK
========================= */
$in_wishlist = false;

if(isset($_SESSION['user_id'])){
    $uid = $_SESSION['user_id'];

    $wish_check = mysqli_query($conn,
        "SELECT * FROM wishlist 
         WHERE user_id='$uid' AND product_id='$product_id'"
    );

    if(mysqli_num_rows($wish_check) > 0){
        $in_wishlist = true;
    }
}
// ADD TO CART
if(isset($_POST['add_to_cart'])){

    if(!isset($_SESSION['user_id'])){
        echo "<script>alert('Please login first');</script>";
    } else {
    if($product['stock'] <= 0){
    echo "<script>alert('Product is out of stock');</script>";
    exit();
    }
        $user_id = $_SESSION['user_id'];
        $qty  = (int)$_POST['qty'];

        // ✅ NEW (get color & size)
        $color = mysqli_real_escape_string($conn, $_POST['color']);
        $size  = mysqli_real_escape_string($conn, $_POST['size']);

        $price = $product['price']; // snapshot price
        $subtotal = $price * $qty;

        // 1️⃣ Check pending order
        $order_q = mysqli_query($conn,
            "SELECT order_id FROM orders 
             WHERE user_id='$user_id' AND status='Pending'"
        );
        $order = mysqli_fetch_assoc($order_q);

        if(!$order){
            mysqli_query($conn,
                "INSERT INTO orders (user_id, total_amount, status)
                 VALUES ('$user_id', 0, 'Pending')"
            );
            $order_id = mysqli_insert_id($conn);
        } else {
            $order_id = $order['order_id'];
        }

        // 2️⃣ Check SAME product + color + size
        $check = mysqli_query($conn,
            "SELECT * FROM order_details 
             WHERE order_id='$order_id'
             AND product_id='$product_id'
             AND color='$color'
             AND size='$size'"
        );
        $exists = mysqli_fetch_assoc($check);

        if($exists){
            $new_qty = $exists['quantity'] + $qty;
            $new_sub = $new_qty * $price;

            mysqli_query($conn,
                "UPDATE order_details 
                 SET quantity='$new_qty', subtotal='$new_sub'
                 WHERE orderdetail_id='{$exists['orderdetail_id']}'"
            );
        } else {
            // ✅ INSERT WITH COLOR, SIZE, PRICE
            mysqli_query($conn,
                "INSERT INTO order_details 
                 (order_id, product_id, color, size, price, quantity, subtotal)
                 VALUES
                 ('$order_id','$product_id','$color','$size','$price','$qty','$subtotal')"
            );
        }

        // 3️⃣ Update order total
        mysqli_query($conn,
            "UPDATE orders SET total_amount = (
                SELECT SUM(subtotal) FROM order_details WHERE order_id='$order_id'
            ) WHERE order_id='$order_id'"
        );

        echo "<script>alert('Product added to cart');</script>";
    }
}
?>
<?php
$price = (float)$product['price'];
$discount = isset($product['discount']) ? (int)$product['discount'] : 0;

$final_price = $price;

if($discount > 0){
    $final_price = $price - ($price * $discount / 100);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $product['product_name']; ?> |  Collection</title>
    <style>/* ===============================
   GLOBAL
=================================*/
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:#f9f9f9;
    color:#111;
}

.product-page{
    max-width:1200px;
    margin:60px auto;
    padding:0 20px;
}
/* ===============================
   IMAGE GRID
=================================*/

.image-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:60px;
}

/* IMAGE CARD */

.grid-item{
    background:#fff;
    border-radius:12px;
    padding:10px;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

/* IMAGE */

.grid-item img{
    width:100%;
    max-height:320px;
    object-fit:contain;
    transition:0.3s;
}

/* HOVER EFFECT */

.grid-item:hover img{
    transform:scale(1.05);
}
/* ===============================
   PRODUCT INFO SECTION
=================================*/
.product-info-container{
    display:grid;
    grid-template-columns:1.2fr 1fr;
    gap:80px;
    align-items:start;
}

.collection-label{
    display:block;
    font-size:12px;
    letter-spacing:3px;
    color:#999;
    margin-bottom:15px;
}

.product-title{
    font-size:32px;
    font-weight:600;
    margin-bottom:25px;
}

.product-description{
    font-size:15px;
    line-height:1.8;
    color:#555;
}

/* ===============================
   PRICE SECTION
=================================*/
.price-tag{
    font-size:28px;
    margin-bottom:40px;
    text-align:right;
}

.new-price{
    color:#e60023;
    font-weight:600;
}

.old-price{
    text-decoration:line-through;
    color:#999;
    margin-left:12px;
    font-size:16px;
}

.discount-badge{
    background:#000;
    color:#fff;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    margin-left:12px;
}

/* ===============================
   SPECS GRID
=================================*/
.specs-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
    margin-bottom:30px;
}

.spec-box{
    background:#fff;
    padding:18px;
    border-radius:10px;
    border:1px solid #eee;
}

.spec-box.full-width{
    grid-column:span 2;
}

.spec-box label{
    display:block;
    font-size:11px;
    letter-spacing:2px;
    color:#888;
    margin-bottom:8px;
}

.spec-box select{
    width:100%;
    padding:8px;
    border-radius:6px;
    border:1px solid #ccc;
    font-size:14px;
}

/* ===============================
   BUTTON
=================================*/
.btn-private{
    width:100%;
    padding:18px;
    background:#000;
    color:#fff;
    border:none;
    border-radius:8px;
    font-size:14px;
    letter-spacing:2px;
    cursor:pointer;
    transition:0.3s ease;
}

.btn-private:hover{
    background:#222;
    letter-spacing:3px;
}

/* ===============================
   SIMILAR PRODUCTS
=================================*/
.similar-products-section{
    max-width:1200px;
    margin:100px auto 60px;
    padding:0 20px;
}

.similar-heading{
    text-align:center;
    font-size:22px;
    letter-spacing:4px;
    margin-bottom:50px;
}

.similar-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:30px;
}

.similar-card{
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 20px rgba(0,0,0,0.05);
    transition:0.3s;
    text-align:center;
}

.similar-card:hover{
    transform:translateY(-5px);
}

.similar-card img{
    width:100%;
    height:240px;
    object-fit:contain;
    padding:10px;
    background:#fff;
}


.similar-card:hover img{
    transform:scale(1.05);
}

.similar-info{
    padding:18px;
    text-align:center;
}

.similar-info h4{
    font-size:14px;
    letter-spacing:2px;
    margin-bottom:10px;
}

.similar-info p{
    font-size:14px;
}

/* ===============================
   RESPONSIVE
=================================*/
@media(max-width:992px){

.image-grid{
    grid-template-columns:repeat(2,1fr);
}

.similar-grid{
    grid-template-columns:repeat(2,1fr);
}

}

@media(max-width:576px){

.image-grid{
    grid-template-columns:1fr;
}

.similar-grid{
    grid-template-columns:1fr;
}

}
/* ===== ACTION ROW ===== */
.action-row{
    display:flex;
    gap:15px;
    align-items:center;
}

/* ===== WISHLIST WHITE BOX ===== */
.wishlist-box{
    width:55px;
    height:55px;
    background:#fff;
    border:1px solid #ddd;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    text-decoration:none;
    color:#000;
    transition:0.3s;
}

.wishlist-box:hover{
    color:red;
    border-color:#000;
    transform:scale(1.05);
}

/* If already added */
.wishlist-box.active{
    color:red;
    border-color:#000;
}

/* Disabled Button */
.btn-private.disabled{
    background:#ccc;
    cursor:not-allowed;
}
        </style>
</head>
<body>

<?php include("header.php"); ?>

<main class="product-page">
    <section class="image-grid">
        <div class="grid-item"><img src="images/<?php echo $product['image1']; ?>" alt="Front View"></div>
        <div class="grid-item"><img src="images/<?php echo $product['image2']; ?>" alt="Side View"></div>
        <div class="grid-item"><img src="images/<?php echo $product['image3']; ?>" alt="Detail View"></div>
        <div class="grid-item"><img src="images/<?php echo $product['image4']; ?>" alt="Sole View"></div>
    </section>

    <section class="product-info-container">
        <div class="info-left">
            <span class="collection-label"><?php echo $product['category_name']; ?> COLLECTION</span>
            <h1 class="product-title"><?php echo strtoupper($product['product_name']); ?></h1>
            <p class="product-description">
                <?php echo nl2br($product['description']); ?>
            </p>
        </div>

        <div class="info-right">
            <div class="price-tag">

    <?php if($discount > 0){ ?>
        <span class="new-price">₹<?php echo number_format($final_price,0); ?></span>
        <span class="old-price">₹<?php echo number_format($price,0); ?></span>
        <span class="discount-badge"><?php echo $discount; ?>% OFF</span>
    <?php } else { ?>
        ₹<?php echo number_format($price,0); ?>
    <?php } ?>

</div>        
            <form method="post" class="purchase-form">
                <div class="specs-grid">
                    <div class="spec-box">
                        <label>AVAILABLE COLOR</label>
                        <select name="color" required>
                            <?php
                            foreach(explode(",", $product['color']) as $c){
                                echo "<option value='".trim($c)."'>".strtoupper(trim($c))."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="spec-box">
                        <label>STANDARD SIZE</label>
                        <select name="size" required>
                            <?php
                            foreach(explode(",", $product['size']) as $s){
                                echo "<option value='".trim($s)."'>".trim($s)."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="spec-box full-width">
                        <label>STOCK AVAILABILITY</label>
                        <span><?php echo $product['stock']; ?> PIECES LEFT</span>
                        <input type="hidden" name="qty" value="1">
                    </div>
                </div>
                
 <div class="action-row">

<?php if($product['stock'] > 0){ ?>
   <button type="submit" name="add_to_cart" class="btn-private">
      ADD TO CART
   </button>
<?php } else { ?>
   <button type="button" class="btn-private disabled">
      OUT OF STOCK
   </button>
<?php } ?>


<a href="add_to_wishlist.php?id=<?php echo $product_id; ?>" 
   class="wishlist-box <?php echo $in_wishlist ? 'active' : ''; ?>">
   <?php echo $in_wishlist ? '❤️' : '♡'; ?>
</a>


</div>
            </form>
        </div>
    </section>
</main>
<?php
// Get similar products (same category)
$category_id = $product['category_id'];

$similar_query = mysqli_query($conn,
    "SELECT * FROM products
     WHERE category_id = '$category_id'
     AND product_id != '$product_id'
     LIMIT 4"
);
?>

<section class="similar-products-section">
    <h2 class="similar-heading">YOU MAY ALSO LIKE</h2>

    <div class="similar-grid">
        <?php while($row = mysqli_fetch_assoc($similar_query)) { ?>
            
            <div class="similar-card">
                <a href="product.php?id=<?php echo $row['product_id']; ?>">
                    <img src="images/<?php echo $row['image1']; ?>" alt="">
                </a>

                <div class="similar-info">
                    <h4><?php echo strtoupper($row['product_name']); ?></h4>
                    <?php
$sp_price = (float)$row['price'];
$sp_discount = isset($row['discount']) ? (int)$row['discount'] : 0;
$sp_final = $sp_price;

if($sp_discount > 0){
    $sp_final = $sp_price - ($sp_price * $sp_discount / 100);
}
?>

<p>
<?php if($sp_discount > 0){ ?>
    <span style="color:#b39b6d;font-weight:bold;">
        ₹<?php echo number_format($sp_final,0); ?>
    </span>
    <span style="text-decoration:line-through;color:#999;font-size:13px;">
        ₹<?php echo number_format($sp_price,0); ?>
    </span>
<?php } else { ?>
    ₹<?php echo number_format($sp_price,2); ?>
<?php } ?>
</p>

                </div>
            </div>

        <?php } ?>
    </div>
</section>

<?php include("footer.php"); ?>

</body>
</html>