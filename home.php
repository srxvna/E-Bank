<?php
    session_start();
    if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else {
        header("location:index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>BCA E-Bank</title>
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
            margin-top: 0;
            font-weight: normal;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        button {
            width: 40%;
            margin: 15px 0;
            padding: 14px;
            font-weight: bold;
            background-color: #fff;
            border: none;
            border-radius: 4px;
            color: #0066cc;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        button:hover {
            background-color: #0066cc;
            color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }

        .copy-right {
            margin-top: 20px;
            font-size: 12px;
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
        <h2>Home Page</h2>
        <h3>Welcome to BCA E-Bank <?php echo $user; ?></h3>
        <a href="logout.php">Click Here to Logout</a><br/><br/>
        <button type="button" onclick="location.href='deposit.php'">Deposit</button>
        <button type="button" onclick="location.href='withdraw.php'">Withdraw</button>
        <button type="button" onclick="location.href='balance.php'">Check Balance</button>
        <button type="button" onclick="location.href='transaction_history.php'">Transaction History</button>
        <button type="button" onclick="location.href='money_transfer.php'">Money Transfer</button>
    </div>
</body>
</html>