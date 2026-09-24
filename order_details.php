<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$orderDetails = mysqli_query($conn, "
    SELECT 
        o.order_id,
        o.order_date,
        o.status,
        p.product_name,
        p.image1,
        p.discount,
        od.color,
        od.size,
        od.quantity,
        od.price
    FROM orders o
    JOIN order_details od ON o.order_id = od.order_id
    JOIN products p ON od.product_id = p.product_id
    WHERE o.user_id = $user_id
    ORDER BY o.order_date DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<title>My Orders</title>
<link rel="stylesheet" href="css/order_details.css">
<style></style>
</head>
<body>

<?php include("header.php"); ?>

<div class="details-container">
<h2>My Orders</h2>
<?php if(isset($_GET['cancel']) && $_GET['cancel'] == 'success'){ ?>
    <div class="success-message">
        ✅ Order cancelled successfully.
    </div>
<?php } ?>

<?php if (mysqli_num_rows($orderDetails) > 0) { ?>

<?php while ($row = mysqli_fetch_assoc($orderDetails)) {

    $original_price = (float)$row['price'];
    $discount = isset($row['discount']) ? (int)$row['discount'] : 0;
    $final_price = $original_price;

    if($discount > 0){
        $final_price = $original_price - ($original_price * $discount / 100);
    }

    $subtotal = $final_price * $row['quantity'];
    $saved = ($original_price - $final_price) * $row['quantity'];
?>

<div class="order-card">

    <div class="order-image">
        <img src="images/<?= $row['image1']; ?>">
    </div>

    <div class="order-info">
        <h3><?= $row['product_name']; ?></h3>

        <p><strong>Order ID:</strong> #<?= $row['order_id']; ?></p>
        <p><strong>Date:</strong> <?= date("d M Y", strtotime($row['order_date'])); ?></p>
        <p><strong>Color:</strong> <?= $row['color']; ?> | 
           <strong>Size:</strong> <?= $row['size']; ?></p>
        <p><strong>Quantity:</strong> <?= $row['quantity']; ?></p>

        <div class="price-section">
            <?php if($discount > 0){ ?>
                <span class="new-price">
                    ₹<?= number_format($final_price,0); ?>
                </span>
                <span class="old-price">
                    ₹<?= number_format($original_price,0); ?>
                </span>
            <?php } else { ?>
                <span class="normal-price">
                    ₹<?= number_format($original_price,0); ?>
                </span>
            <?php } ?>
        </div>

        <p class="subtotal">
            Subtotal: ₹<?= number_format($subtotal,0); ?>
        </p>

        <?php if($saved > 0){ ?>
            <p class="saved">
                🎉 You Saved ₹<?= number_format($saved,0); ?>
            </p>
        <?php } ?>

        <span class="status <?= strtolower($row['status']); ?>">
    <?= $row['status']; ?>
</span>

<?php if($row['status'] == 'Processing'){ ?>
    <a href="cancel_order.php?order_id=<?= $row['order_id']; ?>" 
       class="cancel-btn"
       onclick="return confirm('Are you sure you want to cancel this order?');">
       Cancel Order
    </a>
<?php } ?>

    </div>

</div>

<?php } ?>

<?php } else { ?>

<p class="no-orders">No orders found.</p>

<?php } ?>

</div>

<?php include("footer.php"); ?>
</body>
</html>
