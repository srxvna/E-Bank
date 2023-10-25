<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body {
            font-family: "San Francisco", Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        h2 {
            color: #0066cc;
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #0066cc;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 102, 204, 0.2);
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
            border-right: 1px solid #ccc;
        }
        
        th {
            background-color: #0066cc;
            color: #fff;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #0066cc;
        }

        a:hover {
            color: #0053ba;
        }

        p {
            text-align: center;
        }

        div {
            color: #f00f53;
            text-align: center;
            margin-top: 20px;
        }

        @media screen and (min-width: 768px) {
            table {
                font-size: 14px;
            }
        }

    </style>
</head>
<body>
    <h2>Admin Panel</h2>
    <div>
        <a href="index.php">Click Here to Go Back.</a>
    </div>

    <?php
    $conn = new mysqli("localhost", "root", "", "ebank");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function calculateBalance($conn, $account_id) {
        $sql = "SELECT SUM(amount) AS total_balance FROM transactions WHERE account_id = '$account_id'";
        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        $row = $result->fetch_assoc();
        return $row["total_balance"];
    }

    function displayCustomers($conn) {
        $sql = "SELECT customers.customer_id, account_number, first_name, last_name, username, email, password, account_type, accounts.balance FROM customers
                INNER JOIN accounts ON customers.customer_id = accounts.customer_id";
        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Account Number</th><th>First Name</th><th>Last Name</th><th>Username</th><th>Email</th><th>Password</th><th>Account Type</th><th>Balance</th><th>Action</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["account_number"] . '</td>';
                echo '<td>' . $row["first_name"] . '</td>';
                echo '<td>' . $row["last_name"] . '</td>';
                echo '<td>' . $row["username"] . '</td>';
                echo '<td>' . $row["email"] . '</td>';
                echo '<td>' . $row["password"] . '</td>';
                echo '<td>' . $row["account_type"] . '</td>';
                echo '<td>' . calculateBalance($conn, $row["customer_id"]) . '</td>';
                echo '<td><a href="edit_customer.php?id=' . $row["customer_id"] . '">Edit</a> | <a href="delete_customer.php?id=' . $row["customer_id"] . '">Delete</a></td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo '<p>No customers found.</p>';
        }
    }

    displayCustomers($conn);

    $conn->close();
    ?>
</body>
</html>
