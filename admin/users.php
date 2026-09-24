<?php
session_start();
include("../db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin'){
    header("Location: ../index.php");
    exit();
}

/* =========================
   ADD USER
========================= */
if(isset($_POST['add_user'])){

    $name  = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $phone = $_POST['phone'];
    $role  = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn,"INSERT INTO users (name,email,password,phone,role)
                        VALUES ('$name','$email','$password','$phone','$role')");

    header("Location: users.php");
    exit();
}

/* =========================
   UPDATE ROLE
========================= */
if(isset($_POST['update_role'])){
    $user_id = $_POST['user_id'];
    $role    = $_POST['role'];

    mysqli_query($conn,"UPDATE users SET role='$role' WHERE user_id='$user_id'");
    header("Location: users.php");
    exit();
}

/* =========================
   DELETE USER
========================= */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    if($id != $_SESSION['user_id']){
        mysqli_query($conn,"DELETE FROM users WHERE user_id='$id'");
    }

    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Users</title>
<link rel="stylesheet" href="admin.css">
<style>

.section-card{
    background:#fff;
    padding:20px;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
    margin-bottom:30px;
}

.form-row{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.form-row input,
.form-row select{
    padding:8px;
    border:1px solid #ddd;
    border-radius:5px;
}

.form-row input{ flex:1; }

.add-btn{
    background:#1e4d3d;
    color:white;
    padding:8px 15px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.role-badge{
    padding:5px 12px;
    border-radius:20px;
    color:white;
    font-size:12px;
}

.admin{ background:green; }
.customer{ background:gray; }

.delete-btn{
    color:red;
    text-decoration:none;
    font-weight:600;
}

@media(max-width:768px){
    .form-row{
        flex-direction:column;
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

<h2>Manage Users</h2>

<!-- ADD USER SECTION -->
<div class="section-card">
<h3>Add New User</h3>

<form method="POST">
<div class="form-row">
<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="text" name="phone" placeholder="Phone">
<input type="password" name="password" placeholder="Password" required>

<select name="role">
<option value="Customer">Customer</option>
<option value="Admin">Admin</option>
</select>

<button type="submit" name="add_user" class="add-btn">Add User</button>
</div>
</form>
</div>

<!-- USERS TABLE -->
<div class="section-card">

<div class="table-wrapper">
<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Role</th>
<th>Change Role</th>
<th>Delete</th>
</tr>

<?php
$users = mysqli_query($conn,"SELECT * FROM users ORDER BY user_id DESC");

while($row = mysqli_fetch_assoc($users)){
    $role_class = strtolower($row['role']);
?>

<tr>
<td><?php echo $row['user_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['phone']; ?></td>

<td>
<span class="role-badge <?php echo $role_class; ?>">
<?php echo $row['role']; ?>
</span>
</td>

<td>
<form method="POST" style="display:flex; gap:5px;">
<input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">

<select name="role">
<option <?php if($row['role']=="Customer") echo "selected"; ?>>Customer</option>
<option <?php if($row['role']=="Admin") echo "selected"; ?>>Admin</option>
</select>

<button type="submit" name="update_role" class="add-btn">Save</button>
</form>
</td>

<td>
<?php if($row['user_id'] != $_SESSION['user_id']){ ?>
<a href="users.php?delete=<?php echo $row['user_id']; ?>"
   class="delete-btn"
   onclick="return confirm('Are you sure?')">
Delete
</a>
<?php } else { ?>
—
<?php } ?>
</td>

</tr>

<?php } ?>

</table>
</div>

</div>

</div>
</body>
</html>