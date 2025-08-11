<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "banking_system");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle search filters safely
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
  <style>
    /* ===== Base Styles ===== */
    body {
      background: #eef4f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 20px;
      color: #333;
    }

    .container {
      background: white;
      border-radius: 20px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
      margin: auto;
      max-width: 1200px;
      padding: 25px 30px;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 700;
      font-size: 2rem;
      color: #007bff;
    }

    /* ===== Search Bar ===== */
    form .search-bar {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      justify-content: center;
      margin-bottom: 30px;
    }

    .search-bar input[type="text"] {
      background: #f7fbff;
      border: 1.5px solid #ccc;
      border-radius: 12px;
      flex: 1 1 250px;
      padding: 12px 18px;
      font-size: 1rem;
      transition: 0.3s;
      color: #444;
    }

    .search-bar input[type="text"]:focus {
      background: #e6f0ff;
      border-color: #007bff;
      outline: none;
      color: #000;
    }

    .search-bar button {
      background-color: #007bff;
      border: none;
      border-radius: 12px;
      color: white;
      cursor: pointer;
      padding: 12px 30px;
      font-size: 1rem;
      font-weight: 600;
      transition: background-color 0.3s ease;
      flex-shrink: 0;
    }

    .search-bar button:hover {
      background-color: #0056b3;
    }

    /* ===== Table Styling ===== */
    table {
      border-collapse: separate;
      border-spacing: 0;
      border-radius: 12px;
      overflow: hidden;
      width: 100%;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      background-color: white;
    }

    thead tr {
      background-color: #007bff;
      color: white;
      font-weight: 700;
      font-size: 1.1rem;
    }

    thead th {
      padding: 16px 22px;
      text-align: center;
      user-select: none;
    }

    tbody tr:nth-child(even) {
      background-color: #f9fbfd;
    }

    tbody tr:hover {
      background-color: #e1f0ff;
      transition: background-color 0.3s ease;
    }

    tbody td {
      padding: 16px 22px;
      text-align: center;
      font-size: 1rem;
      color: #555;
      border-bottom: 1px solid #e3e9f0;
    }

    /* ===== Status Badge ===== */
    .status {
      display: inline-block;
      font-size: 0.9rem;
      font-weight: 700;
      padding: 6px 16px;
      border-radius: 20px;
      color: white;
      text-transform: capitalize;
      user-select: none;
      min-width: 90px;
    }

    .status--resolved {
      background-color: #28a745;
    }

    .status--open {
      background-color: #dc3545;
    }

    .status--in-work {
      background-color: #ffc107;
      color: #212529;
    }

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
      .search-bar {
        flex-direction: column;
      }

      table,
      thead,
      tbody,
      th,
      td,
      tr {
        display: block;
      }

      thead tr {
        display: none;
      }

      tbody tr {
        margin-bottom: 25px;
        background: white;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
      }

      tbody td {
        text-align: right;
        padding-left: 50%;
        position: relative;
        border-bottom: none;
        font-size: 0.95rem;
      }

      tbody td::before {
        content: attr(data-label);
        position: absolute;
        left: 20px;
        top: 16px;
        font-weight: 700;
        text-transform: uppercase;
        color: #444;
        font-size: 0.75rem;
      }

     .status {
  display: inline-block;
  font-size: 0.9rem;
  font-weight: 700;
  padding: 6px 16px;
  border-radius: 20px;
  /* Make text black */
  color: black !important;
  text-transform: capitalize;
  user-select: none;
  min-width: 90px;
}

    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Banking Customer Information</h2>

    <!-- Search Bar -->
    <form method="GET" novalidate autocomplete="off">
      <div class="search-bar">
        <input
          type="text"
          name="name"
          placeholder="Search by Name"
          value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
          aria-label="Search by Name"
        />
        <input
          type="text"
          name="id"
          placeholder="Search by Customer ID"
          value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>"
          aria-label="Search by Customer ID"
        />
        <input
          type="text"
          name="nid"
          placeholder="Search by NID"
          value="<?= htmlspecialchars($nid, ENT_QUOTES, 'UTF-8') ?>"
          aria-label="Search by NID"
        />
        <button type="submit" aria-label="Search">Search</button>
      </div>
    </form>

    <!-- Table -->
    <table role="table" aria-label="Customer information table">
      <thead>
        <tr>
          <th scope="col">Customer ID</th>
          <th scope="col">Name</th>
          <th scope="col">NID</th>
          <th scope="col">Account No</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <?php
              $statusClass = 'status--' . strtolower(str_replace(' ', '-', $row['status'] ?? 'open'));
            ?>
            <tr>
              <td data-label="Customer ID"><?= htmlspecialchars((string) $row['customerid'], ENT_QUOTES, 'UTF-8') ?></td>
              <td data-label="Name"><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td data-label="NID"><?= htmlspecialchars($row['nid'], ENT_QUOTES, 'UTF-8') ?></td>
              <td data-label="Account No"><?= htmlspecialchars((string) $row['accountid'], ENT_QUOTES, 'UTF-8') ?></td>
             <td data-label="Status">
  <span class="status <?= $statusClass ?>" style="color: black;">
    <?= htmlspecialchars(ucfirst($row['status']), ENT_QUOTES, 'UTF-8') ?>
  </span>
</td>

            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" style="padding: 20px; text-align:center; font-style: italic; color: #777;">
              No results found.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>

</html>
<?php $conn->close(); ?>
