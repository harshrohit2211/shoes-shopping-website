<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Get latest shipped order */
$order_q = mysqli_query($conn,
    "SELECT * FROM orders 
     WHERE user_id='$user_id' 
     ORDER BY order_id DESC LIMIT 1"
);

$order = mysqli_fetch_assoc($order_q);

if (!$order) {
    header("Location: index.php");
    exit();
}

$order_id = $order['order_id'];

/* Fetch order items */
$items = mysqli_query($conn,
    "SELECT od.*, p.product_name, p.image1, p.discount
     FROM order_details od
     JOIN products p ON od.product_id = p.product_id
     WHERE od.order_id='$order_id'"
);

$subtotal = 0;
$total_savings = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Success</title>
<link rel="stylesheet" href="css/cart.css">
<style>
body {
    margin: 0;
    padding: 0;
    background: #f4f6f9;
    font-family: Arial, sans-serif;
}

/* Main Success Card */
.success-box {
    max-width: 900px;
    margin: 60px auto;
    background: #ffffff;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
}

/* Success Header */
.success-title {
    text-align: center;
    background: #e9f9ee;
    color: #1a7f37;
    padding: 20px;
    border-radius: 10px;
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 30px;
}

/* Order ID */
.success-box p {
    font-size: 15px;
    margin-bottom: 10px;
}

/* Table */
.order-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.order-table th {
    background: #f0bd31;
    color: #fff;
    padding: 12px;
    text-align: left;
    font-size: 14px;
}

.order-table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

.order-table img {
    border-radius: 6px;
    margin-bottom: 5px;
}

/* Price Styling */
.order-table span {
    display: inline-block;
}

.order-table .old-price {
    text-decoration: line-through;
    color: #888;
    font-size: 12px;
}

.order-table .new-price {
    color: #e60023;
    font-weight: bold;
}

/* Summary Section */
hr {
    margin: 30px 0;
}

.summary-box {
    background: #fafafa;
    padding: 20px;
    border-radius: 10px;
}

.summary-box p {
    display: flex;
    justify-content: space-between;
    margin: 8px 0;
    font-size: 15px;
}

.summary-box h3 {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    font-size: 18px;
}

/* Savings Highlight */
.saving-text {
    color: #e60023;
    font-weight: bold;
    margin-top: 10px;
}

/* Continue Button */
.continue-btn {
    display: inline-block;
    margin-top: 25px;
    padding: 12px 25px;
    background: #f0bd31;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    transition: 0.3s;
}

.continue-btn:hover {
    background: #d9a820;
}

</style>
</head>
<body>

<?php include("header.php"); ?>

<div class="success-box">

<div class="success-title">
    ✅ Order Placed Successfully!
</div>

<p><b>Order ID:</b> #<?php echo $order_id; ?></p>
<br>

<table class="order-table">
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Total</th>
</tr>

<?php
while($row = mysqli_fetch_assoc($items)){

    $original_price = (float)$row['price'];
    $discount = isset($row['discount']) ? (int)$row['discount'] : 0;
    $final_price = $original_price;

    if($discount > 0){
        $final_price = $original_price - ($original_price * $discount / 100);
    }

    $item_total = $final_price * $row['quantity'];
    $subtotal += $item_total;

    $total_savings += ($original_price - $final_price) * $row['quantity'];
?>

<tr>
<td>
    <img src="images/<?php echo $row['image1']; ?>" width="50"><br>
    <?php echo $row['product_name']; ?>
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

<hr>
<div class="summary-box">
    <p><span>Subtotal:</span> <span>₹<?php echo number_format($subtotal,0); ?></span></p>
    <p><span>Shipping:</span> <span>₹<?php echo number_format($shipping,0); ?></span></p>

    <?php if($total_savings > 0){ ?>
        <p class="saving-text">
            🎉 You Saved ₹<?php echo number_format($total_savings,0); ?>
        </p>
    <?php } ?>

    <h3>
        <span>Total Paid:</span> 
        <span>₹<?php echo number_format($grand_total,0); ?></span>
    </h3>
</div>

<a href="index.php" class="continue-btn">Continue Shopping →</a>

</div>

<?php include("footer.php"); ?>

</body>
</html>
