<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$db = "mochi_pets";
$conn = new mysqli($servername, $username, $password, $db);
//this will only show the available pets and not the adopted pets
$sql = "SELECT * FROM cat where adopted_status='Available'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cats</title>
    <link rel="stylesheet" href="css/style_cat.css">
    <link rel="stylesheet" href="css/style_index.css">
</head>
<body>
<div class="menu">
    <a href="index.php" class="currentpage">Home</a>
    <div class="menu-item">
        Our Pets
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
    <a href="contact.php">Contact Us</a>
</div>
<h2 style="text-align:center;">Our Cats 🐱</h2>
<div class="grid-container">
<?php
while($row = $result->fetch_assoc())
{
    echo "<div class='card'>";
    echo "<img src='images/cats/".$row["image"]."'>";
    echo "<h3>
              <a href='pet_details.php?type=cat&id=".$row["cat_ID"]."'>
                  ".$row["cat_name"]."
              </a>
            </h3>";
    echo "</div>";
}
?>
</div>
<div class="footer">
    <a href="about.html">About Us</a> |
    <a href="staff.php">Our Staff</a> |
    <a href="our_shelters.php">Our Shelters</a> |
    <a href="privacy_policy.html">Privacy Policy</a>
    <p>&copy; 2026 Mochi Pets. All Rights Reserved.</p>
</div>
</body>
</html>
<?php $conn->close(); ?>
