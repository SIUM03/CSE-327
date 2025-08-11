<?php
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['userType'] !== 'Customer') {
    echo "<script>alert('Unauthorized access!'); window.location.href = 'Login_page.php';</script>";
    exit();
}

$customerId = $_SESSION['userId'];
$conn = new mysqli('localhost', 'root', '', 'banking_system');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get accountId
$accountSql = "SELECT accountId FROM Account WHERE customerId = $customerId";
$accountResult = $conn->query($accountSql);



if ($accountResult->num_rows === 0) {
    echo '<p>No account found for this customer.</p>';
    exit();
}

$accountId = $accountResult->fetch_assoc()['accountId'];


// Fetch transactions
$transactionSql = "
    SELECT * FROM Transactions 
    WHERE sender_accountId = $accountId OR receiver_accountId = $accountId
    ORDER BY TIMESTAMP DESC
";
$transactionResult = $conn->query($transactionSql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Transaction History</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(-45deg, #8bd1c9, #47a681, #a0d1b7, #c3f1e1);
            background-size: 400% 400%;
            animation: gradientFlow 15s ease infinite;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 10px;
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

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 1000px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .container__title {
            text-align: center;
            margin-bottom: 30px;
            color: #165c38;
            font-size: 28px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #165c38;
            color: #fff;
        }

        th,
        td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 14px;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #e2f5ec;
        }

        .no-records {
            text-align: center;
            color: #777;
            font-style: italic;
            padding: 20px;
        }

        .btn--back {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #165c38;
            color: #fff;
            border: none;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn--back:hover {
            background-color: #0f472b;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="container__title">📜 Transaction Report</h1>

        <?php if ($transactionResult->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Amount (৳)</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $transactionResult->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['transactionId']) ?></td>
                            <td><?= htmlspecialchars(ucfirst($row['type'])) ?></td>
                        <?php
                        $senderAccountId = $row['sender_accountId'];
                            
                                $senderNameSql = "SELECT name FROM Customer WHERE customerId = (SELECT customerId FROM Account WHERE accountId = $senderAccountId)";
                                $senderNameResult = $conn->query($senderNameSql);
                                $senderName = ($senderNameResult && $senderNameResult->num_rows > 0) ? $senderNameResult->fetch_assoc()['name'] : 'N/A';
                            
                        ?>
                        <td><?= htmlspecialchars($senderName) ?></td>
                             <?php
                        $receiverAccountId = $row['receiver_accountId'];
                            $receiverNameSql = "SELECT name FROM Customer WHERE customerId = (SELECT customerId FROM Account WHERE accountId = $receiverAccountId)";
                            $receiverNameResult = $conn->query($receiverNameSql);
                            $receiverName = ($receiverNameResult && $receiverNameResult->num_rows > 0) ? $receiverNameResult->fetch_assoc()['name'] : 'N/A';
                        ?>
                        <td><?= htmlspecialchars($receiverName) ?></td>
                            <td><?= number_format($row['amount'], 2) ?></td>
                            <td><?= htmlspecialchars($row['timestamp']) ?></td>
                            <td><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-records">No transactions found for your account.</p>
        <?php endif; ?>

        <a href="Customer_dashboard.php" class="btn--back">🔙 Back to Dashboard</a>
    </div>
</body>

</html>

<?php $conn->close(); ?>