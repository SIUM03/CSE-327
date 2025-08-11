<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];
    $role = $_POST["role"];

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!');</script>";
        return;
    }

    $conn = new mysqli("localhost", "root", "", "banking_system");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($role === "Customer") {
        $sql = "SELECT * FROM Customer WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $update = "UPDATE Customer SET password = '$newPassword' WHERE email = '$email'";
            if ($conn->query($update) === TRUE) {
                echo "<script>alert('Customer password reset successfully!'); window.location.href='Login_page.php';</script>";
            } else {
                echo "<script>alert('Failed to update password for customer.');</script>";
            }
        } else {
            echo "<script>alert('Customer email not found!');</script>";
        }
    } elseif ($role === "Admin" || $role === "Employee") {
        $sql = "SELECT * FROM Employee WHERE email = '$email' AND role = '$role'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $update = "UPDATE Employee SET password = '$newPassword' WHERE email = '$email'";
            if ($conn->query($update) === TRUE) {
                echo "<script>alert('$role password reset successfully!'); window.location.href='Login_page.php';</script>";
            } else {
                echo "<script>alert('Failed to update password for $role.');</script>";
            }
        } else {
            echo "<script>alert('$role email not found!');</script>";
        }
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forget Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(-45deg, #a7cec8, #1daa5f, #88d9b3, #68b684);
            background-size: 400% 400%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Style for the role select dropdown */
        .input-box select {
            width: 100%;
            padding: 12px 45px 12px 45px;
            border-radius: 25px;
            border: 2px solid #516e5f;
            font-size: 15px;
            background-color: white;
            color: #333;
            background-image: url('https://cdn-icons-png.flaticon.com/512/60/60995.png');
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            transition: box-shadow 0.3s ease;
        }

        .input-box select:focus {
            outline: none;
            box-shadow: 0 0 8px rgba(22, 92, 56, 0.4);
            border-color: #165c38;
        }

        /* Optional: adjust icon alignment */
        .input-box i.fa-user-tag {
            left: 16px;
        }

        /* Gradient Keyframe */
        @keyframes gradientFlow {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Welcome Header */
        .welcome-text {
            position: absolute;
            top: 30px;
            left: 50px;
            color: #0f472b;
            font-size: 24px;
            animation: slideDown 1s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-text h1 {
            font-weight: 400;
        }

        .welcome-text .admin {
            font-weight: 700;
        }

        /* Form Container */
        .container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background-color: #ffffffcc;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: slideUp 1s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Title & Subtitle */
        .login-title {
            font-size: 30px;
            font-weight: bold;
            color: #165c38;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 16px;
            color: #555;
            margin-bottom: 25px;
        }

        /* Input Box */
        .input-box {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .input-box:hover {
            transform: scale(1.03);
        }

        .input-box input {
            width: 100%;
            padding: 12px 45px 12px 45px;
            border-radius: 25px;
            border: 2px solid #516e5f;
            font-size: 15px;
            background: white;
            transition: box-shadow 0.3s ease, border 0.3s ease;
        }

        .input-box input:focus {
            outline: none;
            border-color: #1daa5f;
            box-shadow: 0 0 8px rgba(29, 170, 95, 0.4);
        }

        .input-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #165c38;
            font-size: 16px;
        }

        /* Reset Button */
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

        /* Responsive */
        @media (max-width: 480px) {
            .welcome-text {
                font-size: 18px;
                left: 20px;
                top: 20px;
            }

            .container {
                padding: 25px;
            }

            .login-title {
                font-size: 24px;
            }

            .subtitle {
                font-size: 14px;
            }


        }
    </style>
</head>

<body>

    <div class="welcome-text">

        <h1>Reset Password<br><span class="admin">We've Got You</span></h1>
    </div>

    <div class="container">
        <h2 class="login-title">Forgot Password</h2>
        <p class="subtitle">Reset your account password</p>


        <form id="resetForm" method="POST" action="">
            <div class="input-box">
                <i class="fa-regular fa-envelope" id="main"></i>
                <input type="email" name="email" placeholder="Email" required />
            </div>

            <div class="input-box">
                <i class="fa-solid fa-lock" id="main"></i>
                <input type="password" name="new_password" placeholder="New Password" required />
            </div>

            <div class="input-box">
                <i class="fa-solid fa-lock" id="main"></i>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required />
            </div>

            <div class="input-box">
                <i class="fa-solid fa-user-tag" id="main"></i>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Employee">Employee</option>
                    <option value="Customer">Customer</option>
                </select>
            </div>

            <button type="submit" class="login-btn">Reset Password</button>
        </form>

    </div>


</body>

</html>