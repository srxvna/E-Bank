<!DOCTYPE html>
<html>
<head>
    <title>Money Transfer</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: "San Francisco", Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 500px;
            padding: 4% 4% 4%;
            margin: 50px auto;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
            background: linear-gradient(to right, #0053ba, #00addb);
            color: #fff;
            text-align: center;
            border-radius: 10px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        a {
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
        }

        form {
            margin-top: 15px;
        }

        input {
            padding: 8px 12px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
        }

        input:focus {
            background-color: #fff;
            outline: none;
        }

        .button {
            width: 150px;
            margin: 10px;
            padding: 10px;
            font-weight: bold;
            background-color: #fff;
            border: none;
            border-radius: 4px;
            color: #0066cc;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .button:hover {
            background-color: #0066cc;
            color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }

        a{
            font-size: 16px;
        }

        @media screen and (max-width: 600px) {
            .container {
                width: 90%;
                padding: 6% 6% 6%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Money Transfer</h2>
        <a href="home.php">Click Here to Go Back</a><br/>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" id="receiverAccountNumber" name="receiverAccountNumber" placeholder="Sender's Account Number" required><br><br>
            <input type="text" id="senderAccountNumber" name="senderAccountNumber" placeholder="Receiver's Account Number" required><br><br>
            <input type="text" id="transferAmount" name="transferAmount" placeholder="Transfer Amount" required><br><br>
            <input type="submit" class="button" value="Transfer Money">
        </form>

       <?php
        function performMoneyTransfer($senderAccountNumber, $receiverAccountNumber, $amount) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ebank";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $conn->begin_transaction();

            $senderCustomerId = getCustomerIdByAccountNumber($conn, $senderAccountNumber);
            $receiverCustomerId = getCustomerIdByAccountNumber($conn, $receiverAccountNumber);

            if ($senderCustomerId === false || $receiverCustomerId === false) {
                $conn->rollback();
                $conn->close();
                return false;
            }

            
            $updateSenderBalanceSQL = "UPDATE accounts SET balance = balance - ? WHERE customer_id = ?";
            $updateSenderBalanceStmt = $conn->prepare($updateSenderBalanceSQL);
            $updateSenderBalanceStmt->bind_param("di", $amount, $senderCustomerId);

            $updateReceiverBalanceSQL = "UPDATE accounts SET balance = balance + ? WHERE customer_id = ?";
            $updateReceiverBalanceStmt = $conn->prepare($updateReceiverBalanceSQL);
            $updateReceiverBalanceStmt->bind_param("di", $amount, $receiverCustomerId);

            $transactionType = "Money Transfer";
            $details = "Transfer from Account $senderAccountNumber to Account $receiverAccountNumber";
            $insertTransactionSQL = "INSERT INTO transactions (account_id, transaction_type, amount, details, timestamp) VALUES (?, ?, ?, ?, NOW())";
            $insertTransactionStmt = $conn->prepare($insertTransactionSQL);
            $insertTransactionStmt->bind_param("ssds", $senderCustomerId, $transactionType, $amount, $details);

            $updateSenderBalanceStmt->execute();
            $updateReceiverBalanceStmt->execute();
            $insertTransactionStmt->execute();

            if ($updateSenderBalanceStmt->affected_rows === 1 && $updateReceiverBalanceStmt->affected_rows === 1 && $insertTransactionStmt->affected_rows === 1) {
                $conn->commit();
                $conn->close();
                return true;
            } else {
                $conn->rollback();
                $conn->close();
                return false;
            }
        }

        function getCustomerIdByAccountNumber($conn, $accountNumber) {
            $getCustomerIdSQL = "SELECT customer_id FROM customers WHERE account_number = ?";
            $stmt = $conn->prepare($getCustomerIdSQL);
            $stmt->bind_param("s", $accountNumber);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                return $row["customer_id"];
            } else {
                return false;
            }
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $senderAccountNumber = $_POST["senderAccountNumber"];
            $receiverAccountNumber = $_POST["receiverAccountNumber"];
            $transferAmount = $_POST["transferAmount"];

            $transferResult = performMoneyTransfer($senderAccountNumber, $receiverAccountNumber, $transferAmount);
            
            echo '<script>';
            if ($transferResult) {
                echo 'alert("Money transfer successful!");';
            } else {
                echo 'alert("Money transfer failed. Please check the account numbers and balances.");';
            }
            echo '</script>';
        }
        ?>
    </div>
</body>
</html>