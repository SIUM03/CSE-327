<?php
// --- DB connection ---
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'banking_system';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

function e($v) { return htmlspecialchars($v ?? ''); }

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// --- Fetch customers with search ---
$sql = "SELECT customerId, name, nid, phone, email, address, kycstatus 
        FROM Customer 
        WHERE name LIKE ? OR nid LIKE ? OR phone LIKE ? OR email LIKE ?
        ORDER BY customerId ASC";
$stmt = $conn->prepare($sql);
$like = "%$search%";
$stmt->bind_param("ssss", $like, $like, $like, $like);
$stmt->execute();
$res = $stmt->get_result();

$customers = [];
while ($row = $res->fetch_assoc()) {
    $customers[] = $row;
}
$stmt->close();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Customer Management</title>
<style>
body { font-family: Arial, sans-serif; background:#f6f8fa; padding:20px; }
h1 { margin-bottom: 15px; }
.search-bar { display:flex; gap:10px; margin-bottom:20px; }
.search-bar input[type="text"] { flex:1; padding:8px; border:1px solid #ccc; border-radius:4px; }
.search-bar button { padding:8px 16px; background:#007bff; border:none; color:#fff; border-radius:4px; cursor:pointer; }
.search-bar button:hover { background:#0056b3; }
table { width:100%; border-collapse: collapse; background:#fff; box-shadow:0 2px 5px rgba(0,0,0,0.05); }
th, td { padding:10px; border-bottom:1px solid #ddd; text-align:left; }
th { background:#f0f0f0; }
.btn { padding:6px 12px; border-radius:4px; background:#28a745; color:#fff; text-decoration:none; font-size:14px; }
.btn:hover { background:#218838; }
.no-data { text-align:center; padding:20px; color:#666; }
</style>
</head>
<body>

<h1>Customer List</h1>

<form class="search-bar" method="get">
    <input type="text" name="search" placeholder="Search customers..." value="<?= e($search) ?>">
    <button type="submit">Search</button>
</form>

<table>
<thead>
<tr>
  <th>ID</th><th>Name</th><th>NID</th><th>Phone</th><th>Email</th><th>KYC</th><th>Actions</th>
</tr>
</thead>
<tbody>
<?php if ($customers): ?>
<?php foreach ($customers as $cust): ?>
<tr>
  <td><?= e($cust['customerId']) ?></td>
  <td><?= e($cust['name']) ?></td>
  <td><?= e($cust['nid']) ?></td>
  <td><?= e($cust['phone']) ?></td>
  <td><?= e($cust['email']) ?></td>
  <td><?= $cust['kycstatus'] ? 'Verified' : 'Not Verified' ?></td>
  <td><a class="btn" href="edit.php?id=<?= e($cust['customerId']) ?>">Edit</a></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="7" class="no-data">No customers found</td></tr>
<?php endif; ?>
</tbody>
</table>

</body>
</html>
