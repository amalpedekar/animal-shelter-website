<?php
session_start();
$conn = new mysqli("localhost", "root", "1234", "pet_store");
if ($conn->connect_error) {
    die("Connection failed");
}
if (!isset($_GET['id']) || empty($_GET['id']))
    {
        header("Location: search_results.php");
        exit();
    }
/* Capture routing parameters */
$type = $_GET["type"] ?? null;
$id = $_GET["id"] ?? null;
if (!$type || !$id)
    {
        die("Invalid request: Missing parameters.");
    }
?>
<!-- Dynamic table routing logic -->
<?php
if ($type == "cat") {
    $id = intval($_GET["id"]);
    $sql = "SELECT * FROM cat WHERE cat_ID='$id'";
} elseif ($type == "dog") {
    $id = intval($_GET["id"]);
    $sql = "SELECT * FROM dog WHERE dog_ID='$id'";
} else {
    die("Invalid pet type.");
}
$result = $conn->query($sql);
if (!$result || $result->num_rows == 0) {
    die("Pet not found.");
}
$pet = $result->fetch_assoc();
?>
<?php
$dob = $pet["DOB"];  // assumes column is "DOB" and this is for showing age
$birthDate = new DateTime($dob);
$today = new DateTime();
$age = $today->diff($birthDate)->y;
?>
<?php
/*vaccined or not*/
$vaccinated = false;
if ($type == "cat") {
    $vacSql = "SELECT * FROM cat_vaccination WHERE cat_ID='$id'";
    $vacResult = $conn->query($vacSql);
    if ($vacResult && $vacResult->num_rows > 0) {
        $vaccinated = true;
    }
} elseif ($type == "dog") {
    $vacSql = "SELECT * FROM dog_vaccination WHERE dog_ID='$id'";
    $vacResult = $conn->query($vacSql);
    if ($vacResult && $vacResult->num_rows > 0) {
        $vaccinated = true;
    }
}

$trained = false;
if ($type == "dog") {
    $trainSql = "SELECT * FROM training WHERE dog_ID='$id'";
    $trainResult = $conn->query($trainSql);
    if ($trainResult && $trainResult->num_rows > 0)
        {$trained = true;}
}
$litter_trained = false;
if ($type == "cat")
    {
        $trainSql = "Select * FROM cat WHERE cat_ID='$id' AND litter_training = 1";
        $trainResult = $conn->query($trainSql);
        if ($trainResult && $trainResult->num_rows >0)
            {$litter_trained = true;}
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mochi Pet Store</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mycss.css/style_pet_details.css">
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
        <span><a href="login.php">Login</a></span> |
        <span><a href="signup.php">Sign Up</a></span>
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
<div class="content">
    <h2 class="pet-title"> Pet Profile </h2>
    <div class="pet-card">
        <!-- LEFT SIDE -->
         <div class="pet-image">
            <img src="<?php echo ($type == 'cat') ? 'images/cats/' : 'images/dogs/'; ?><?php echo $pet['image']; ?>">
        </div>
        <!-- RIGHT SIDE -->
        <div class="pet-info">
            <h3>
                <?php echo ($type == "cat") ? $pet["cat_name"] : $pet["dog_name"]; ?>
            </h3>
            <p><strong>Breed - </strong> <?php echo ($type == "cat") ? $pet["cat_breed"] : $pet["dog_breed"]; ?></p>
            <p><strong>Gender - </strong> <?php echo $pet["gender"] ?? "N/A"; ?></p>
            <p><strong>Age - </strong> <?php echo $age; ?> years</p>
            <p><strong>Weight - </strong> <?php echo $pet["weight"] ?? "N/A"; ?> kg</p>
            <p><strong>Vaccinated - </strong><?php echo ($vaccinated) ? "Yes" : "No"; ?></p>
            <?php if ($type == "dog"): ?>
                <p><strong>Trained - </strong>
                <?php echo ($trained) ? "Yes" : "No"; ?>
                </p>
            <?php endif; ?>
            <?php if ($type == "cat"): ?>
                <p><strong>Litter Training - </strong>
                    <?php echo ($litter_trained) ? "Yes" : "No"; ?>
                </p>
            <?php endif; ?>
            <p><strong>Description - </strong> <?php echo $pet["description"]; ?></p>
            <br>
            <a class="adopt-btn"
            href="adoption_form.php?type=<?php echo $type; ?>&id=<?php echo $id; ?>">
                Adopt Me 🐾
            </a>
        </div>
    </div>
</div>
<div class="footer">
    <a href="about.php">About Us</a> |
    <a href="staff.php">Our Staff</a> |
    <a href="our_shelters.php">Our Shelters</a> |
    <a href="privacy.php">Privacy Policy</a>
    <p>&copy; 2026 Mochi Pets. All Rights Reserved.</p>
</div>
</body>
</html>
