<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "banking system");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Optional: handle search filters
$name = $_GET['name'] ?? '';
$id = $_GET['id'] ?? '';
$nid = $_GET['nid'] ?? '';

$sql = "SELECT c.customerid, c.name, c.nid, a.accountid, a.status
        FROM customer c
        LEFT JOIN account a ON c.customerid = a.customerid
        WHERE c.name LIKE ? AND c.customerid LIKE ? AND c.nid LIKE ?";

$stmt = $conn->prepare($sql);
$likeName = "%" . $name . "%";
$likeID = "%" . $id . "%";
$likeNID = "%" . $nid . "%";
$stmt->bind_param("sss", $likeName, $likeID, $likeNID);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Banking Customer Info</title>
  <link rel="stylesheet" href="customerc.css" />
</head>
<body>
  <div class="container">
    <h2>Banking Customer Information</h2>

    <!-- Search Bar -->
    <form method="GET">
      <div class="search-bar">
        <input
          type="text"
          name="name"
          placeholder="Search by Name"
          value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
        />
        <input
          type="text"
          name="id"
          placeholder="Search by Customer ID"
          value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>"
        />
        <input
          type="text"
          name="nid"
          placeholder="Search by NID"
          value="<?= htmlspecialchars($nid, ENT_QUOTES, 'UTF-8') ?>"
        />
        <button type="submit">Search</button>
      </div>
    </form>

    <!-- Table -->
    <table class="table">
      <thead>
        <tr>
          <th>Customer ID</th>
          <th>Name</th>
          <th>NID</th>
          <th>Account No</th>
          <th>Status</th>
          <th>Transaction</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars((string) $row['customerid'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($row['nid'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars((string) $row['accountid'], ENT_QUOTES, 'UTF-8') ?></td>
              <td>
                <span class="status <?= htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8') ?>">
                  <?= htmlspecialchars(ucfirst($row['status']), ENT_QUOTES, 'UTF-8') ?>
                </span>
              </td>
              <td>
                <a
                  href="transaction_view.php?id=<?= htmlspecialchars((string) $row['customerid'], ENT_QUOTES, 'UTF-8') ?>"
                  class="trans-btn"
                >
                  View
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6">No results found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
<?php
$conn->close();
?>
