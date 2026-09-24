<?php
session_start();
include("../db.php");

/* =========================
   ADMIN SECURITY
========================= */
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin'){
    header("Location: ../index.php");
    exit();
}

/* =========================
   GET PRODUCT
========================= */
if(!isset($_GET['id'])){
    header("Location: products.php");
    exit();
}

$product_id = (int)$_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM products WHERE product_id='$product_id'");
$product = mysqli_fetch_assoc($result);

if(!$product){
    echo "Product not found";
    exit();
}

/* =========================
   UPDATE PRODUCT
========================= */
if(isset($_POST['update_product'])){

    $name  = mysqli_real_escape_string($conn,$_POST['product_name']);
    $desc  = mysqli_real_escape_string($conn,$_POST['description']);
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $stock = $_POST['stock'];
    $color = $_POST['color'];
    $size  = $_POST['size'];
    $shoe_type = $_POST['shoe_type'];
    $category = $_POST['category'];

    /* ===== IMAGE HANDLING ===== */
    $images = ['image1','image2','image3','image4'];
    $updated_images = [];

    foreach($images as $img){

        if(!empty($_FILES[$img]['name'])){
            $new_name = time() . "_" . $_FILES[$img]['name'];
            move_uploaded_file($_FILES[$img]['tmp_name'], "../images/".$new_name);
        } else {
            $new_name = $product[$img]; // keep old image
        }

        $updated_images[$img] = $new_name;
    }

    mysqli_query($conn,"UPDATE products SET
        product_name='$name',
        description='$desc',
        price='$price',
        discount='$discount',
        stock='$stock',
        color='$color',
        size='$size',
        shoe_type='$shoe_type',
        image1='{$updated_images['image1']}',
        image2='{$updated_images['image2']}',
        image3='{$updated_images['image3']}',
        image4='{$updated_images['image4']}',
        category_id='$category'
        WHERE product_id='$product_id'
    ");

    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Product</title>
<link rel="stylesheet" href="admin.css">
<style>

/* ===== FORM CONTAINER ===== */
.form-container{
    max-width:900px;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
}

.form-container label{
    display:block;
    font-weight:600;
    margin-top:15px;
    margin-bottom:6px;
}

.form-container input,
.form-container textarea,
.form-container select{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
    background:#fafafa;
}

.form-container textarea{
    min-height:100px;
    resize:none;
}

.form-container button{
    margin-top:25px;
    padding:14px;
    background:#1e4d3d;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:600;
}

.form-container button:hover{
    background:#2f7f63;
}

/* ===== IMAGE GRID ===== */
.image-edit-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
    margin-top:20px;
}

.img-box{
    background:#fafafa;
    padding:15px;
    border-radius:10px;
    border:1px solid #eee;
    text-align:center;
}

.img-box img{
    width:100%;
    height:180px;
    object-fit:cover;
    border-radius:8px;
    margin-bottom:10px;
}

@media(max-width:768px){
    .image-edit-grid{
        grid-template-columns:1fr;
    }
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
<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data" class="form-container">

<label>Product Name</label>
<input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required>

<label>Description</label>
<textarea name="description"><?php echo $product['description']; ?></textarea>

<label>Price</label>
<input type="number" name="price" value="<?php echo $product['price']; ?>" required>

<label>Discount (%)</label>
<input type="number" name="discount" value="<?php echo $product['discount']; ?>">

<label>Stock</label>
<input type="number" name="stock" value="<?php echo $product['stock']; ?>">

<label>Color</label>
<input type="text" name="color" value="<?php echo $product['color']; ?>">

<label>Size</label>
<input type="text" name="size" value="<?php echo $product['size']; ?>">

<label>Shoe Type</label>
<input type="text" name="shoe_type" value="<?php echo $product['shoe_type']; ?>">

<label>Category</label>
<select name="category">
<?php
$cat = mysqli_query($conn,"SELECT * FROM categories");
while($c = mysqli_fetch_assoc($cat)){
    $selected = ($c['category_id'] == $product['category_id']) ? "selected" : "";
    echo "<option value='{$c['category_id']}' $selected>{$c['category_name']}</option>";
}
?>
</select>

<h3 style="margin-top:30px;">Product Images</h3>

<div class="image-edit-grid">

    <div class="img-box">
        <p>Main Image</p>
        <img src="../images/<?php echo $product['image1']; ?>">
        <input type="file" name="image1">
    </div>

    <div class="img-box">
        <p>Image 2</p>
        <img src="../images/<?php echo $product['image2']; ?>">
        <input type="file" name="image2">
    </div>

    <div class="img-box">
        <p>Image 3</p>
        <img src="../images/<?php echo $product['image3']; ?>">
        <input type="file" name="image3">
    </div>

    <div class="img-box">
        <p>Image 4</p>
        <img src="../images/<?php echo $product['image4']; ?>">
        <input type="file" name="image4">
    </div>

</div>

<button type="submit" name="update_product">Update Product</button>

</form>

</div>
</body>
</html>