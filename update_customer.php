<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $customer_id = $_POST["customer_id"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "ebank");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update customer data in the database
    $updateQuery = "UPDATE customers SET first_name = ?, last_name = ?, username = ?, email = ?, password = ? WHERE customer_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssssi", $firstName, $lastName, $username, $email, $password, $customer_id);

    if ($stmt->execute()) {
        echo '<script>alert("Customer information updated successfully!");</script>';
        echo '<script>window.location.assign("index.php");</script>';
    } else {
        echo "Error updating customer information: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
