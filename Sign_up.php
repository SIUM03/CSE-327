<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $nid = $_POST['nid'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $type = strtolower($_POST['type']);
    $amount = $_POST['amount'];

    $conn = new mysqli("localhost", "root", "", "banking_system");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $customerId = $conn->query("Select MAX(customerId) as maxId FROM Customer")->fetch_assoc()['maxId'] + 1;
    $accountId= $conn->query("Select MAX(accountID) as maxId FROM Account")->fetch_assoc()['maxId'] + 1;


    $customer_sql = "INSERT INTO Customer (customerId, name, nid, phone, email, address, kycstatus, password) 
         VALUES ($customerId, '$name', '$nid', '$phone', '$email', '$address', 1, '$password')";

    if ($conn->query($customer_sql) === TRUE) {
        echo "Successfully created customer record.";
        
        
        $account_sql = "INSERT INTO Account (accountID,type, status, Balance, customerId) 
                    VALUES ($accountId, '$type', 'active', '$amount', $customerId)";
        $transactionSql="INSERT INTO Transactions (transactionID,type, sender_accountId, receiver_accountId, amount, timestamp, status) 
        VALUES (null,'deposit', 100, $accountId, '$amount', NOW(), 'completed')";
        if ($conn->query($account_sql) === TRUE && $conn->query($transactionSql) === TRUE) {
            echo "<script>
              alert('Account created successfully!');
              window.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>alert('Error creating account: " . $conn->error . "');</script>";
        }
    } else {
        echo "Error creating customer record: " . $conn->error;
    }

    $conn->close();
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create New Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <!-- CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(to right, #a7cec8, #1daa5f);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeInBody 1s ease-in;
        }

        @keyframes fadeInBody {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .form-container {
            width: 100%;
            max-width: 450px;
            background: #ffffffee;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            animation: slideInForm 0.8s ease-out;
        }

        @keyframes slideInForm {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #signup_form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form_header {
            font-size: 28px;
            font-weight: 700;
            color: #117a4f;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            width: 100%;
        }

        input,
        select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: 0.3s ease, box-shadow 0.3s ease;
            background-color: #f9f9f9;
            color: #1b1b1b;
        }

        input:focus,
        select:focus {
            border-color: #1daa5f;
            background-color: #fff;
            outline: none;
            box-shadow: 0 0 8px rgba(29, 170, 95, 0.6);
        }

        input::placeholder {
            color: #aaa;
        }

        .signup_submit {
            background-color: #1daa5f;
            color: white;
            padding: 14px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .signup_submit:hover {
            background-color: #158a4a;
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        }

        .down_subtitle {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: #333;
            opacity: 0;
            animation: fadeInText 1.5s ease forwards;
            animation-delay: 1s;
        }

        @keyframes fadeInText {
            to {
                opacity: 1;
            }
        }

        .down_subtitle a {
            color: #1daa5f;
            font-weight: bold;
            text-decoration: none;
        }

        .down_subtitle a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 20px;
            }

            .form_header {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <form id="signup_form" method="POST" action="">
            <div class="form_header">Create New Account</div>

            <div class="form-group"><input type="text" name="name" placeholder="Full Name" required></div>
            <div class="form-group"><input type="number" name="nid" placeholder="NID" required></div>
            <div class="form-group"><input type="email" name="email" placeholder="Email Address" required></div>
            <div class="form-group"><input type="tel" name="phone" placeholder="Phone Number" required></div>
            <div class="form-group"><input type="text" name="address" placeholder="Current Address" required></div>
            <div class="form-group"><input type="password" name="password" placeholder="Password" required></div>
            <div class="form-group"><input type="password" name="confirm_password" placeholder="Confirm Password" required></div>

            <div class="form-group">
                <select name="type" required>
                    <option value="">Select Type</option>
                    <option value="savings">Savings</option>
                    <option value="current">Current</option>
                </select>
            </div>

            <div class="form-group"><input type="number" name="amount" placeholder="Amount" required></div>

            <button type="submit" class="signup_submit">Sign Up</button>

            <div class="down_subtitle">Already have an account? <a href="/html/Login_page.html">Log In</a></div>
        </form>
    </div>
</body>

</html>