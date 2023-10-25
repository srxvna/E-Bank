<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $accountType = $_POST["accountType"];
    $accountNumber = $_POST["accountNumber"];

    // Generate a random encryption key and IV
    $encryptionKey = openssl_random_pseudo_bytes(32); // 256-bit encryption key
    $iv = openssl_random_pseudo_bytes(16); // 128-bit IV

    // Encrypt the password
    $encryptedPassword = openssl_encrypt($password, 'aes-256-cbc', $encryptionKey, 0, $iv);

    // Check if the account number is an 8-digit number
    if (!preg_match("/^\d{8}$/", $accountNumber)) {
        echo '<script>alert("Please enter a valid 8-digit account number!");</script>';
        echo '<script>window.location.assign("register.html");</script>';
        exit;
    }

    $conn = new mysqli("localhost", "root", "", "ebank");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if username exists in the database
    $query = "SELECT * FROM customers WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<script>alert("Username has already been taken!");</script>';
        echo '<script>window.location.assign("register.html");</script>';
    } else {
        if ($password == $confirmPassword) {
            // Insert user data into the database with encrypted password
            $insertQuery = "INSERT INTO customers (first_name, last_name, username, email, password, account_number, encryption_key, iv) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssssssss", $firstName, $lastName, $username, $email, $encryptedPassword, $accountNumber, $encryptionKey, $iv);

            if ($stmt->execute()) {
                // Get the newly created customer_id
                $customer_id = $stmt->insert_id;

                // Insert account data into the database
                $insertAccountQuery = "INSERT INTO accounts (customer_id, account_type, balance) VALUES (?, ?, 0.00)";
                $stmt = $conn->prepare($insertAccountQuery);
                $stmt->bind_param("is", $customer_id, $accountType);
                $stmt->execute();

                echo '<script>alert("Successfully Registered!");</script>';
                echo '<script>window.location.assign("index.php");</script>';
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo '<script>alert("Passwords do not match!");</script>';
            echo '<script>window.location.assign("register.html");</script>';
        }
    }

    $conn->close();
}
?>