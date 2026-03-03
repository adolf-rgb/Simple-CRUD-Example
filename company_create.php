<?php
// company_create.php

// Database connection setup (modify as needed)
$conn = new PDO('mysql:host=localhost;dbname=your_db', 'username', 'password');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $companyName = $_POST['company_name'];
    $companyAddress = $_POST['company_address'];
    $companyTelephone = $_POST['company_telephone'];
    $companyEmail = $_POST['company_email'];
    $ownerName = $_POST['owner_name'];
    $ownerMobile = $_POST['owner_mobile'];
    $ownerEmail = $_POST['owner_email'];
    $contactName = $_POST['contact_name'];
    $contactMobile = $_POST['contact_mobile'];
    $contactEmail = $_POST['contact_email'];

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO companies (name, address, telephone, email, owner_name, owner_mobile, owner_email, contact_name, contact_mobile, contact_email, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
    $stmt->execute([$companyName, $companyAddress, $companyTelephone, $companyEmail, $ownerName, $ownerMobile, $ownerEmail, $contactName, $contactMobile, $contactEmail]);
    
    header('Location: company_list.php');
    exit;
}
?>

<h2>Create New Company</h2>
<form method="POST" action="">
    <label>Company Name:</label><br>
    <input type="text" name="company_name" required><br>

    <label>Address:</label><br>
    <input type="text" name="company_address" required><br>

    <label>Telephone:</label><br>
    <input type="text" name="company_telephone" required><br>

    <label>Email:</label><br>
    <input type="email" name="company_email" required><br>

    <h3>Owner Information</h3>
    <label>Name:</label><br>
    <input type="text" name="owner_name" required><br>
    <label>Mobile:</label><br>
    <input type="text" name="owner_mobile" required><br>
    <label>Email:</label><br>
    <input type="email" name="owner_email" required><br>

    <h3>Contact Information</h3>
    <label>Name:</label><br>
    <input type="text" name="contact_name" required><br>
    <label>Mobile:</label><br>
    <input type="text" name="contact_mobile" required><br>
    <label>Email:</label><br>
    <input type="email" name="contact_email" required><br>

    <button type="submit">Create Company</button>
</form>