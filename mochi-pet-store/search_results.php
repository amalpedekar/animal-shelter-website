<?php
$conn = new mysqli("localhost", "root", "1234", "pet_store");
if ($conn->connect_error)
    {
        die("Connection failed");
    }
$result = null;
$search = "";
$typeLabel = "Search";
$breedLabel = "";
if (isset($_POST['search']))
    {
        $search = $_POST['search'];
        // Query both tables
        $sql = "SELECT cat_ID AS id, image, cat_name AS name, cat_breed AS breed, 'Cat' AS type FROM cat WHERE cat_breed LIKE '%$search%'
                UNION
                SELECT dog_ID AS id, image, dog_name AS name, dog_breed AS breed, 'Dog' AS type FROM dog WHERE dog_breed LIKE '%$search%'";
        $result = $conn->query($sql);
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mochi Pet Store</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mycss.css/style_search_results.css">
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
    <a href="contact.php">Contact Us</a>
</div>
<div class="content">
    <h2 class="title-center">
        <?php echo $typeLabel; ?> Results for:
        <span class="highlight"><?php echo $search; ?></span>
    </h2>
</div>    
<div class="search_results-container">
    <?php        
    if ($result && $result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='search_results-card'>";
                if ($row['type'] == "Cat")
                    {
                        $img = "images/cats/" . $row['image'];
                    } else {
                        $img = "images/dogs/" . $row['image'];
                    }
                echo "<img src='$img'>";
                echo "<h3 class='pet-name'><a href='pet_details.php?id=".$row['id']."&type=".strtolower($row['type'])."'>".$row['name']."</a></h3>";
                echo "<h4>".$row['breed']."</h4>";
                echo "<p>".$row['type']."</p>";
                echo "</div>";
            }
        }
    else
        {
            echo "<p class='no-results'>No matching breeds available in the system portfolio</p>";
        }
    ?>
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