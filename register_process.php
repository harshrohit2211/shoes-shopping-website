<?php
include("db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name   = mysqli_real_escape_string($conn, $_POST['fname']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $phone  = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Password match check
    if($password !== $confirm_password){
        header("Location: register.php?error=password_mismatch");
        exit();
    }

    // Phone validation
    if(!preg_match("/^[0-9]{10}$/", $phone)){
        header("Location: register.php?error=invalid_phone");
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check email exists
    $check_email = mysqli_query($conn, "SELECT user_id FROM users WHERE email='$email'");
    if(mysqli_num_rows($check_email) > 0){
        header("Location: register.php?error=email_exists");
        exit();
    }

    // Check phone exists
    $check_phone = mysqli_query($conn, "SELECT user_id FROM users WHERE phone='$phone'");
    if(mysqli_num_rows($check_phone) > 0){
        header("Location: register.php?error=phone_exists");
        exit();
    }

    // Insert data
    $sql = "INSERT INTO users (name, email, password, phone) 
            VALUES ('$name', '$email', '$hashed_password', '$phone')";

    if(mysqli_query($conn, $sql)){
        header("Location: login.php?success=registered");
        exit();
    } else {
        die("Error: " . mysqli_error($conn));
    }
}
?>