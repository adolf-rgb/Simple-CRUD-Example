<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: admin_login.php'); exit; }
require 'db.php';

$gtin = $_GET['gtin'];
$stmt = $pdo->prepare("UPDATE products SET hidden=1 WHERE gtin=?");
$stmt->execute([$gtin]);
header('Location: index.php');
?>