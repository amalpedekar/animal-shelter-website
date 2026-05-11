<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "1234", "pet_store");
if ($conn->connect_error) {
    die("Connection failed");
}
$username = $_SESSION["username"];
$sqlUser = "SELECT cust_ID FROM customer WHERE username='$username'";
$resultUser = $conn->query($sqlUser);
$userRow = $resultUser->fetch_assoc();
$cust_ID = $userRow["cust_ID"];
$message = "";
$type = $_GET["type"] ?? null;
$id = $_GET["id"] ?? null;
if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $pet_id = $_POST["pet_id"];
        $pet_type = $_POST["pet_type"];
        $first = $_POST["first_name"];
        $last = $_POST["last_name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $city = $_POST["city"];
        $country = $_POST["country"];
        $whyadopt = $_POST["why_adopt"];
        $petsowned = $_POST["pets_owned"];
        $haschildren = $_POST["has_children"];
        $petalone = $_POST["pet_alone"];
        $petstay = $_POST["pet_stay"];
        $message = $_POST["message"];
        //  CHECK if already submitted for same pet
        $check = $conn->query("
            SELECT 1 FROM adoption_application
            WHERE cust_ID = '$cust_ID' AND pet_id = '$pet_id'
        ");
        if ($check->num_rows > 0) {
            $message = "You have already submitted an application for this pet.";
        }
        else {
        $sql = "INSERT INTO adoption_application (cust_ID, pet_id, pet_type, first_name, last_name, email, phone, city, country,
        why_adopt, pets_owned, has_children, pet_alone, pet_stay, message)
        VALUES ('$cust_ID', '$pet_id', '$pet_type', '$first', '$last', '$email', '$phone', '$city', '$country',
        '$whyadopt', '$petsowned', '$haschildren', '$petalone', '$petstay', '$message')";
        if ($conn->query($sql))
            {
                $message = "Application submitted successfully.";
            }
        else
            {
                $message = "Submission failed.";
            }
        }}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mochi Pet Store</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mycss.css/style_adoption_form.css">
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
<div class="content"> 
<?php
if ($message == "Application submitted successfully.") {
    echo "<div class='success-message'>Application submitted successfully.</div>";
}
?>
<h2 class="title-center"> Adoption Form 🐾 </h2>
<?php
if ($type && $id) {
    if ($type == "cat") {
        $sqlPet = "SELECT * FROM cat WHERE cat_ID='$id'";
    } else {
        $sqlPet = "SELECT * FROM dog WHERE dog_ID='$id'";
    }
    $resultPet = $conn->query($sqlPet);
    if ($resultPet && $resultPet->num_rows > 0) {
        $pet = $resultPet->fetch_assoc();
        $name = ($type == "cat") ? $pet["cat_name"] : $pet["dog_name"];
        $breed = ($type == "cat") ? $pet["cat_breed"] : $pet["dog_breed"];
        $folder = ($type == "cat") ? "images/cats/" : "images/dogs/";
        echo "<div style='text-align:center; margin-bottom:20px;'>";
        echo "<h3>Selected Pet</h3>";
        echo "<img src='".$folder.$pet["image"]."' width='150'><br>";
        echo "<p><strong>$name</strong></p>";
        echo "<p>$breed</p>";
        echo "</div>";
    }
}
?>
<?php if (!$type || !$id) { ?>
    <div style="color:red; text-align:center; margin-bottom:20px;">
        Please select a pet first before filling the adoption form.
    </div>
<div style="text-align:center; margin-top:10px;">
    <a href="cat.php">Browse Cats</a>
    <a href="dog.php">Browse Dogs</a>
</div>
<?php } ?>
<!--already been submitted-->
<?php
$alreadyApplied = false;
$check = $conn->query("
    SELECT 1 FROM adoption_application
    WHERE cust_ID = '$cust_ID' AND pet_id = '$id'
");
if ($check && $check->num_rows > 0) {
    $alreadyApplied = true;
}
?>
<?php if ($alreadyApplied) { ?>
    <div style="color:red; text-align:center; margin-bottom:15px;">
        You have already submitted an application for this pet
    </div>
<?php } ?>
<!--page wrapper so if customer has not selected a pet then form won't be shown-->
<?php if ($type && $id) { ?>
<form class="adoption-form" method="post">
    <input type="hidden" name="pet_id" value="<?php echo $id; ?>">
    <input type="hidden" name="pet_type" value="<?php echo $type; ?>">
    <h3>Personal Details</h3>
    *First Name: <input type="text" name="first_name" required><br><br>
    *Last Name: <input type="text" name="last_name" required><br><br>
    *Email: <input type="email" name="email" required><br><br>
    *Phone Number: <input type="text" name="phone" required><br><br>
    *City: <select name="city" required>
                <option value="">-- Select City --</option>
                <option value="Dubai">Dubai</option>
                <option value="Abu Dhabi">Abu Dhabi</option>
                <option value="Sharjah">Sharjah</option>
                <option value="Ajman">Ajman</option>
                <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                <option value="Fujairah">Fujairah</option>
                <option value="Umm Al Quwain">Umm Al Quwain</option>
            </select>
    *Country: <input type="text" name="country" required><br><br>
    *Why do you want to adopt a pet? <input type="text" name="why_adopt" required><br><br>
    *Do you own any pets? <select name="pets_owned" required>
                                <option value="">-- Select one --</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select><br><br>
    *Are there children in the home? <select name="has_children" required>
                                        <option value="">-- Select one --</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select><br><br>
    *How many hours per day would the pet be alone? <input type="number" name="pet_alone" required><br><br>
    *If you have to leave the city, urgently or planned,
    where would your pet stay? <select name="pet_stay" required>
                                    <option value="">-- Select one --</option>
                                    <option value="Apartment">Apartment</option>
                                    <option value="Villa">Villa</option>
                                    <option value="Pet Sitting">Pet Sitting</option>
                                    <option value="Others">Others</option>
                                </select><br><br>
    <h3>Message</h3>
    <textarea name="message" rows=10></textarea><br><br>
    <div style="margin-top:15px;">
        <input type="checkbox" name="agree" required>
        <label>
            I confirm that all the information provided is true and I agree to the adoption terms and conditions.
        </label>
    </div><br><br>
    <?php if ($alreadyApplied) { ?>
    <input type="submit" value="Already Applied" disabled>
    <?php }
    else { ?>
        <input type="submit" value="Submit Application">
    <?php } ?>
</form>
<?php } ?>
<br>
</div>
<div class="footer">
    <a href="about.php">About Us</a> |
    <a href="staff.php">Our Staff</a> |
    <a href="our_shelters.php">Our Shelters</a> |
    <a href="privacy.php">Privacy Policy</a>
    <p>&copy; 2026 Mochi Pets All Rights Reserved</p>
</div>
</body>
</html>
