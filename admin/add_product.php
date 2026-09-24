<?php
session_start();
include("../db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin'){
    header("Location: ../index.php");
    exit();
}

if(isset($_POST['add_product'])){

    $name       = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description= mysqli_real_escape_string($conn, $_POST['description']);
    $price      = $_POST['price'];
    $discount   = $_POST['discount'];
    $stock      = $_POST['stock'];
    $color      = $_POST['color'];
    $size       = $_POST['size'];
    $shoe_type  = $_POST['shoe_type'];
    $category   = $_POST['category'];

    // Upload Images
    $image1 = $_FILES['image1']['name'];
    $image2 = $_FILES['image2']['name'];
    $image3 = $_FILES['image3']['name'];
    $image4 = $_FILES['image4']['name'];

    move_uploaded_file($_FILES['image1']['tmp_name'], "../images/".$image1);
    move_uploaded_file($_FILES['image2']['tmp_name'], "../images/".$image2);
    move_uploaded_file($_FILES['image3']['tmp_name'], "../images/".$image3);
    move_uploaded_file($_FILES['image4']['tmp_name'], "../images/".$image4);

    mysqli_query($conn,"INSERT INTO products
    (product_name, description, price, discount, stock, color, size, shoe_type, image1, image2, image3, image4, category_id)
    VALUES
    ('$name','$description','$price','$discount','$stock','$color','$size','$shoe_type','$image1','$image2','$image3','$image4','$category')
    ");

    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Product</title>
<link rel="stylesheet" href="admin.css">
<style>
/* ===== GENERAL ===== */
*{
    box-sizing:border-box;
}

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
    padding:40px;
}

/* ===== FORM DESIGN ===== */
.form-container{
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    max-width:100%;
}

.form-row{
    display:flex;
    gap:20px;
    margin-bottom:15px;
}

.form-group{
    flex:1;
    display:flex;
    flex-direction:column;
}

.form-group label{
    font-weight:600;
    margin-bottom:5px;
}

.form-group input,
.form-group textarea,
.form-group select{
    padding:10px;
    border:1px solid #ddd;
    border-radius:6px;
}

textarea{
    resize:none;
    height:90px;
}

button{
    background:#1e4d3d;
    color:#fff;
    padding:12px 25px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    margin-top:20px;
    width:fit-content;
}

button:hover{
    background:#2f7f63;
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
table{
    width:100%;
    background:white;
    border-collapse:collapse;
    border-radius:10px;
    overflow:hidden;
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

/* ===== RESPONSIVE DESIGN ===== */

/* Tablet */
@media(max-width:992px){

    .form-row{
        flex-direction:column;
    }

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
        display:block;
        overflow-x:auto;
        white-space:nowrap;
    }

    button{
        width:100%;
    }
}
</style>
</head>
<body>

<?php include("sidebar.php"); ?>

<div class="main">

<h2>Add New Product</h2>

<div class="form-container">

<form method="POST" enctype="multipart/form-data">

<!-- Basic Info -->
<div class="form-row">
    <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="product_name" required>
    </div>

    <div class="form-group">
        <label>Category</label>
        <select name="category" required>
            <option value="">Select Category</option>
            <?php
            $cat = mysqli_query($conn,"SELECT * FROM categories");
            while($c = mysqli_fetch_assoc($cat)){
                echo "<option value='{$c['category_id']}'>{$c['category_name']}</option>";
            }
            ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label>Description</label>
    <textarea name="description" required></textarea>
</div>

<!-- Pricing -->
<div class="form-row">
    <div class="form-group">
        <label>Price (₹)</label>
        <input type="number" name="price" required>
    </div>

    <div class="form-group">
        <label>Discount (%)</label>
        <input type="number" name="discount" value="0">
    </div>

    <div class="form-group">
        <label>Stock</label>
        <input type="number" name="stock" required>
    </div>
</div>

<!-- Product Details -->
<div class="form-row">
    <div class="form-group">
        <label>Colors</label>
        <input type="text" name="color" placeholder="Black, White, Red">
    </div>

    <div class="form-group">
        <label>Sizes</label>
        <input type="text" name="size" placeholder="6,7,8,9,10">
    </div>

    <div class="form-group">
        <label>Shoe Type</label>
        <select name="shoe_type" required>
            <option value="">Select Type</option>
            <option>Casual</option>
            <option>Sports</option>
            <option>Formal</option>
            <option>Partywear</option>
        </select>
    </div>
</div>

<!-- Images -->
<div class="form-row">
    <div class="form-group">
        <label>Main Image</label>
        <input type="file" name="image1" required>
    </div>

    <div class="form-group">
        <label>Image 2</label>
        <input type="file" name="image2">
    </div>

    <div class="form-group">
        <label>Image 3</label>
        <input type="file" name="image3">
    </div>

    <div class="form-group">
        <label>Image 4</label>
        <input type="file" name="image4">
    </div>
</div>

<button type="submit" name="add_product">Add Product</button>

</form>

</div>
</div>

</body>
</html>