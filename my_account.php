<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$user = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT * FROM users WHERE user_id = $user_id"
));

// Fetch orders
$orders = mysqli_query(
    $conn,
    "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC"
);
?>


<!DOCTYPE html>
<html>
<head>
    <title>My Account</title>
    <link rel="stylesheet" href="./css/my_account.css">
</head>
<body>
<?php include("header.php"); ?>
<div class="account-container">
   

    <!-- PROFILE -->
    <div class="card">
        <h3>Profile Information</h3>
        <p><b>Name:</b> <?= $user['name']; ?></p>
        <p><b>Email:</b> <?= $user['email']; ?></p>
        <p><b>Phone:</b> <?= $user['phone']; ?></p>
        <p><b>Address:</b> <?= $user['address']; ?></p>

        <a href="edit_profile.php" class="btn">Edit Profile</a>
        <a href="order_details.php" class="btn view-details">View Order Details</a>
        <a href="logout.php" class="btn logout">Logout</a>
        

    </div>

    <!-- ORDERS -->
    <div class="orders">
        <h3>My Orders</h3>

        <?php if (mysqli_num_rows($orders) > 0) { ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>

                <?php while ($order = mysqli_fetch_assoc($orders)) { ?>
                    <tr>
                        <td>#<?= $order['order_id']; ?></td>
                        <td><?= $order['order_date']; ?></td>
                        <td>₹<?= (int)$order['total_amount']; ?></td>
                        <td><?= $order['status']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No orders found.</p>
        <?php } ?>
    </div>
</div>

<?php include("footer.php"); ?>
</body>
</html>