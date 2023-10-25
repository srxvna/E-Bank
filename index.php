<!DOCTYPE html>
<html>
<head>
    <title>BCA E-Bank</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 450px;
            padding: 4% 4% 4%;
            margin: 50px auto;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
            background: linear-gradient(to right, #0053ba, #00addb);
            color: #fff;
            text-align: center;
            font-family: Arial, sans-serif;
            border-radius: 10px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            margin-top: 0;
            font-size: 16px;
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

        button:focus {
            outline: none;
            background-color: #0066cc;
            color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }

        .reg {
            margin-top: 20px;
            font-size: 12px;
        }

        @media screen and (max-width: 500px) {
            .container {
                width: 90%;
                padding: 6% 6% 6%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to BCA E-Bank</h2>
        <p>Experience secure and convenient banking services</p>
        <button type="button" onclick="location.href='login.php'">LOGIN</button>
        <button type="button" onclick="location.href='register.html'">REGISTER</button>
        <button type="button" onclick="location.href='admin_login.php'">ADMIN LOGIN</button>
        <p class="reg">&reg; BCA Bank <?php echo date("Y"); ?></p>
    </div>
</body>
</html>