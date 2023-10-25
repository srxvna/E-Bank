<?php
    session_start();
    if ($_SESSION['user']) {
        $user = $_SESSION['user'];
    } else {
        header("location:index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: "San Francisco", Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            width: 90%;
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
            color: #fff;
            text-decoration: none;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
            color: #000;
            border: 2px solid #000;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #000;
        }

        table th {
            background-color: #0053ba;
            color: #fff;
            font-weight: bold;
            text-align: left;
        }

        table td {
            background-color: #f2f2f2;
        }

        table tr {
            border: 2px solid #0053ba;
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
        <h1>Transaction History</h1>
        <h2>Welcome, <?php echo $user; ?></h2>
        <a href="home.php">Click Here to Go Back</a><br/><br/>

        <?php
            // Database connection
            $conn = mysqli_connect("localhost", "root", "", "ebank");
            if (!$conn) {
                die("Failed to connect to database: " . mysqli_connect_error());
            }

            // Fetch transactions of the user with the account number
            $query = "SELECT transactions.transaction_id, customers.account_number, transactions.transaction_type, transactions.amount, transactions.timestamp FROM transactions
                      INNER JOIN accounts ON transactions.account_id = accounts.account_id
                      INNER JOIN customers ON accounts.customer_id = customers.customer_id
                      WHERE customers.username = '$user'
                      ORDER BY transactions.timestamp DESC";

            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                echo '<table>';
                echo '<tr><th>Transaction ID</th><th>Account Number</th><th>Transaction Type</th><th>Amount</th><th>Timestamp</th></tr>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['transaction_id'] . '</td>';
                    echo '<td>' . $row['account_number'] . '</td>';
                    echo '<td>' . $row['transaction_type'] . '</td>';
                    echo '<td>' . $row['amount'] . '</td>';
                    echo '<td>' . $row['timestamp'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>No transactions found.</p>';
            }

            mysqli_close($conn);
        ?>
    </div>
</body>
</html>
