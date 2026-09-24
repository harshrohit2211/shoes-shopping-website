<?php
include("header.php");
include("db.php");

if(!isset($_GET['email'])){
    header("Location: forgot_password.php");
    exit();
}

$email = mysqli_real_escape_string($conn, $_GET['email']);
$message = "";

if(isset($_POST['reset'])){
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if($password !== $confirm){
        $message = "Passwords do not match!";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn, "UPDATE users SET password='$hashed' WHERE email='$email'");
        header("Location: login.php?reset=success");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<link rel="stylesheet" href="css/reset_password.css">
</head>

<body>

<div class="box">
  <h2>Reset Password</h2>

  <?php if($message) echo "<p class='error'>$message</p>"; ?>

  <form method="POST">
    <input type="password" name="password" placeholder="New Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    <button type="submit" name="reset">Reset Password</button>
  </form>
</div>
</body>
</html>
<?php
include("footer.php");
?>