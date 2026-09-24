<?php include("header.php"); ?>
<link rel="stylesheet" href="css/simple-pages.css">
<style>
body{
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
}
</style>
<div class="page-container">

    <h1 class="page-title">Returns & Exchanges</h1>

    <div class="page-card">
        <h3>Easy 7-Day Return</h3>
        <p>
            You can return any unused product within 7 days of delivery.
            The product must be in original condition with packaging.
        </p>
    </div>

    <div class="page-card">
        <h3>Refund Process</h3>
        <p>
            Once your return is approved, refund will be processed within
            5–7 business days to your original payment method.
        </p>
    </div>

    <div class="page-card">
        <h3>Need Help?</h3>
        <p>
            For return assistance, contact our support team anytime.
        </p>
    </div>

</div>

<?php include("footer.php"); ?>