<?php
$conn = new mysqli("localhost", "root", "1234", "mochi_pets");

if ($conn->connect_error) {
    die("Connection failed");
}

$sql = "SELECT * FROM staff";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mochi Pet Store</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style_staff.css">
</head>

<body>

<div class="header">
    <div class="logo">Mochi Pets</div>
    <div class="title">Our Staff</div>
    <div class="auth">
        <span><a href="login.php">Login</a></span> |
        <span><a href="signup.php">Sign Up</a></span>
    </div>
</div>

<div class="menu">

    <a href="index.html">Home</a>

    <div class="menu-item">
        Category
        <div class="dropdown">
            <a href="cat.php">Cats</a>
            <a href="dog.php">Dogs</a>
        </div>
    </div>

    <div class="menu-item">
        Adoption
        <div class="dropdown">
            <a href="adoption_form.php">Adoption Form</a>
            <a href="my_applications.php">My Applications</a>
        </div>
    </div>

    <a href="contact.php">Contact</a>
</div>

<div class="content">

<h2 class="title-center"> Our Staff 👩‍⚕️🐾</h2>

<div class="staff-container">

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "
        <div class='staff-card'>
            <h3>".$row['staff_name']."</h3>
            <p><b>Role:</b> ".$row['role_name']."</p>
            <p><b>Phone:</b> ".$row['phone_no']."</p>
            <p><b>Salary:</b> ".$row['salary']."</p>
        </div>
        ";
    }
} else {
    echo "<p>No staff available.</p>";
}
?>

</div>

</div>

<div class="footer">
    <p>&copy; 2026 Mochi Pets All Rights Reserved</p>
    <a href="staff.php">Our Staff</a> |
    <a href="shelter.php">Shelters</a> |
    <a href="privacy_policy.html">Privacy Policy</a> |
     <a href="about.html">About Us</a>
</div>

</body>
</html>