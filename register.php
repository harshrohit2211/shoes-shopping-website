<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<style>
/* same CSS you already used */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

body {
    min-height: 100vh;
    background: linear-gradient(135deg, #ffffff, #f8f5fb);
    display: flex;
    justify-content: center;
    align-items: center;
}

.box {
    background: #ffffff;
    width: 400px;
    padding: 35px 30px;
    border-radius: 12px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
}

.box h2 {
    text-align: center;
    margin-bottom: 25px;
}

.box form {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.box input {
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.box button {
    margin-top: 12px;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: #f0bd31;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.link {
    text-align: center;
    margin-top: 15px;
}
</style>
</head>

<body>

<div class="box">
<h2>Create Your Account</h2>

<form action="register_process.php" method="POST">

Full Name:
<input type="text" name="fname" required>

Email:
<input type="email" name="email" required>

Mobile Number:
<input type="tel" name="phone" pattern="[0-9]{10}" required>

Password:
<input type="password" name="password" required>

Confirm Password:
<input type="password" name="confirm_password" required>

<button type="submit">Submit</button>

</form>

<div class="link">
Already have an account? <a href="login.php">Login</a>
</div>

</div>

</body>
</html>