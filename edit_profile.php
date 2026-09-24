<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* UPDATE PROFILE */
if (isset($_POST['update'])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE users SET name=?, phone=?, address=? WHERE user_id=?"
    );
    mysqli_stmt_bind_param($stmt, "sssi", $name, $phone, $address, $user_id);
    mysqli_stmt_execute($stmt);

    header("Location: my_account.php");
    exit();
}

/* FETCH USER */
$stmt = mysqli_prepare($conn, "SELECT name, phone, address FROM users WHERE user_id=?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/edit_profile.css">
</head>
<body>

<?php include("header.php"); ?>

<div class="account-container">
    <div class="account-box">
        <h2>Edit Profile</h2>

        <form method="post">
            <label>Full Name</label>
            <input type="text" name="name"
                   value="<?= htmlspecialchars($user['name']); ?>" required>

            <label>Phone</label>
            <input type="text" name="phone"
                   value="<?= htmlspecialchars($user['phone']); ?>">

            <label>Address</label>
            <textarea name="address" required><?= htmlspecialchars($user['address']); ?></textarea>

            <button type="submit" name="update" class="btn">
                Update Profile
            </button>
        </form>
    </div>
</div>

<?php include("footer.php"); ?>

</body>
</html>
