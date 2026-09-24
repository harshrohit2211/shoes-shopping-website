<?php
session_start();
include("../db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin'){
    header("Location: ../index.php");
    exit();
}

/* DELETE */
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    mysqli_query($conn,"DELETE FROM contact_messages WHERE contact_id='$id'");
    header("Location: contact_messages.php");
    exit();
}

$messages = mysqli_query($conn,"
    SELECT * FROM contact_messages
    ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Contact Messages</title>
<link rel="stylesheet" href="admin.css">

<style>

/* MAIN */
.main{
    margin-left:220px;
    padding:40px;
    background:#f4f6f9;
    min-height:100vh;
}

/* TITLE */
.page-title{
    margin-bottom:30px;
    font-size:26px;
    font-weight:600;
}

/* CARD */
.message-card{
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 8px 25px rgba(0,0,0,0.06);
    margin-bottom:20px;
    transition:0.3s;
}

.message-card:hover{
    transform:translateY(-4px);
}

/* TOP ROW */
.message-top{
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
    font-size:14px;
}

/* NAME */
.message-name{
    font-weight:600;
    font-size:16px;
}

/* EMAIL */
.message-email{
    color:#666;
    font-size:13px;
}

/* MESSAGE TEXT */
.message-text{
    margin:15px 0;
    line-height:1.6;
    font-size:14px;
    color:#333;
}

/* DATE */
.message-date{
    font-size:12px;
    color:#999;
}

/* DELETE BUTTON */
.delete-btn{
    display:inline-block;
    margin-top:10px;
    padding:6px 12px;
    background:#dc3545;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    font-size:12px;
    transition:0.3s;
}

.delete-btn:hover{
    background:#b52a37;
}

/* RESPONSIVE */
@media(max-width:768px){
    .main{
        margin-left:0;
        padding:20px;
    }

    .message-top{
        flex-direction:column;
        gap:5px;
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

<h2 class="page-title">Contact Messages</h2>

<?php while($row = mysqli_fetch_assoc($messages)){ ?>

<div class="message-card">

    <div class="message-top">
        <div>
            <div class="message-name"><?php echo $row['name']; ?></div>
            <div class="message-email"><?php echo $row['email']; ?></div>
        </div>

        <div class="message-date">
            <?php echo date("d M Y, h:i A", strtotime($row['created_at'])); ?>
        </div>
    </div>

    <div class="message-text">
        <?php echo nl2br($row['message']); ?>
    </div>

    <a href="contact_messages.php?delete=<?php echo $row['contact_id']; ?>"
       class="delete-btn"
       onclick="return confirm('Delete this message?');">
       Delete Message
    </a>

</div>

<?php } ?>

</div>

</body>
</html>