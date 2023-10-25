<!DOCTYPE html>
<html>
<head>
    <title>Check Balance</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: "San Francisco", Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
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
            color: #ffffff;
            text-decoration: none;
        }

        button {
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

        button:hover {
            background-color: #0066cc;
            color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }

        .receipt {
            margin-top: 30px;
            text-align: left;
            color: #000;
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
    <?php
        session_start();
        if ($_SESSION['user']) {
            $user = $_SESSION['user'];
        } else {
            header("location:index.php");
            exit();
        }
    ?>

    <div class="container">
        <h2>Check Balance</h2>
        <h3>Welcome, <?php echo $user; ?></h3>
        <a href="home.php">Click Here to Go Back</a><br/><br/>
        <?php
            // Simulated balance retrieval from database
            $conn = mysqli_connect("localhost", "root", "", "ebank");

            if (!$conn) {
                die("Failed to connect to database: " . mysqli_connect_error());
            }

            $balance = 0.00;
            $transactions = array();

            // Fetch balance and transactions from transactions table
            $query = mysqli_query($conn, "SELECT * FROM transactions WHERE account_id = (SELECT account_id FROM accounts WHERE customer_id = (SELECT customer_id FROM customers WHERE username = '$user'))");

            while ($row = mysqli_fetch_assoc($query)) {
                $balance += $row['amount'];
                $transactions[] = $row;
            }

            // Format balance with currency symbol
            $formatted_balance = "&#8377 " . number_format($balance, 2, ".", ",");
            echo "Your Balance is: " . $formatted_balance;

            mysqli_close($conn);
        ?>
    </div>
</body>
</html>
