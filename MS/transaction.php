<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $customerId = intval($_POST['customer_id']);
    $amount = floatval($_POST['amount']);
    $type = $_POST['transaction_type']; // 'deposit' or 'withdrawal'

    if ($amount <= 0) {
        $message = "Amount must be greater than zero.";
    } else {
        $conn = new mysqli("localhost", "root", "", "banking system");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get active account of the customer
        $sql = "SELECT accountId, Balance 
                FROM Account 
                WHERE customerId = ? AND status = 'active' 
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $message = "No active account found for Customer ID $customerId.";
        } else {
            $account         = $result->fetch_assoc();
            $accountId       = $account['accountId'];
            $currentBalance  = $account['Balance'];

            if ($type === "deposit") {
                $newBalance = $currentBalance + $amount;
            } elseif ($type === "withdrawal") {
                if ($amount > $currentBalance) {
                    $message = "Withdrawal amount exceeds current balance.";
                } else {
                    $newBalance = $currentBalance - $amount;
                }
            } else {
                $message = "Invalid transaction type.";
            }

            if (!$message) {
                // Begin transaction
                $conn->begin_transaction();

                try {
                    // Update Account balance
                    $updateSql = "UPDATE Account 
                                  SET Balance = ? 
                                  WHERE accountId = ?";
                    $stmt2 = $conn->prepare($updateSql);
                    $stmt2->bind_param("di", $newBalance, $accountId);
                    $stmt2->execute();

                    // Insert transaction
                    $insertSql = "INSERT INTO Transactions 
                                  (type, sender_accountId, receiver_accountId, amount, timestamp, status) 
                                  VALUES (?, ?, ?, ?, NOW(), 'completed')";
                    $stmt3 = $conn->prepare($insertSql);

                    if ($type === "deposit") {
                        // Bank account 100 used as sender for deposit
                        $sender_accountId   = 100;
                        $receiver_accountId = $accountId;
                    } else { 
                        // withdrawal
                        $sender_accountId   = $accountId;
                        $receiver_accountId = 100;
                    }

                    $stmt3->bind_param("siid", $type, $sender_accountId, $receiver_accountId, $amount);
                    $stmt3->execute();

                    // Commit transaction
                    $conn->commit();

                    $message = ucfirst($type) . " successful! New balance: " . number_format($newBalance, 2);
                } catch (Exception $e) {
                    $conn->rollback();
                    $message = "Transaction failed: " . $e->getMessage();
                }

                $stmt2->close();
                $stmt3->close();
            }
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Employee Transaction Page</title>
    <link rel="stylesheet" href="transaction.css" />
</head>
<body>
    <div class="container">
        <h2>Customer Deposit / Withdrawal</h2>

        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="customer_id">Customer ID:</label><br>
            <input type="number" name="customer_id" id="customer_id" required><br><br>

            <label for="transaction_type">Transaction Type:</label><br>
            <select name="transaction_type" id="transaction_type" required>
                <option value="">-- Select --</option>
                <option value="deposit">Deposit</option>
                <option value="withdrawal">Withdraw</option>
            </select><br><br>

            <label for="amount">Amount:</label><br>
            <input type="number" step="0.01" name="amount" id="amount" min="0.01" required><br><br>

            <button type="submit">Submit Transaction</button>
        </form>
    </div>
</body>
</html>
