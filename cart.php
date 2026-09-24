<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Fetch user address */
$user_q = mysqli_query($conn, "SELECT address FROM users WHERE user_id='$user_id'");
$user = mysqli_fetch_assoc($user_q);
$user_address = $user['address'] ?? "Address not available";

/* Get pending order */
$order_q = mysqli_query($conn,
    "SELECT * FROM orders 
     WHERE user_id='$user_id' AND status='Pending'"
);
$order = mysqli_fetch_assoc($order_q);

if (!$order) {
    header("Location: cart_empty.php");
    exit();
}

$order_id = $order['order_id'];

/* Fetch cart items with discount */
$items = mysqli_query($conn,
    "SELECT od.*, p.product_name, p.image1, p.discount
     FROM order_details od
     JOIN products p ON od.product_id = p.product_id
     WHERE od.order_id='$order_id'"
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Shopping Cart</title>
<link rel="stylesheet" href="css/cart.css">
<style>
    .address-form textarea{
    width:100%;
    height:70px;
    padding:10px;
    border-radius:6px;
    border:1px solid #ccc;
    resize:none;
    margin-bottom:10px;
    font-family:inherit;
}

.update-btn{
    background:#f0bd31;
    color:white;
    padding:8px 14px;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.update-btn:hover{
    background:#000;
}
</style>
</head>
<body>

<?php include("header.php"); ?>

<div class="cart-container">

<!-- LEFT SIDE -->
<div class="cart-left">
<h2>Shopping Cart</h2>

<table>
<tr>
  <th>Product</th>
  <th>Price</th>
  <th>Quantity</th>
  <th>Total</th>
  <th></th>
</tr>

<?php
$subtotal = 0;

while ($row = mysqli_fetch_assoc($items)) {

    $original_price = (float)$row['price'];
    $discount = isset($row['discount']) ? (int)$row['discount'] : 0;

    $final_price = $original_price;

    if($discount > 0){
        $final_price = $original_price - ($original_price * $discount / 100);
    }

    $item_total = $final_price * $row['quantity'];
    $subtotal += $item_total;
?>

<tr>
<td>
    <img src="images/<?php echo $row['image1']; ?>" width="60"><br>
    <b><?php echo $row['product_name']; ?></b><br>
    <small>
        Color: <?php echo $row['color']; ?> |
        Size: <?php echo $row['size']; ?>
    </small>
</td>

<td>
<?php if($discount > 0){ ?>
    <span style="color:#e60023;font-weight:bold;">
        ₹<?php echo number_format($final_price, 0); ?>
    </span><br>
    <small style="text-decoration:line-through;color:#888;">
        ₹<?php echo number_format($original_price, 0); ?>
    </small>
<?php } else { ?>
    ₹<?php echo number_format($original_price, 0); ?>
<?php } ?>
</td>

<td>
<form method="post" action="update_qty.php">
    <input type="hidden" name="orderdetail_id" value="<?php echo $row['orderdetail_id']; ?>">
    <button name="minus">−</button>
    <input type="text" value="<?php echo $row['quantity']; ?>" size="1" readonly>
    <button name="plus">+</button>
</form>
</td>

<td>₹<?php echo number_format($item_total, 0); ?></td>

<td>
<a href="remove_item.php?id=<?php echo $row['orderdetail_id']; ?>">🗑</a>
</td>
</tr>

<?php } ?>
</table>

<br>
<a href="index.php">← Continue Shopping</a> |
<a href="clear_cart.php" class="clear-btn">Clear Cart</a>

</div>

<!-- RIGHT SIDE -->
<div class="cart-right">
<h3>Cart Summary</h3>

<?php
$shipping = 10;
$grand_total = $subtotal + $shipping;

/* Update order total */
mysqli_query($conn,
    "UPDATE orders 
     SET total_amount='$grand_total'
     WHERE order_id='$order_id'"
);
?>

<p>Subtotal <span>₹<?php echo number_format($subtotal, 0); ?></span></p>
<p>Shipping <span>₹<?php echo number_format($shipping, 0); ?></span></p>
<hr>
<p><b>Total</b> <span><b>₹<?php echo number_format($grand_total, 0); ?></b></span></p>

<h4>Shipping Address</h4>

<?php
/* ===== UPDATE ADDRESS ===== */
if(isset($_POST['update_address'])){
    $new_address = mysqli_real_escape_string($conn, $_POST['new_address']);

    mysqli_query($conn,
        "UPDATE users 
         SET address='$new_address'
         WHERE user_id='$user_id'"
    );

    $user_address = $new_address;

    echo "<p style='color:green;'>Address updated successfully!</p>";
}
?>

<form method="post" class="address-form">
    <textarea name="new_address" required><?php echo $user_address; ?></textarea>
    <button type="submit" name="update_address" class="update-btn">
        Update Address
    </button>
</form>

<br>

<?php
if (isset($_POST['cod'])) {
    mysqli_query($conn,
        "UPDATE orders 
         SET status='Processing', total_amount='$grand_total'
         WHERE order_id='$order_id'"
    );

    echo "<script>
        alert('Order placed successfully!');
        window.location='order_success.php';
    </script>";
}
?>

<form method="post">
    <button type="submit" name="cod" class="cod-btn">
        Cash on Delivery
    </button>
</form>

</div>
</div>

<?php include("footer.php"); ?>
</body>
</html>
