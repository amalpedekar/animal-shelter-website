
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mochi Pet Store</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style_index.css">
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
    <a href="contact.php">Contact Us</a>
</div>
<div class="search">
    <form method="get" action="search_results.php">
        <input type="text" name="search" placeholder="Search pet breed...">
        <input type="submit" value="Search">
    </form>
</div>
<div class="content">
    <!-- INTRO -->
    <div class="intro">
        <h2>Welcome to Mochi Pet Store 🐾</h2>
        <p>
            At Mochi Pet Store, we believe every pet deserves a loving forever home.
            Browse our cats and dogs and begin your adoption journey today.
        </p>
    </div>
    <div class="carousel">
        <img src="images/cats/mickey.jpeg
" alt="Pet 1">
        <img src="images/dogs/tobby.jpeg
" alt="Pet 2">
        <img src="images/cats/bella.jpeg
" alt="Pet 3">
    </div>
    <div class="flex-container">
        <div class="flex-box">
            <h3> Our Adoption Process </h3>
            <p>Fill out the application form</p>
            <p>We review your request</p>
            <p>We contact you</p>
            <p>Meet your pet 🐶🐱</p>
        </div>
    </div>
    </div>
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