<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: admin_login.php'); exit; }
require 'db.php';

// Fetch companies for dropdown
$companies = $pdo->query("SELECT * FROM companies")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_en = $_POST['name_en'];
    $name_fr = $_POST['name_fr'];
    $gtin = $_POST['gtin'];
    $desc_en = $_POST['description_en'];
    $desc_fr = $_POST['description_fr'];
    $brand = $_POST['brand'];
    $country = $_POST['country'];
    $gross = $_POST['gross_weight'];
    $net = $_POST['net_weight'];
    $unit = $_POST['weight_unit'];
    $company_id = $_POST['company_id'];

    // Validate GTIN
    if (preg_match('/^\d{13,14}$/', $gtin)) {
        $stmt = $pdo->prepare("INSERT INTO products (name_en, name_fr, gtin, description_en, description_fr, brand, countryOfOrigin, weight_gross, weight_net, weight_unit, company_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name_en, $name_fr, $gtin, $desc_en, $desc_fr, $brand, $country, $gross, $net, $unit, $company_id]);
        header('Location: index.php');
        exit;
    } else {
        $error = "Invalid GTIN.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Create Product</title></head>
<body>
<h2>Create Product</h2>
<form method="POST">
<input name="name_en" placeholder="Name EN" required><br>
<input name="name_fr" placeholder="Name FR" required><br>
<input name="gtin" placeholder="GTIN (13-14 digits)" pattern="\d{13,14}" required><br>
<textarea name="description_en" placeholder="Description EN"></textarea><br>
<textarea name="description_fr" placeholder="Description FR"></textarea><br>
<input name="brand" placeholder="Brand" required><br>
<input name="country" placeholder="Country" required><br>
<input name="gross_weight" placeholder="Gross Weight" type="number" step="0.01" required><br>
<input name="net_weight" placeholder="Net Weight" type="number" step="0.01" required><br>
<input name="weight_unit" placeholder="Weight Unit" required><br>
<select name="company_id" required>
<?php foreach ($companies as $c): ?>
<option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
<?php endforeach; ?>
</select><br>
<button type="submit">Create</button>
</form>
<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
</body>
</html>