<?php
if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    $conn = new mysqli("localhost", "root", "", "ebank");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("DELETE FROM transactions WHERE account_id IN (SELECT account_id FROM accounts WHERE customer_id = ?)");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM accounts WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM customers WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $stmt->close();

        $conn->commit();

        header("Location:admin_panel.php");
        exit();
    } catch (mysqli_sql_exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $conn->close();
} else {
    header("Location:admin_panel.php");
    exit();
}
?>