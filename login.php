<?php
include("header.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
  /* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

/* Background */
.login_bg {
    width: 100%;
    height: 100vh;
    background: linear-gradient(135deg, #ffffff, #f8f5fb);
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Login Box */
.box {
    background: #ffffff;
    width: 380px;
    padding: 35px 30px;
    border-radius: 12px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
}

/* Heading */
.box h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
}

/* Form Labels */
.box form {
    display: flex;
    flex-direction: column;
    gap: 12px;
    color: #555;
    font-size: 14px;
}

/* Inputs */
.box input {
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    outline: none;
    transition: 0.3s;
}

.box input:focus {
    border-color: #667eea;
    box-shadow: 0 0 5px rgba(102, 126, 234, 0.4);
}

/* Button */
.box button {
    margin-top: 10px;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: #f0bd31;
    color: #fff;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.box button:hover {
    background: #f4b400;
}

/* Links */
.link {
    margin-top: 18px;
    text-align: center;
    font-size: 13px;
    color: #555;
}

.link a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}

.link a:hover {
    text-decoration: underline;
}

/* Success Message */
p {
    margin-top: 15px;
    font-size: 14px;
}

</style>
</head>
<body>
 <div class="login_bg">

<div class="box">
<h2>Log In to your account</h2>

<form action="login_process.php" method="POST">
Email:
<input type="email" name="email" placeholder="Email" required>
Password:
<input type="password" name="password" placeholder="Password" required>
<button type="submit">Login</button>
</form>

<div class="link">
New Member? <a href="register.php">create an account</a>
</br>
Forgot Password? <a href="reset_password.php">Reset Now</a>
</div>
</div>
</div>
<?php
if(isset($_GET['success'])){
  echo "<p style='color:green;text-align:center;'>Registration successful. Please login.</p>";
}
?>
</body>
</html>
<?php
include("footer.php");
?>