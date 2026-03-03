<?php
require 'db.php';

$gtin = $_GET['gtin'] ?? '';

$stmt = $pdo->prepare("SELECT p.*, c.name AS company_name FROM products p JOIN companies c ON p.company_id=c.id WHERE p.gtin=? AND p.hidden=0");
$stmt->execute([$gtin]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "<h2>Product not found or hidden</h2>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title><?= htmlspecialchars($product['name_en']) ?></title>
</head>
<body>
<h1><?= htmlspecialchars($product['name_en']) ?></h1>
<p><strong>Company:</strong> <?= htmlspecialchars($product['company_name']) ?></p>
<p><strong>GTIN:</strong> <?= htmlspecialchars($product['gtin']) ?></p>
<p><strong>Description:</strong> <?= htmlspecialchars($product['description_en']) ?></p>
<p><strong>Weight:</strong> <?= htmlspecialchars($product['weight_gross']) ?> <?= htmlspecialchars($product['weight_unit']) ?></p>
<!-- Image placeholder -->
<img src="<?= htmlspecialchars($product['image_path'] ?? 'placeholder.png') ?>" alt="Product Image" style="max-width:300px;">
</body>
</html>
