<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "banking_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get accountId from query string
$accountId = $_GET['accountid'] ?? '';

if (!$accountId) {
    echo "<p>No account number provided.</p>";
    exit;
}

// Prepare SQL to fetch transactions for this account
$sql = "
    SELECT 
        t.transactionId,
        t.type,
        t.sender_accountId,
        s_cust.name AS sender_name,
        t.receiver_accountId,
        r_cust.name AS receiver_name,
        t.amount,
        t.timestamp,
        t.status
    FROM Transactions t
    LEFT JOIN Account s_acc ON t.sender_accountId = s_acc.accountId
    LEFT JOIN Customer s_cust ON s_acc.customerId = s_cust.customerId
    LEFT JOIN Account r_acc ON t.receiver_accountId = r_acc.accountId
    LEFT JOIN Customer r_cust ON r_acc.customerId = r_cust.customerId
    WHERE t.sender_accountId = ? OR t.receiver_accountId = ?
    ORDER BY t.timestamp DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $accountId, $accountId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Transaction History for Account #<?= htmlspecialchars($accountId) ?></title>
<link rel="stylesheet" href="transaction_view.css"/>
</head>
<body>

<h2>Transaction History for Account No: <?= htmlspecialchars($accountId) ?></h2>

<?php if ($result->num_rows > 0): ?>
<table>
  <thead>
    <tr>
      <th>Transaction ID</th>
      <th>Type</th>
      <th>Sender Account</th>
      <th>Sender Name</th>
      <th>Receiver Account</th>
      <th>Receiver Name</th>
      <th>Amount</th>
      <th>Date & Time</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['transactionId']) ?></td>
        <td><?= htmlspecialchars(ucfirst($row['type'])) ?></td>
        <td><?= htmlspecialchars($row['sender_accountId']) ?></td>
        <td><?= htmlspecialchars($row['sender_name'] ?? 'N/A') ?></td>
        <td><?= htmlspecialchars($row['receiver_accountId']) ?></td>
        <td><?= htmlspecialchars($row['receiver_name'] ?? 'N/A') ?></td>
        <td><?= htmlspecialchars(number_format($row['amount'], 2)) ?></td>
        <td><?= htmlspecialchars($row['timestamp']) ?></td>
        <td class="status-<?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php else: ?>
<p>No transactions found for account number <?= htmlspecialchars($accountId) ?>.</p>
<?php endif; ?>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
