<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "banking system");

// Get the search input
$search = $_GET['search'] ?? '';

// Build SQL
$sql = "SELECT t.*, 
               sAcc.accountId AS sender_id, sCus.name AS sender_name,
               rAcc.accountId AS receiver_id, rCus.name AS receiver_name
        FROM Transactions t
        LEFT JOIN Account sAcc ON t.sender_accountId = sAcc.accountId
        LEFT JOIN Customer sCus ON sAcc.customerId = sCus.customerId
        LEFT JOIN Account rAcc ON t.receiver_accountId = rAcc.accountId
        LEFT JOIN Customer rCus ON rAcc.customerId = rCus.customerId
        WHERE 1";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " AND (
        sCus.name LIKE '%$search%' OR 
        rCus.name LIKE '%$search%' OR
        t.sender_accountId LIKE '%$search%' OR 
        t.receiver_accountId LIKE '%$search%'
    )";
}

$sql .= " ORDER BY t.timestamp DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Transaction History</title>
  <link rel="stylesheet" href="transaction-history.css" />
</head>
<body>
  <div class="container">
    <h2>Transaction History</h2>

    <!-- Search Form -->
    <form method="GET" class="filter-form">
      <input 
        type="text" 
        name="search" 
        placeholder="Search by name or account ID" 
        value="<?= htmlspecialchars($search) ?>"
      />
      <button type="submit">Search</button>
    </form>

    <!-- Transaction Table -->
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Sender</th>
          <th>Receiver</th>
          <th>Date &amp; Time</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['transactionId']) ?></td>
              <td><?= ucfirst(htmlspecialchars($row['type'])) ?></td>
              <td>৳<?= number_format((float) $row['amount'], 2) ?></td>
              <td>
                <?= htmlspecialchars($row['sender_name'] ?? 'N/A') ?> 
                (<?= htmlspecialchars($row['sender_accountId']) ?>)
              </td>
              <td>
                <?= htmlspecialchars($row['receiver_name'] ?? 'N/A') ?> 
                (<?= htmlspecialchars($row['receiver_accountId']) ?>)
              </td>
              <td><?= htmlspecialchars($row['timestamp']) ?></td>
              <td>
                <span class="status <?= htmlspecialchars($row['status']) ?>">
                  <?= ucfirst(htmlspecialchars($row['status'])) ?>
                </span>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="7">No transactions found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
