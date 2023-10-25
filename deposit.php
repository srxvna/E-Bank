<!DOCTYPE html>
<html>
<head>
    <title>Deposit Page</title>
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
            color: #fff;
            text-decoration: none;
        }

        form {
            margin-top: 15px;
        }
        
        input {
            margin: 5px;
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
        <h2>Deposit Page</h2>
        <h3>Welcome to E-Banking, <?php echo $user; ?></h3>
        <a href="home.php">Click Here to Go Back</a><br/><br/>
        <form action="add.php" method="POST">
            <input type="number" id="amount" name="amount" required="required" placeholder="Deposit Amount" /><br/>
            <input type="text" id="details" name="details" placeholder="Add Details" /><br/>

            <input type="submit" class="button" value="Deposit Money"/>
        </form>

        <?php
        if (isset($_SESSION['message'])) {
            echo '<p>' . $_SESSION['message'] . '</p>';
            unset($_SESSION['message']);
        }
        ?>
    </div>
</body>
</html>
