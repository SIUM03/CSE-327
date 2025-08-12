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

$errors = [];
$success = '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("Invalid customer ID");
}

// --- Handle update ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $nid = trim($_POST['nid']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $kycstatus = isset($_POST['kycstatus']) ? 1 : 0;
    $password = trim($_POST['password']);

    if ($name === '') $errors[] = 'Name is required.';
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format.';

    if (empty($errors)) {
        if ($password !== '') {
            $sql = "UPDATE Customer SET name=?, nid=?, phone=?, email=?, address=?, kycstatus=?, password=? WHERE customerId=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssi", $name, $nid, $phone, $email, $address, $kycstatus, $password, $id);
        } else {
            $sql = "UPDATE Customer SET name=?, nid=?, phone=?, email=?, address=?, kycstatus=? WHERE customerId=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $name, $nid, $phone, $email, $address, $kycstatus, $id);
        }

        if ($stmt->execute()) {
            $success = 'Customer updated successfully.';
        } else {
            $errors[] = 'Update failed: ' . $stmt->error;
        }
        $stmt->close();
    }
}

// --- Fetch customer data ---
$stmt = $conn->prepare("SELECT * FROM Customer WHERE customerId=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$cust = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Edit Customer</title>
<style>
body { font-family: Arial, sans-serif; background:#f6f8fa; padding:20px; }
h1 { margin-bottom: 15px; }
.alert { padding:10px; border-radius:4px; margin-bottom:15px; }
.alert.success { background:#e6ffed; color:#1b6b2c; }
.alert.error { background:#ffe6e6; color:#a33; }
form { background:#fff; padding:15px; border-radius:6px; box-shadow:0 2px 5px rgba(0,0,0,0.08); }
label { display:block; margin-top:8px; font-weight:bold; }
input[type="text"], input[type="email"], input[type="password"], textarea {
    width:100%; padding:8px; margin-top:4px; border:1px solid #ccc; border-radius:4px;
}
.checkbox { display:flex; align-items:center; gap:6px; margin-top:8px; }
button { margin-top:12px; padding:8px 16px; border:none; border-radius:4px; background:#007bff; color:#fff; cursor:pointer; }
button:hover { background:#0056b3; }
a.btn { margin-left:8px; padding:8px 14px; border-radius:4px; background:#6c757d; color:#fff; text-decoration:none; }
a.btn:hover { background:#5a6268; }
</style>
</head>
<body>

<h1>Edit Customer #<?= e($cust['customerId']) ?></h1>

<?php if ($success): ?><div class="alert success"><?= e($success) ?></div><?php endif; ?>
<?php if (!empty($errors)): ?>
<div class="alert error"><ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<form method="post">
  <label>Name:
    <input type="text" name="name" value="<?= e($cust['name']) ?>" required>
  </label>
  <label>NID:
    <input type="text" name="nid" value="<?= e($cust['nid']) ?>">
  </label>
  <label>Phone:
    <input type="text" name="phone" value="<?= e($cust['phone']) ?>">
  </label>
  <label>Email:
    <input type="email" name="email" value="<?= e($cust['email']) ?>">
  </label>
  <label>Address:
    <textarea name="address"><?= e($cust['address']) ?></textarea>
  </label>
  <label class="checkbox">
    <input type="checkbox" name="kycstatus" <?= $cust['kycstatus'] ? 'checked' : '' ?>> KYC Verified
  </label>
  <label>Password (leave blank to keep unchanged):
    <input type="password" name="password">
  </label>
  <button type="submit">Save</button>
  <a href="customers.php" class="btn">Cancel</a>
</form>

</body>
</html>
