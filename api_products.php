<?php
require 'db.php';

// Pagination parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Search query
$query = isset($_GET['query']) ? $_GET['query'] : '';

$sqlCount = "SELECT COUNT(*) FROM products WHERE hidden=0";
$sqlData = "SELECT p.*, c.name AS company_name FROM products p JOIN companies c ON p.company_id=c.id WHERE p.hidden=0";

$params = [];

if ($query) {
    $sqlCount .= " AND (p.name_en LIKE :search OR p.description_en LIKE :search OR p.name_fr LIKE :search OR p.description_fr LIKE :search)";
    $sqlData .= " AND (p.name_en LIKE :search OR p.description_en LIKE :search OR p.name_fr LIKE :search OR p.description_fr LIKE :search)";
    $params[':search'] = '%' . $query . '%';
}

$totalStmt = $pdo->prepare($sqlCount);
$totalStmt->execute($params);
$totalCount = $totalStmt->fetchColumn();

$totalPages = ceil($totalCount / $perPage);

$stmt = $pdo->prepare($sqlData . " LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

echo json_encode([
    'data' => $products,
    'pagination' => [
        'current_page' => $page,
        'total_pages' => $totalPages,
        'per_page' => $perPage,
        'next_page_url' => $page < $totalPages ? $baseUrl . '/api_products.php?page=' . ($page + 1) . ($query ? '&query=' . urlencode($query) : '') : null,
        'prev_page_url' => $page > 1 ? $baseUrl . '/api_products.php?page=' . ($page - 1) . ($query ? '&query=' . urlencode($query) : '') : null
    ]
]);
?>