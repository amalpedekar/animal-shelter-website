<?php
// session_start();

// if (!isset($_SESSION["username"]) || $_SESSION["role"] != "staff")
// {
//     header("Location: login.php");
//     exit();
// }

// Database connection
$conn = new mysqli("localhost", "root", "1234", "pet_store");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Total Cats
$totalCats = $conn->query("SELECT COUNT(*) AS total FROM cat")->fetch_assoc()['total'];

// Total Dogs
$totalDogs = $conn->query("SELECT COUNT(*) AS total FROM dog")->fetch_assoc()['total'];

// Total Pets = Cats + Dogs
$totalPets = $totalCats + $totalDogs;

// Fetch application stats
$pending = $conn->query("SELECT COUNT(*) AS total FROM applications WHERE status='pending'")->fetch_assoc()['total'];
$approved = $conn->query("SELECT COUNT(*) AS total FROM applications WHERE status='approved'")->fetch_assoc()['total'];
$rejected = $conn->query("SELECT COUNT(*) AS total FROM applications WHERE status='rejected'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mochi Pets Store - Admin</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style_index.css">
</head>

<body>

<div class="header">
    <div class="logo">Mochi Pets Store</div>
    <div class="title">Admin Panel</div>
    <div class="auth">
        <span>Welcome Staff</span> |
        <span><a href="logout.php">Logout</a></span>
    </div>
</div>

<div class="menu">

    <a href="admin.php" class="currentpage">Dashboard</a>

    <div class="menu-item">
        Manage Pets
        <div class="dropdown">
            <a href="manage_cats.php">Cats</a>
            <a href="manage_dogs.php">Dogs</a>
        </div>
    </div>

    <a href="manage_applications.php">Manage Applications</a>

</div>

<div class="content">

    <h2>Welcome to Admin Dashboard</h2>
    <p>You can manage pets and adoption applications here.</p>

    <div class="flex-container admin-flex">

        <div class="flex-box admin-box">
            <a href="manage_pets.php">
                <h3>Manage Pets</h3>
            </a>

            <div class="admin-stats">
                <p><strong>Total Pets:</strong> <?php echo $totalPets; ?></p>
                <p><strong>Cats:</strong> <?php echo $totalCats; ?></p>
                <p><strong>Dogs:</strong> <?php echo $totalDogs; ?></p>
            </div>
        </div>

        <div class="flex-box admin-box">
            <a href="manage_applications.php">
                <h3>Manage Applications</h3>
            </a>

            <div class="admin-stats">
                <p><strong>Pending:</strong> <?php echo $pending; ?></p>
                <p><strong>Approved:</strong> <?php echo $approved; ?></p>
                <p><strong>Rejected:</strong> <?php echo $rejected; ?></p>
            </div>
        </div>

    </div>

</div>

<div class="footer">
    &copy; 2026 Mochi Pets All Rights Reserved
</div>

</body>
</html>