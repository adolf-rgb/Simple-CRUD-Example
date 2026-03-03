

<?php
// company_edit.php

// Database connection setup
$conn = new PDO('mysql:host=localhost;dbname=your_db', 'username', 'password');

$companyId = $_GET['id'] ?? null;
if (!$companyId) {
    echo "Invalid company ID.";
    exit;
}

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM companies WHERE id = ?");
$stmt->execute([$companyId]);
$company = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$company) {
    echo "Company not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect updated data
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

    // Update database
    $stmt = $conn->prepare("UPDATE companies SET name=?, address=?, telephone=?, email=?, owner_name=?, owner_mobile=?, owner_email=?, contact_name=?, contact_mobile=?, contact_email=? WHERE id=?");
    $stmt->execute([$companyName, $companyAddress, $companyTelephone, $companyEmail, $ownerName, $ownerMobile, $ownerEmail, $contactName, $contactMobile, $contactEmail, $companyId]);

    header("Location: company_list.php");
    exit;
}
?>

<h2>Edit Company</h2>
<form method="POST" action="">
    <label>Company Name:</label><br>
    <input type="text" name="company_name" value="<?php echo htmlspecialchars($company['name']); ?>" required><br>

    <label>Address:</label><br>
    <input type="text" name="company_address" value="<?php echo htmlspecialchars($company['address']); ?>" required><br>

    <label>Telephone:</label><br>
    <input type="text" name="company_telephone" value="<?php echo htmlspecialchars($company['telephone']); ?>" required><br>

    <label>Email:</label><br>
    <input type="email" name="company_email" value="<?php echo htmlspecialchars($company['email']); ?>" required><br>

    <h3>Owner Information</h3>
    <label>Name:</label><br>
    <input type="text" name="owner_name" value="<?php echo htmlspecialchars($company['owner_name']); ?>" required><br>
    <label>Mobile:</label><br>
    <input type="text" name="owner_mobile" value="<?php echo htmlspecialchars($company['owner_mobile']); ?>" required><br>
    <label>Email:</label><br>
    <input type="email" name="owner_email" value="<?php echo htmlspecialchars($company['owner_email']); ?>" required><br>

    <h3>Contact Information</h3>
    <label>Name:</label><br>
    <input type="text" name="contact_name" value="<?php echo htmlspecialchars($company['contact_name']); ?>" required><br>
    <label>Mobile:</label><br>
    <input type="text" name="contact_mobile" value="<?php echo htmlspecialchars($company['contact_mobile']); ?>" required><br>
    <label>Email:</label><br>
    <input type="email" name="contact_email" value="<?php echo htmlspecialchars($company['contact_email']); ?>" required><br>

    <button type="submit">Update Company</button>
</form>
