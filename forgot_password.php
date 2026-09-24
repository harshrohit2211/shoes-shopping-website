
<?php
include("db.php");

$message = "";

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check email exists
    $check = mysqli_query($conn, "SELECT user_id FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) == 1){
        // Redirect to reset password page
        header("Location: reset_password.php?email=$email");
        exit();
    } else {
        $message = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>

<link rel="stylesheet" href="css/forgot_password.css">
</head>

<body>



<div class="box">
  <h2>Forgot Password</h2>
  <?php if($message) echo "<p class='error'>$message</p>"; ?>
  <form method="POST">
    <input type="email" name="email" placeholder="Enter your registered email" required>
    <button type="submit" name="submit">Continue</button>
    <div>
    Not Forgot Password ?  <a href="login.php">login Now</a>
    </div>
  </form>
</div>

</body>
</html>
