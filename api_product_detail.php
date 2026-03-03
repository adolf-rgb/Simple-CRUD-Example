<?php
require 'db.php';

$gtin = $_GET['gtin'] ?? '';

$stmt = $pdo->prepare("SELECT p.*, c.name AS company_name FROM products p JOIN companies c ON p.company_id=c.id WHERE p.gtin=? AND p.hidden=0");
$stmt->execute([$gtin]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    http_response_code(404);
    echo json_encode(['error' => 'Product not found']);
    exit;
}

echo json_encode($product);
?>