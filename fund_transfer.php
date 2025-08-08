<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amount = $_POST["amount"];
    $accountId = $_POST["accountNo"];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "banking_system");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if( $amount <= 0) {
         $transferQuery = "INSERT INTO Transactions (transactionID, type, sender_accountId, receiver_accountId, amount, timestamp, status) 
                      VALUES (NULL, 'transfer', (SELECT accountID FROM Account WHERE customerId = {$_SESSION['userId']}), $accountId, '$amount', NOW(), 'Failed')";
                      $conn->query($transferQuery);
        echo "<script>alert('Please enter a valid amount.');</script>";
        exit();
    }
    $balanceQuery = "SELECT Balance FROM Account WHERE accountID = (SELECT accountID FROM Account WHERE customerId = {$_SESSION['userId']})";
    $balanceResult = $conn->query($balanceQuery);
    $balance = $balanceResult->fetch_assoc()['Balance'];
       if( $amount > $balance) {
         $transferQuery = "INSERT INTO Transactions (transactionID, type, sender_accountId, receiver_accountId, amount, timestamp, status) 
                      VALUES (NULL, 'transfer', (SELECT accountID FROM Account WHERE customerId = {$_SESSION['userId']}), $accountId, '$amount', NOW(), 'Failed')";
                      $conn->query($transferQuery);
        echo "<script>alert('Insufficient balance.');</script>";
        exit();
    }


    $transferQuery = "INSERT INTO Transactions (transactionID, type, sender_accountId, receiver_accountId, amount, timestamp, status) 
                      VALUES (NULL, 'transfer', (SELECT accountID FROM Account WHERE customerId = {$_SESSION['userId']}), $accountId, '$amount', NOW(), 'completed')";
    $updateBalanceQuery = "UPDATE Account SET Balance = Balance - '$amount' WHERE accountID = (SELECT accountID FROM Account WHERE customerId = {$_SESSION['userId']})";
    $receiverBalanceQuery = "UPDATE Account SET Balance = Balance + '$amount' WHERE accountID = $accountId";
    if ($conn->query($transferQuery) === TRUE && $conn->query($updateBalanceQuery) === TRUE && $conn->query($receiverBalanceQuery) === TRUE ) {

        echo "<script>alert('Transfer successful!'); window.location.href = 'check_balance.php';</script>";
    } else {
       
        echo "<script>alert('Error during transfer: " . $conn->error . "');</script>";
    }
}

$name = $_SESSION['username'];
$email = $_SESSION['email'];
$phone = $_SESSION['phone'];
$address = $_SESSION['address'];
$customerId = $_SESSION['userId'];
$conn = new mysqli('localhost', 'root', '', 'banking_system');

$balanceQuery = "SELECT Balance FROM Account WHERE accountID = (SELECT accountId FROM Account WHERE customerId = $customerId)";
$balanceResult = $conn->query($balanceQuery);
$balance = $balanceResult->fetch_assoc()['Balance'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Customer Dashboard</title>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        crossorigin="anonymous" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Leckerli+One&family=Poppins:wght@100;400;600&display=swap"
        rel="stylesheet" />

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
            animation: gradientFlow 15s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

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

        .dashboard-container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            background: #ffffffd9;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .sidebar {
            width: 260px;
            background-color: #165c38;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            color: #fff;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            font-family: 'Leckerli One', cursive;
            text-align: center;
        }

        .nav-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .nav-links li button {
            background: none;
            border: none;
            color: #ffffffcc;
            font-size: 16px;
            text-align: left;
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            transition: 0.3s ease;
            cursor: pointer;
        }

        .nav-links li button i {
            margin-right: 10px;
        }

        .nav-links li button:hover {
            background: #117a4f;
            color: #fff;
        }

        .main-content {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .overview h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #117a4f;
        }

        .info p {
            font-size: 16px;
            margin: 8px 0;
            color: #333;
        }
            .down_subtitle a {
            color: #1daa5f;
            font-weight: bold;
            text-decoration: none;
        }

        .down_subtitle a:hover {
            text-decoration: underline;
        }
            .signup_submit {
            background-color: #1daa5f;
            color: white;
            padding: 7px;
            margin: 5px 0;
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

        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-around;
            }

            .nav-links {
                flex-direction: row;
                flex-wrap: wrap;
                gap: 10px;
            }

            .main-content {
                padding: 20px;
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

        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
           <aside class="sidebar">
            <div class="logo" onclick="window.location.href='Customer_dashboard.php'"> 💼 Dashboard</div>
            <ul class="nav-links">
                <li><button><i class="fa-regular fa-user"></i> Edit Profile</button></li>
                <li><button onclick="window.location.href='check_balance.php'"><i class="fa-solid fa-ticket"></i> Balance Check</button></li>
                <li><button onclick="window.location.href='fund_transfer.php'"><i class="fa-solid fa-money-bill-transfer"></i> Fund Transfer</button></li>
                <li><button onclick="window.location.href='Customer_Transaction_History.php'"><i
                            class="fa-solid fa-clock-rotate-left"></i> Transaction Report</button></li>
                <li><button onclick="window.location.href='index.php'"><i class="fa-solid fa-right-from-bracket"></i>
                        Sign Out</button></li>
                <li><button><i class="fa-solid fa-circle-info"></i> Help</button></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <section class="overview">
                <h2>Hello, <span><?= htmlspecialchars($name) ?></span> </h2>
                <div class="info">
                    <p>You have <strong><?= htmlspecialchars($balance) ?>  BDT</strong> on your Account</p>
                </div>
            </section>
            <div class="form-container">
        <form id="signup_form" method="POST" action="">
            <div class="form_header">Fund Transfer</div>


            <div class="form-group"><input type="positive-number" name="amount" placeholder="Amount" required></div> 
            <div class="form-group"><input type="positive-number" name="accountNo" placeholder="Receiver ACC No" required></div>

            <button type="submit" class="signup_submit">Transfer</button>

        </form>
        </main>
    </div>
</body>

</h