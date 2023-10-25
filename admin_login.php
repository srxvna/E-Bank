<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'adminsk') {
        $_SESSION['admin'] = $username;

        header("Location: admin_panel.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            font-family: 'San Francisco', Arial, sans-serif;
        }

        .container {
            max-width: 450px;
            padding: 4%;
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

        a {
            color: #fff;
            text-decoration: none;
        }

        form {
            margin-top: 15px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
        }

        input {
            margin: 5px;
            padding: 8px 12px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
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

        .button:hover,
        .button:focus {
            background-color: #007bff;
            color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .show-password-label {
            font-size: 14px;
            margin-top: 5px;
            margin-left: 5px;
            margin-bottom: 5px;
        }

        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        <a href="index.php">Click Here to Go Back</a><br/>
        <form method="POST" action="admin_login.php">
            <?php if (isset($error)) { ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php } ?>
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" id="password" placeholder="Password" required><br>
        
            <div class="checkbox-container">
                <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility()">
                <label class="show-password-label" for="showPassword">Show Password</label>
            </div>
            
            <button type="submit" class="button">Login</button>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</body>
</html>
