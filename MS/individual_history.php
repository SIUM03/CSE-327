<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "banking_system";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$accountId = '';
$customerInfo = null;
$transactions = [];

if (isset($_GET['accountId'])) {
    $accountId = intval($_GET['accountId']);

    // Get customer info & balance
    $sqlCustomer = "
        SELECT a.accountId, a.Balance, c.name, c.customerId
        FROM Account a
        JOIN Customer c ON a.customerId = c.customerId
        WHERE a.accountId = $accountId
    ";
    $resultCustomer = $conn->query($sqlCustomer);
    if ($resultCustomer && $resultCustomer->num_rows > 0) {
        $customerInfo = $resultCustomer->fetch_assoc();

        // Get transactions involving this account
        $sqlTransactions = "
            SELECT t.transactionId, t.type, t.amount, t.timestamp, t.status,
                   sa.accountId AS sender_id, cs.name AS sender_name,
                   ra.accountId AS receiver_id, cr.name AS receiver_name
            FROM Transactions t
            LEFT JOIN Account sa ON t.sender_accountId = sa.accountId
            LEFT JOIN Customer cs ON sa.customerId = cs.customerId
            LEFT JOIN Account ra ON t.receiver_accountId = ra.accountId
            LEFT JOIN Customer cr ON ra.customerId = cr.customerId
            WHERE t.sender_accountId = $accountId OR t.receiver_accountId = $accountId
            ORDER BY t.timestamp DESC
        ";
        $transactions = $conn->query($sqlTransactions);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Transaction History</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        h2 { text-align: center; }
        form { text-align: center; margin-bottom: 20px; }
        input[type="number"] { padding: 5px; }
        button { padding: 6px 12px; cursor: pointer; }
        .info { background: #fff; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background: #007BFF; color: white; }
    </style>
</head>
<body>

<h2>Customer Transaction History</h2>

<form method="GET">
    <label>Enter Account ID:</label>
    <input type="number" name="accountId" value="<?php echo htmlspecialchars($accountId); ?>" required>
    <button type="submit">Search</button>
</form>

<?php if ($customerInfo): ?>
    <div class="info">
        <strong>Name:</strong> <?php echo $customerInfo['name']; ?><br>
        <strong>Account ID:</strong> <?php echo $customerInfo['accountId']; ?><br>
        <strong>Balance:</strong> <?php echo number_format($customerInfo['Balance'], 2); ?> BDT
    </div>

    <?php if ($transactions && $transactions->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Amount</th>
                <th>Date & Time</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $transactions->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['transactionId']; ?></td>
                    <td><?php echo ucfirst($row['type']); ?></td>
                    <td><?php echo $row['sender_name'] ?? 'N/A'; ?> (<?php echo $row['sender_id'] ?? '-'; ?>)</td>
                    <td><?php echo $row['receiver_name'] ?? 'N/A'; ?> (<?php echo $row['receiver_id'] ?? '-'; ?>)</td>
                    <td><?php echo number_format($row['amount'], 2); ?></td>
                    <td><?php echo $row['timestamp']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No transactions found for this account.</p>
    <?php endif; ?>

<?php elseif ($accountId !== ''): ?>
    <p style="color: red;">No account found with ID <?php echo htmlspecialchars($accountId); ?>.</p>
<?php endif; ?>

</body>
</html>
