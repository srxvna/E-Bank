<?php
    session_start();
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else {
        header("location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Withdraw Page</title>
    <style>
         body {
            background-color: #f2f2f2;
            font-family: "San Francisco", Arial, sans-serif;
        }

        .container {
            width: 90%;
            max-width: 620px;
            margin: auto;
            padding: 4% 4% 4%;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
            background: linear-gradient(to right, #0053ba, #00addb);
            color: #fff;
            text-align: center;
            border-radius: 10px;
        }

        form {
            text-align: center;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        .form-group label {
            display: block;
            text-align: right;
            margin-right: 10px;
            color: #fff;
            font-weight: bold;
            font-size: 16px;
        }

        .form-group input {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 100%;
            font-size: 16px;
        }

        h2 {
            color: #fff;
            margin-bottom: 20px;
            font-size: 24px;
        }

        h3 {
            color: #fff;
            font-size: 18px;
            margin-top: 0;
        }

        a {
            color: #fff;
            text-decoration: none;
            text-align: right;
        }

        .button {
            margin-top: 20px;
            padding: 10px 20px;
            font-weight: bold;
            background-color: #fff;
            border: none;
            border-radius: 4px;
            color: #007bff;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            font-size: 16px;
        }

        .button:hover {
            background-color: #007bff;
            color: #fff;
        }

        p {
            margin: 20px 0;
            color: #fff;
            font-size: 16px;
        }

        @media screen and (max-width: 768px) {
            .container {
                padding: 6% 6% 6%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Withdraw Page</h2>
        <h3>Hello, <?php echo $user; ?></h3>
        <a href="home.php">Click Here to Go Back</a><br/>
        <form action="minus.php" method="POST">
            <div class="form-group">
                <input type="number" id="amount" name="amount" required="required" placeholder="Withdrawal Amount" />
            </div>
            <div class="form-group">
                <input type="text" id="details" name="details" placeholder="Add Details" />
            </div>
            <input type="submit" class="button" value="Withdraw Money" />
        </form>
        <p><b>Please don't withdraw more than you have.</b></p>
    </div>
</body>
</html>
