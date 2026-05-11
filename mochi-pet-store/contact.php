<?php
$messageSent = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["txtname"];
    $email = $_POST["txtemail"];
    $msg = $_POST["txtmessage"];

    if ($name != "" && $email != "" && $msg != "") {
        $messageSent = "Message received! We will contact you soon.";
    } else {
        $messageSent = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact - Mochi Pets</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/style_index.css">
    <link rel="stylesheet" href="css/style_contact.css">
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div class="logo">Mochi Pets</div>
    <div class="title">Contact Us</div>
    <div class="auth">
        <span><a href="login.php">Login</a></span> |
        <span><a href="signup.php">Sign Up</a></span>
    </div>
</div>

<!-- MENU -->
<div class="menu">
    <a href="index.php">Home</a>

    <div class="menu-item">
        Category
        <div class="dropdown">
            <a href="category.php">Cats</a>
            <a href="category.php">Dogs</a>
        </div>
    </div>

    <div class="menu-item">
        Adoption
        <div class="dropdown">
            <a href="adoption_form.php">Adoption Form</a>
            <a href="my_applications.php">My Applications</a>
        </div>
    </div>

    <a href="about.php">About Us</a>
    <a href="contact.php" class="currentpage">Contact</a>
</div>

<!-- CONTENT -->
<div class="content">

    <h2 style="text-align:center;">Contact Us 🐾</h2>

    <div class="contact-box">
        <p>Email: support@mochipets.com</p>
        <p>Phone: +971 123 4567</p>

        <h3>Send us a message</h3>

        <form method="post" action="contact.php">
            Name:
            <input type="text" name="txtname" required>

            Email:
            <input type="email" name="txtemail" required>

            Message:
            <textarea name="txtmessage" rows="5" required></textarea>

            <input type="submit" value="Send Message">
        </form>

        <div class="message">
            <?php echo $messageSent; ?>
        </div>
    </div>

</div>

<!-- FOOTER -->
<div class="footer">
    <p>&copy; 2026 Mochi Pets All Rights Reserved</p>
    <a href="staff.php">Our Staff</a> |
    <a href="shelter.php">Shelters</a> |
    <a href="privacy_policy.html">Privacy Policy</a> |
    <a href="about.html">About Us</a>
</div>

</body>
</html>