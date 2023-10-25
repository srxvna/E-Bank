<?php
session_start();
if ($_SESSION['user']) {
    $user = $_SESSION['user'];
} else {
    header("location:index.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "ebank");
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

$stmt = mysqli_prepare($conn, "SELECT amount FROM transactions WHERE transaction_type='deposit' AND account_id IN (SELECT account_id FROM accounts WHERE customer_id IN (SELECT customer_id FROM customers WHERE username=?))");
mysqli_stmt_bind_param($stmt, "s", $user);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $amount);

while (mysqli_stmt_fetch($stmt)) {
    $balance += $amount;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    date_default_timezone_set("Asia/Kolkata");
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);

    if ($amount > $balance) {
        echo '<script>alert("You do not have sufficient amount. Please check your balance");</script>';
        echo '<script>window.location.assign("balance.php");</script>';
        exit("You have insufficient funds!");
    }

    $amount = (-$amount);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $timestamp = date("Y-m-d H:i:s");

    $stmt = mysqli_prepare($conn, "INSERT INTO transactions (account_id, transaction_type, amount, details, timestamp) VALUES ((SELECT account_id FROM accounts WHERE customer_id IN (SELECT customer_id FROM customers WHERE username=?)), 'withdrawal', ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sdss", $user, $amount, $details, $timestamp);
    mysqli_stmt_execute($stmt);

    echo '<script>alert("Successful withdrawal.");</script>';
    echo '<script>window.location.assign("balance.php");</script>';
    exit();
} else {
    header("location: home.php");
    exit();
}
?>
