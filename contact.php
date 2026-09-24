<?php
include("db.php");

if(isset($_POST['send_message'])){

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $message = mysqli_real_escape_string($conn,$_POST['message']);

    mysqli_query($conn,"
        INSERT INTO contact_messages (name,email,message)
        VALUES ('$name','$email','$message')
    ");

    $success = "Message sent successfully!";
}
?>

<?php include("header.php"); ?>
<link rel="stylesheet" href="css/simple-pages.css">
<style>body{
    background:#f4f6f9;
    font-family:'Segoe UI', sans-serif;
}

.page-container{
    max-width:900px;
    margin:80px auto;
    padding:0 20px;
}

.page-title{
    text-align:center;
    margin-bottom:50px;
    font-size:32px;
    letter-spacing:2px;
}

.page-card{
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    margin-bottom:25px;
    transition:0.3s;
}

.page-card:hover{
    transform:translateY(-5px);
}

/* CONTACT PAGE */
.contact-card{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:40px;
}

.contact-form{
    display:flex;
    flex-direction:column;
    gap:15px;
}

.contact-form input,
.contact-form textarea{
    padding:12px;
    border:1px solid #ccc;
    border-radius:8px;
}

.contact-form button{
    padding:12px;
    background:#000;
    color:#fff;
    border:none;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}

.contact-form button:hover{
    background:#333;
}

.contact-info{
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
}

/* Responsive */
@media(max-width:768px){
    .contact-card{
        grid-template-columns:1fr;
    }
}

.success-message{
    background:#e8f5e9;
    color:#2e7d32;
    padding:12px;
    border-radius:8px;
    margin-bottom:20px;
    text-align:center;
}</style>
<div class="page-container">

<h1 class="page-title">Contact Us</h1>

<?php if(isset($success)){ ?>
<div class="success-message"><?php echo $success; ?></div>
<?php } ?>

<div class="contact-card">

<form method="post" class="contact-form">

<input type="text" name="name" placeholder="Your Name" required>
<input type="email" name="email" placeholder="Your Email" required>
<textarea name="message" placeholder="Your Message" required></textarea>

<button type="submit" name="send_message">
Send Message
</button>

</form>

<div class="contact-info">
<h4>Store Information</h4>
<p>Email: support@shoestore.com</p>
<p>Phone: +91 9876543210</p>
<p>Vadodara, Gujarat</p>
</div>

</div>

</div>

<?php include("footer.php"); ?>