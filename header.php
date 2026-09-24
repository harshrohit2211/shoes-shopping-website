<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>/* ===== TOP BAR ===== */
.top-bar {
    background: #f2f2f2;
    text-align: center;
    padding: 8px;
    font-size: 13px;
}

.top-bar span {
    font-weight: bold;
}

/* ===== HEADER ===== */
.header {
    background: #111;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 5%;
}

/* LOGO */
.logo a {
    color: #fff;
    font-size: 22px;
    font-weight: bold;
    text-decoration: none;
}

/* NAV */
.nav {
    display: flex;
    gap: 25px;
}

.nav a {
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    transition: 0.3s;
}

.nav a:hover {
    color: red;
}

/* RIGHT SECTION */
.header-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

/* SEARCH */
.search-box {
    display: flex;
    background: #222;
    border-radius: 5px;
    overflow: hidden;
}

.search-box input {
    border: none;
    padding: 6px 10px;
    background: transparent;
    color: #fff;
    outline: none;
}

.search-box button {
    border: none;
    background: transparent;
    color: #fff;
    padding: 6px 10px;
    cursor: pointer;
}

/* ICONS */
.header-icons {
    display: flex;
    align-items: center;
    gap: 18px;
}

.header-icons a {
    color: #fff;
    font-size: 18px;
    position: relative;
    transition: 0.3s;
}

.header-icons a:hover {
    color: red;
}

/* CART COUNT */
.cart-count {
    position: absolute;
    top: -6px;
    right: -8px;
    background: red;
    color: #fff;
    font-size: 11px;
    padding: 2px 6px;
    border-radius: 50%;
}</style>
<!-- ===== TOP BAR ===== -->
<div class="top-bar">
    SOLVE YOUR QUERIES FASTER THAN EVER! SEND US A "HI" ON 
    <span>WHATSAPP</span>
</div>

<header class="header">
  <div class="header-container">

    <!-- Logo -->
    <div class="logo">
        <a href="index.php">ShoeStore</a>
    </div>

    <!-- Navigation -->
    <nav class="nav">
      <a href="index.php">HOME</a>
      <a href="men.php">MEN</a>
      <a href="women.php">WOMEN</a>
      <a href="kids.php">KIDS</a>
    </nav>

    <!-- Right Section -->
    <div class="header-right">

        <!-- Search -->
        <form action="search.php" method="GET" class="search-box">
            <input type="text" name="query" placeholder="Search..." required>
            <button type="submit">
                <i class="fa fa-search"></i>
            </button>
        </form>

        <!-- Icons -->
        <div class="header-icons">

            <?php if(isset($_SESSION['user_id'])){ ?>
                <a href="my_account.php" class="account-link">
                    <i class="fa fa-user"></i>
                </a>
            <?php } else { ?>
                <a href="login.php" class="account-link">
                    <i class="fa fa-user"></i>
                </a>
            <?php } ?>

            <a href="wishlist.php" class="wishlist-link">
                <i class="fa fa-heart"></i>
            </a>

            <a href="cart.php" class="cart-link">
                <i class="fa fa-shopping-cart"></i>
                <span class="cart-count">1</span>
            </a>

        </div>

    </div>

  </div>
</header>