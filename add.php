<?php
session_start();
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    header("location:index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    date_default_timezone_set("Asia/Kolkata"); 
    $amount = $_POST['amount'];
    $details = $_POST['details'];
    $timestamp = date("Y-m-d H:i:s");

    $conn = new mysqli("localhost", "root", "", "ebank");
    if ($conn->connect_errno) {
        die("Failed to connect to MySQL: " . $conn->connect_error);
    }

   // Get the account ID based on the user's customer_id
$account_id = "";
$query = "SELECT account_id FROM accounts WHERE customer_id = (SELECT customer_id FROM customers WHERE username = ?)";
$stmt_account_id = $conn->prepare($query);
$stmt_account_id->bind_param("s", $user);
$stmt_account_id->execute();
$stmt_account_id->bind_result($account_id);
$stmt_account_id->fetch();
$stmt_account_id->close();

// Perform the deposit transaction
$transaction_type = "Deposit";
$stmt_deposit = $conn->prepare("INSERT INTO transactions (account_id, transaction_type, amount, timestamp, details) VALUES (?, ?, ?, ?, ?)");
$stmt_deposit->bind_param("sssss", $account_id, $transaction_type, $amount, $timestamp, $details);
$stmt_deposit->execute();
$stmt_deposit->close();


    $conn->close();

    echo '<script>alert("Successful Deposit Made.");window.location.assign("balance.php");</script>';
    exit();
} else {
    header("location:home.php");
    exit();
}
?>
