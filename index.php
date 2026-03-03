<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}
require 'db.php';

// Fetch companies
$companies = $pdo->query("SELECT * FROM companies")->fetchAll();
// Fetch products
$products = $pdo->query("SELECT p.*, c.name AS company_name FROM products p JOIN companies c ON p.company_id=c.id")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
<h2>Companies</h2>
<a href="company_create.php">Create Company</a>
<table border="1"><tr><th>Name</th><th>Actions</th></tr>
<?php foreach ($companies as $c): ?>
<tr><td><?= htmlspecialchars($c['name']) ?></td>
<td>
<a href="company_edit.php?id=<?= $c['id'] ?>">Edit</a>
</td></tr>
<?php endforeach; ?>
</table>

<h2>Products</h2>
<a href="product_create.php">Create Product</a>
<table border="1"><tr><th>Name EN</th><th>GTIN</th><th>Company</th><th>Actions</th></tr>
<?php foreach ($products as $p): ?>
<tr>
<td><?= htmlspecialchars($p['name_en']) ?></td>
<td><?= htmlspecialchars($p['gtin']) ?></td>
<td><?= htmlspecialchars($p['company_name']) ?></td>
<td>
<a href="product_edit.php?gtin=<?= $p['gtin'] ?>">Edit</a>
<a href="product_view.php?gtin=<?= $p['gtin'] ?>">View</a>
<a href="product_hide.php?gtin=<?= $p['gtin'] ?>">Hide</a>
</td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>