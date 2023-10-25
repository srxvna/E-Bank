<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
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
            font-family: 'San Francisco', Arial, sans-serif;
            border-radius: 10px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        a {
            color: #ffffff;
            text-decoration: none;
        }
        
        form {
            margin-top: 15px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            color: #fff;
        }

        input {
            margin: 5px;
            padding: 8px 12px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            color: #333;
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
    </style>
</head>

<body>
    <div class="container">
        <h2>The Login Page</h2>
        <a href="index.php">Click Here to Go Back</a><br/>
        <form action="checklogin.php" method="POST">
            <input type="text" id="username" name="username" required="required" placeholder="username" /><br/>

            <input type="password" id="password" name="password" required="required" placeholder="password" /><br/>

            <div class="checkbox-container">
                <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility()">
                <label class="show-password-label" for="showPassword">Show Password</label>
            </div>

            <input type="submit" value="Login" class="button"/>
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