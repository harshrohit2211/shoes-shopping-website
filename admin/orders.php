<?php
session_start();
include("../db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin'){
    header("Location: ../index.php");
    exit();
}
if(isset($_POST['update_status'])){

    $order_id = (int)$_POST['order_id'];
    $new_status = $_POST['status'];

    // Get old status
    $orderData = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT status FROM orders WHERE order_id='$order_id'"
    ));

    if(!$orderData){
        header("Location: orders.php");
        exit();
    }

    $old_status = $orderData['status'];

    // If status same, do nothing
    if($old_status == $new_status){
        header("Location: orders.php");
        exit();
    }

    /* =========================================
       1️⃣ REDUCE STOCK (Pending → Processing)
    ==========================================*/
    if($old_status == 'Pending' && $new_status == 'Processing'){

        $items = mysqli_query($conn,
            "SELECT product_id, quantity 
             FROM order_details 
             WHERE order_id='$order_id'"
        );

        while($row = mysqli_fetch_assoc($items)){

            // Check available stock
            $stockCheck = mysqli_fetch_assoc(mysqli_query($conn,
                "SELECT stock FROM products WHERE product_id='{$row['product_id']}'"
            ));

            if($stockCheck['stock'] >= $row['quantity']){

                mysqli_query($conn,
                    "UPDATE products 
                     SET stock = stock - {$row['quantity']}
                     WHERE product_id = {$row['product_id']}"
                );

            } else {
                // Not enough stock
                echo "<script>alert('Not enough stock for one or more products!'); window.location='orders.php';</script>";
                exit();
            }
        }
    }

    /* =========================================
       2️⃣ RESTORE STOCK (Processing → Cancelled)
    ==========================================*/
    if($old_status == 'Processing' && $new_status == 'Cancelled'){

        $items = mysqli_query($conn,
            "SELECT product_id, quantity 
             FROM order_details 
             WHERE order_id='$order_id'"
        );

        while($row = mysqli_fetch_assoc($items)){

            mysqli_query($conn,
                "UPDATE products 
                 SET stock = stock + {$row['quantity']}
                 WHERE product_id = {$row['product_id']}"
            );
        }
    }

    // Finally update order status
    mysqli_query($conn,
        "UPDATE orders SET status='$new_status' WHERE order_id='$order_id'"
    );

    header("Location: orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Orders</title>
<link rel="stylesheet" href="admin.css">
<style>

.status-badge{
    padding:5px 12px;
    border-radius:20px;
    color:white;
    font-size:12px;
}

.pending{ background:orange; }
.processing{ background:blue; }
.delivered{ background:green; }
.cancelled{ background:red; }

.view-btn{
    background:#1e4d3d;
    color:white;
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    font-size:12px;
}

select{
    padding:5px;
    border-radius:5px;
}
/* ===== RESET ===== */
*{
    box-sizing:border-box;
}

/* ===== BODY ===== */
body{
    margin:0;
    font-family: Arial, sans-serif;
    display:flex;
    background:#f4f6f9;
}

/* ===== SIDEBAR ===== */
.sidebar{
    width:220px;
    background:#1e4d3d;
    color:white;
    height:100vh;
    padding:20px;
    position:fixed;
    left:0;
    top:0;
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
}

.sidebar a:hover,
.sidebar .active{
    background:#2f7f63;
}

/* ===== MAIN CONTENT ===== */
.main{
    margin-left:220px;
    flex:1;
    padding:30px;
}

/* ===== DASHBOARD CARDS ===== */
.cards{
    display:flex;
    gap:20px;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.card{
    flex:1 1 250px;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

.card.orange h2{ color:orange; }
.card.green h2{ color:green; }

/* ===== TABLE ===== */
.table-wrapper{
    overflow-x:auto;
}

table{
    width:100%;
    background:white;
    border-collapse:collapse;
    border-radius:10px;
    overflow:hidden;
    min-width:700px;
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

.status{
    padding:5px 10px;
    background:#2f7f63;
    color:white;
    border-radius:20px;
    font-size:12px;
}

/* ============================= */
/* ===== RESPONSIVE DESIGN ===== */
/* ============================= */

/* Tablet */
@media(max-width:992px){

    .cards{
        flex-direction:column;
    }
}

/* Mobile */
@media(max-width:768px){

    body{
        flex-direction:column;
    }

    .sidebar{
        width:100%;
        height:auto;
        position:relative;
    }

    .main{
        margin-left:0;
        padding:20px;
    }

    table{
        font-size:14px;
    }

    th, td{
        padding:8px;
    }
}
</style>
</head>
<body>

<?php include("sidebar.php"); ?>

<div class="main">

<h2>Manage Orders</h2>

<table>
<tr>
<th>Order ID</th>
<th>Customer</th>
<th>Total</th>
<th>Status</th>
<th>Date</th>
<th>Update</th>
<th>Details</th>
</tr>

<?php
$orders = mysqli_query($conn,"
    SELECT orders.*, users.name 
    FROM orders
    JOIN users ON orders.user_id = users.user_id
    ORDER BY order_id DESC
");

while($row = mysqli_fetch_assoc($orders)){

    $status_class = strtolower($row['status']);
?>

<tr>
<td>#<?php echo $row['order_id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td>₹<?php echo number_format($row['total_amount'], 0); ?></td>

<td>
<span class="status-badge <?php echo $status_class; ?>">
<?php echo $row['status']; ?>
</span>
</td>

<td><?php echo $row['order_date']; ?></td>

<td>
<form method="POST" style="display:flex; gap:5px;">
<input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">

<select name="status">
<option <?php if($row['status']=="Pending") echo "selected"; ?>>Pending</option>
<option <?php if($row['status']=="Processing") echo "selected"; ?>>Processing</option>
<option <?php if($row['status']=="Delivered") echo "selected"; ?>>Delivered</option>
<option <?php if($row['status']=="Cancelled") echo "selected"; ?>>Cancelled</option>
</select>

<button type="submit" name="update_status">Save</button>
</form>
</td>

<td>
<a href="order_details.php?id=<?php echo $row['order_id']; ?>" class="view-btn">
View
</a>
</td>

</tr>

<?php } ?>

</table>

</div>
</body>
</html>