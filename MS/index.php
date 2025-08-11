<?php
// DB connection info
$host = "localhost";
$user = "root";
$password = "";
$database = "banking_system";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get total customers
$totalCustomers = 0;
$kycVerified = 0;
$deactivated = 0;

$result = $conn->query("SELECT COUNT(*) AS total FROM Customer");
if ($result) {
    $row = $result->fetch_assoc();
    $totalCustomers = $row['total'];
}

$result = $conn->query("SELECT COUNT(*) AS total FROM Customer WHERE kycstatus = 1");
if ($result) {
    $row = $result->fetch_assoc();
    $kycVerified = $row['total'];
}

$result = $conn->query("
    SELECT COUNT(DISTINCT c.customerId) AS total
    FROM Customer c
    LEFT JOIN Account a ON c.customerId = a.customerId AND a.status = 'active'
    WHERE a.accountId IS NULL
");
if ($result) {
    $row = $result->fetch_assoc();
    $deactivated = $row['total'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Employee Dashboard</title>
  <link rel="stylesheet" href="cim.css" />
</head>
<body>
  <div class="dashboard">
    <aside class="sidebar">
      <h2>🏦 Bankii</h2>
      <nav>
        <ul>
          <li><a href="index.php">🏠 Dashboard</a></li>
          <li><a href="../AS/Sign_up.php">➕ Add Customer</a></li>
          <li><a href="customerc.php">🔍 Customer</a></li>
          <li><a href="#">✏️ Edit Customer Info</a></li>
          <li><a href="transaction-history.php">🕓 Transaction History</a></li>
           <li><a href="transaction.php"> 📝Transaction </a></li>
          <li><a href="../AS/index.php">🏃🏻Sign Out</a></li>
        </ul>
      </nav>
    </aside>

    <main class="main-content">
      <header class="topbar">
        <h1>👋 Welcome, Employee!</h1>
        <p>You are logged in as a bank employee. Manage and monitor customer data securely.</p>
      </header>

      <section class="summary-cards">
        <div class="card">👥 Total Customers<br /><strong><?= htmlspecialchars($totalCustomers) ?></strong></div>
        <div class="card">✅ KYC Verified<br /><strong><?= htmlspecialchars($kycVerified) ?></strong></div>
        <div class="card">🚫 Deactivated<br /><strong><?= htmlspecialchars($deactivated) ?></strong></div>
      </section>

      <section class="actions">
        <h2>Quick Actions</h2>
        <div class="buttons">
          <a href="../AS/Sign_up.php" class="btn">➕ Add New Customer</a>
          <a href="customerc.php" class="btn">🔍 View Customers</a>
          <a href="individual_history.php" class="btn">🔍 View Customers indivual transaction history</a>
          <a href="#" class="btn">👨‍💼 My Profile</a>
          <a href="transaction-history.php" class="btn">🕓 View Transactions</a>
          <a href="transaction.php" class="btn"> Transactions</a>
        </div>
      </section>
    </main>
  </div>
</body>
</html>