<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

$mysqli = new mysqli("localhost", "root", "", "ebank");
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

$query = "SELECT * FROM customers WHERE username = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    // Get the encryption key & iv from the database
    $storedPassword = $row['password'];
    $encryptionKey = $row['encryption_key'];
    $iv = $row['iv'];

    // Decrypt the encrypted password and iv
    $decryptedPassword = openssl_decrypt($storedPassword, 'aes-256-cbc', $encryptionKey, 0, $iv);

    // Compare the plain text password with decrypted password
    if ($password === $decryptedPassword) {
        $_SESSION['user'] = $username;
        header("location: home.php");
        exit();
    } else {
        echo '<script>alert("Incorrect Password!");</script>';
        echo '<script>window.location.assign("login.php");</script>';
        exit();
    }
} else {
    echo '<script>alert("Incorrect Username!");</script>';
    echo '<script>window.location.assign("login.php");</script>';
    exit();
}
?>