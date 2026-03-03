<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: admin_login.php'); exit; }
require 'db.php';

$gtin = $_GET['gtin'];

// Ensure product is hidden
$stmt = $pdo->prepare("SELECT hidden FROM products WHERE gtin=?");
$stmt->execute([$gtin]);
$product = $stmt->fetch();

if (!$product || !$product['hidden']) { die('Cannot delete non-hidden product'); }

$pdo->prepare("DELETE FROM products WHERE gtin=?")->execute([$gtin]);
header('Location: index.php');
?>