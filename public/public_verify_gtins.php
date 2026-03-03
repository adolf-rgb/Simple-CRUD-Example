<?php
$result = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gtins_input = $_POST['gtins'] ?? '';
    $gtins = preg_split('/\r?\n/', $gtins_input);
    require 'db.php';

    $placeholders = implode(',', array_fill(0, count($gtins), '?'));
    $stmt = $pdo->prepare("SELECT gtin FROM products WHERE gtin IN ($placeholders) AND hidden=0");
    $stmt->execute($gtins);
    $found_gtins = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($gtins as $gtin) {
        $gtin = trim($gtin);
        $isValid = preg_match('/^\d{13,14}$/', $gtin) && in_array($gtin, $found_gtins);
        $result[] = ['gtin' => $gtin, 'valid' => $isValid];
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Bulk GTIN Verification</title></head>
<body>
<h2>Bulk GTIN Verification</h2>
<form method="POST">
<textarea name="gtins" rows="10" cols="30" placeholder="Enter GTINs, one per line"><?= isset($_POST['gtins']) ? htmlspecialchars($_POST['gtins']) : '' ?></textarea><br>
<button type="submit">Verify</button>
</form>
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
<h3>Results:</h3>
<ul>
<?php foreach ($result as $res): ?>
<li><?= htmlspecialchars($res['gtin']) ?> - <?= $res['valid'] ? 'Valid ✅' : 'Invalid ❌' ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
</body>
</html>