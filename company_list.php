<?php
// company_list.php

// Database connection setup
$conn = new PDO('mysql:host=localhost;dbname=your_db', 'username', 'password');

$stmt = $conn->query("SELECT * FROM companies WHERE active=1");
$companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Companies List</h2>
<a href="company_create.php">Create New Company</a>
<table border="1" cellpadding="5" cellspacing="0">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Address</th>
    <th>Telephone</th>
    <th>Email</th>
    <th>Actions</th>
</tr>
<?php foreach ($companies as $company): ?>
<tr>
    <td><?php echo $company['id']; ?></td>
    <td><?php echo htmlspecialchars($company['name']); ?></td>
    <td><?php echo htmlspecialchars($company['address']); ?></td>
    <td><?php echo htmlspecialchars($company['telephone']); ?></td>
    <td><?php echo htmlspecialchars($company['email']); ?></td>
    <td>
        <a href="company_edit.php?id=<?php echo $company['id']; ?>">Edit</a>
        <!-- Deactivation or delete actions can be added here -->
    </td>
</tr>
<?php endforeach; ?>
</table>