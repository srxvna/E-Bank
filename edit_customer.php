<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
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

        #showPasswordContainer {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $customer_id = $_GET["id"];

        // Database connection
        $conn = new mysqli("localhost", "root", "", "ebank");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $checkQuery = "SELECT * FROM customers WHERE customer_id = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $customerData = $result->fetch_assoc();
            $firstName = $customerData["first_name"];
            $lastName = $customerData["last_name"];
            $username = $customerData["username"];
            $email = $customerData["email"];
            $password = $customerData["password"];
        ?>
        
    <div class="container">
        <h2>Edit Customer</h2>
        <form action="update_customer.php" method="POST">
            <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
            <input type="text" name="firstName" placeholder="First Name" value="<?= $firstName ?>" required>
            <br>

            <input type="text" name="lastName" placeholder="Last Name" value="<?= $lastName ?>" required>
            <br>

            <input type="text" name="username" placeholder="Username" value="<?= $username ?>" required>
            <br>

            <input type="email" name="email" placeholder="Email" value="<?= $email ?>" required>
            <br>
                
            <input type="password" name="password" id="password" placeholder="Password" value="<?= $password ?>" required>

             <div id="showPasswordContainer">
                <label for="showPassword" id="showPasswordLabel">
                <input type="checkbox" id="showPassword"> Show Password
                </label>
            </div>

            <input type="submit" value="Save Changes" class="button">
        </form>
    </div>
    <?php
        } else {
            echo "Customer not found.";
        }

        $conn->close();
    } else {
        echo "Invalid request.";
    }
    ?>

    <script>
        const showPasswordCheckbox = document.getElementById("showPassword");
        const passwordInput = document.getElementById("password");

        showPasswordCheckbox.addEventListener("change", function() {
            if (showPasswordCheckbox.checked) {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        });
    </script>
</body>
</html>
