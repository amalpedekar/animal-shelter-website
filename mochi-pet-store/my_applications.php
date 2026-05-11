<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "1234", "pet_store");
$username = $_SESSION["username"];
$sqlUser = "SELECT cust_ID FROM customer WHERE username='$username'";
$resultUser = $conn->query($sqlUser);
$userRow = $resultUser->fetch_assoc();
$cust_ID = $userRow["cust_ID"];
// HANDLE WITHDRAW REQUEST
if (isset($_GET['withdraw'])) {
    $app_id = $_GET['withdraw'];
    $conn->query("
        UPDATE adoption_application
        SET status='Withdrawal Requested'
        WHERE app_ID='$app_id' AND cust_ID='$cust_ID'
    ");
    header("Location: my_applications.php");
    exit();
}
$sqlApp = "
SELECT a.*,
       c.cat_name AS pet_name, c.cat_breed AS breed, c.image AS cat_image,
       d.dog_name AS dog_name, d.dog_breed AS dog_breed, d.image AS dog_image
FROM adoption_application a
LEFT JOIN cat c ON a.pet_type='cat' AND a.pet_id=c.cat_ID
LEFT JOIN dog d ON a.pet_type='dog' AND a.pet_id=d.dog_ID
WHERE a.cust_ID='$cust_ID'
";
$result = $conn->query($sqlApp);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mochi Pet Store</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mycss.css/style_my_applications.css">
    <style>
        .intro {
            text-align: center;
            padding: 30px;
            background-color: #FAF9F6;
        }
        .flex-container {
            display: flex;
            justify-content: space-around;
            margin: 40px;
        }
        .flex-box {
            background-color: #F5F5DC;
            padding: 20px;
            width: 40%;
            border-radius: 10px;
            text-align: center;
        }
        .carousel img {
            width: 30%;
            margin: 10px;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="logo">Mochi Pets</div>
        <div class="title">Welcome to Mochi Pet Store</div>
        <div class="auth">
        <?php
        if (isset($_SESSION["username"])) {
            echo "<span>Welcome " . $_SESSION["username"] . "</span> | ";
            echo "<span><a href='logout.php'>Logout</a></span>";
        } else {
            echo "<span><a href='login.php'>Login</a></span> | ";
            echo "<span><a href='signup.php'>Sign Up</a></span>";
        }
        ?>
        </div>
</div>
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
    <a href="contact.php">Contact</a>
</div>
<div class="search">
    <form method="post" action="search_results.php">
        <input type="text" name="search" placeholder="Search pet breed...">
        <input type="submit" value="Search">
    </form>
</div>
<div class="content my-applications">
<h2 class="title-center"> My Applications 🐾 </h2>
<div class="table-container">
<?php
if ($result->num_rows > 0) {
    echo "<div class='application-grid'>";
    while ($row = $result->fetch_assoc()) {
        $isCat = ($row['pet_type'] == "cat");
        $petName = $isCat ? $row['pet_name'] : $row['dog_name'];
        $breed   = $isCat ? $row['breed'] : $row['dog_breed'];
        $image   = $isCat ? "images/cats/" . $row['cat_image'] : "images/dogs/" . $row['dog_image'];
        echo "<div class='application-card'>
            <div class='app-header'>
                <span class='app-id'>Application #" . $row['app_ID'] . "</span>
                <span class='status-badge'>" . $row['status'] . "</span>
            </div>
            <div class='pet-section'>
                <img src='$image' class='pet-image'>
                <h3 class='pet-name'>$petName</h3>
                <p class='pet-breed'>$breed</p>
            </div>
            <div class='app-body'>
                <p><strong>Location:</strong> " . $row['city'] . ", " . $row['country'] . "</p>
                <p><strong>Reason:</strong> " . $row['why_adopt'] . "</p>
                <p><strong>Message:</strong> " . $row['message'] . "</p>
            </div>";
        if ($row['status'] == 'Pending') {
            echo "<a href='?withdraw=" . $row['app_ID'] . "' class='withdraw-btn'>Request Withdrawal</a>";
        }
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<div class='empty-state'>
            <h3>No applications found</h3>
            <p>Start your journey by adopting a pet today.</p>
          </div>";
}
?>
</div>
</div>
<div class="footer">
    <p>&copy; 2026 Mochi Pets All Rights Reserved</p>
    <a href="about.php">About Us</a> |
    <a href="staff.php">Our Staff</a> |
    <a href="our_shelters.php">Our Shelters</a> |
    <a href="privacy.php">Privacy Policy</a>
</div>
</body>
</html>
