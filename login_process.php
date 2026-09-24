<?php
session_start();
include("db.php");

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 1){

    $row = mysqli_fetch_assoc($result);

    if(password_verify($password, $row['password'])){

        // Correct session variables
        $_SESSION['user_id']   = $row['user_id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['role']      = $row['role'];

        // Role-based redirect
    if($row['role'] === 'Admin'){
        header("Location: admin/dashboard.php");
        } else {
             header("Location: index.php");
        }
        exit();

    } else {
        echo "<script>alert('Wrong password'); window.location='login.php';</script>";
    }

} else {
    echo "<script>alert('Email not registered'); window.location='login.php';</script>";
}
?>
<?php
if(isset($_GET['success'])){
  echo "<p style='color:green;text-align:center;'>Registration successful. Please login.</p>";
}
?>