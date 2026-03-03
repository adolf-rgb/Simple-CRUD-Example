<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: admin_login.php'); exit; }
require 'db.php';

$gtin = $_GET['gtin'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE gtin=?");
$stmt->execute([$gtin]);
$product = $stmt->fetch();

if (!$product) { die('Product not found'); }

$companies = $pdo->query("SELECT * FROM companies")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_en = $_POST['name_en'];
    $name_fr = $_POST['name_fr'];
    $desc_en = $_POST['description_en'];
    $desc_fr = $_POST['description_fr'];
    $brand = $_POST['brand'];
    $country = $_POST['country'];
    $gross = $_POST['gross_weight'];
    $net = $_POST['net_weight'];
    $unit = $_POST['weight_unit'];
    $company_id = $_POST['company_id'];

    $stmt = $pdo->prepare("UPDATE products SET name_en=?, name_fr=?, description_en=?, description_fr=?, brand=?, countryOfOrigin=?, weight_gross=?, weight_net=?, weight_unit=?, company_id=? WHERE gtin=?");
    $stmt->execute([$name_en, $name_fr, $desc_en, $desc_fr, $brand, $country, $gross, $net, $unit, $company_id, $gtin]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Product</title></head>
<body>
<h2>Edit Product</h2>
<form method="POST">
<input name="name_en" value="<?= htmlspecialchars($product['name_en']) ?>" required><br>
<input name="name_fr" value="<?= htmlspecialchars($product['name_fr']) ?>" required><br>
<textarea name="description_en"><?= htmlspecialchars($product['description_en']) ?></textarea><br>
<textarea name="description_fr"><?= htmlspecialchars($product['description_fr']) ?></textarea><br>
<input name="brand" value="<?= htmlspecialchars($product['brand']) ?>" required><br>
<input name="country" value="<?= htmlspecialchars($product['countryOfOrigin']) ?>" required><br>
<input name="gross_weight" value="<?= htmlspecialchars($product['weight_gross']) ?>" type="number" step="0.01" required><br>
<input name="net_weight" value="<?= htmlspecialchars($product['weight_net']) ?>" type="number" step="0.01" required><br>
<input name="weight_unit" value="<?= htmlspecialchars($product['weight_unit']) ?>" required><br>
<select name="company_id" required>
<?php foreach ($companies as $c): ?>
<option value="<?= $c['id'] ?>" <?= ($c['id'] == $product['company_id']) ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
<?php endforeach; ?>
</select><br>
<button type="submit">Update</button>
</form>
</body>
</html>