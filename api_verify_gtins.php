<?php
require 'db.php';

$input = isset($_GET['gtins']) ? $_GET['gtins'] : '';
$gtins = preg_split('/\r?\n/', $input);
$result = [];

if (!$gtins) {
    echo json_encode(['error' => 'No GTINs provided']);
    exit;
}

$placeholders = implode(',', array_fill(0, count($gtins), '?'));

$stmt = $pdo->prepare("SELECT gtin FROM products WHERE gtin IN ($placeholders) AND hidden=0");
$stmt->execute($gtins);
found_gtins = $stmt->fetchAll(PDO::FETCH_COLUMN);

foreach ($gtins as $gtin) {
    $gtin = trim($gtin);
    $isValid = preg_match('/^\d{13,14}$/', $gtin) && in_array($gtin, $found_gtins);
    $result[] = [
        'gtin' => $gtin,
        'valid' => $isValid
    ];
}

echo json_encode(['results' => $result]);
?>