<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "banking_system");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // === Admin or Employee Login ===
    if ($role === "Employee") {
        $sql = "SELECT * FROM Employee WHERE email = '$email' AND password = '$password' ";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $_SESSION["username"] = $row["username"];
            $_SESSION["email"] = $row["email"];
            echo "<script>alert('Login successful as $role!'); window.location.href = '../MS/index.php';</script>";
        } else {
            echo "<script>alert('Invalid $role credentials!');</script>";
        }
    }
    // === Customer Login ===
    elseif ($role === "Customer") {
        $sql = "SELECT * FROM Customer WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $_SESSION["userType"] = "Customer";
            $_SESSION["username"] = $row["name"];
            $_SESSION["userId"] = $row["customerId"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["phone"] = $row["phone"];
            $_SESSION["address"] = $row["address"];
            echo "<script>alert('Login successful as Customer!'); window.location.href = 'Customer_dashboard.php';</script>";
        } else {
            echo "<script>alert('Invalid Customer credentials!');</script>";
        }
    }

    $conn->close();
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>


    <!-- CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(-45deg, #a7cec8, #1daa5f, #88d9b3, #68b684);
            background-size: 400% 400%;
            animation: gradientFlow 10s ease infinite;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fadeIn 1s ease-in-out, gradientFlow 15s ease infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .welcome-text {
            position: absolute;
            top: 30px;
            left: 50px;
            text-align: left;
            color: #0f472b;
            font-size: 24px;
            animation: slideDown 1s ease-in-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        h1 {
            font-family: 'Raleway', sans-serif;
            font-weight: 400;
        }

        .admin {
            font-weight: 700;
        }

        .container {
            font-family: 'Raleway', sans-serif;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            backdrop-filter: blur(12px);
            background-color: rgba(255, 255, 255, 0.85);
            height: auto;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            animation: slideUp 1s ease-in-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-title {
            font-size: 32px;
            font-weight: bold;
            color: #165c38;
        }

        .subtitle {
            font-size: 16px;
            color: #555;
            margin-bottom: 25px;
        }

        .input-box {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
            transition: transform 0.3s ease-in-out;
        }

        .input-box:hover {
            transform: scale(1.03);
        }

        .input-box input,
        .input-box select {
            width: 100%;
            padding: 12px 45px 12px 45px;
            border-radius: 25px;
            border: 2px solid #516e5f;
            font-size: 15px;
            background: white;
            transition: box-shadow 0.3s ease;
        }

        .input-box input:focus,
        .input-box select:focus {
            outline: none;
            box-shadow: 0 0 8px rgba(22, 92, 56, 0.4);
            border-color: #165c38;
        }

        .input-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #165c38;
            font-size: 16px;
        }

        .input-box select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('https://cdn-icons-png.flaticon.com/512/60/60995.png');
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            margin-bottom: 20px;
            color: #333;
        }

        .options label {
            display: flex;
            align-items: center;
        }

        .options input {
            margin-right: 5px;
        }

        .forgot-password {
            color: #165c38;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: #165c38;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .login-btn:hover {
            background: #0f472b;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .signup-text {
            font-size: 14px;
            color: #333;
            margin-top: 15px;
        }

        .signup-link {
            color: #165c38;
            font-weight: bold;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .signup-link:hover {
            transform: scale(1.1);
            color: #0f472b;
        }

        @media (max-width: 500px) {
            .container {
                width: 90%;
                padding: 25px;
            }

            .login-title {
                font-size: 26px;
            }

            .subtitle {
                font-size: 14px;
            }

            .welcome-text {
                font-size: 18px;
                left: 20px;
                top: 20px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>

    <div class="welcome-text">
        <h1>Welcome Back to Bankii!</h1>
        <p>Please login to continue.</p>
    </div>

    <div class="container">
        <form method="POST" action="">
            <div class="login-title">Login</div>
            <div class="subtitle">Access your dashboard</div>

            <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="input-box">
                <i class="fas fa-user-tag"></i>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Employee">Employee</option>
                    <option value="Customer">Customer</option>
                </select>
            </div>

            <div class="options">
                <label><input type="checkbox"> Remember Me</label>
                <a href="forget_password.php" class="forgot-password">Forgot Password?</a>
            </div>

            <button type="submit" class="login-btn">Login</button>

            <div class="signup-text">
                Don't have an account? <a href="Sign_up.php" class="signup-link">Sign up</a>
            </div>
        </form>
    </div>

</body>

</html>