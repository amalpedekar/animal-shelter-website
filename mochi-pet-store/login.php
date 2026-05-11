<?php
session_start();
$loginError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $db = "mochi_pets";
    $conn = new mysqli($servername, $username, $password, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $txtusername = $_POST["txtusername"];
    $txtpassword = $_POST["txtpassword"];
    $sql = "SELECT * FROM customer 
            WHERE username='$txtusername' AND password='$txtpassword'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
        $_SESSION["username"] = $txtusername;
        $_SESSION["role"] = "customer";
        header("Location: index.php");
        exit();
    }
    else
    {
        $sql = "SELECT * FROM staff 
                WHERE username='$txtusername' AND password='$txtpassword'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0)
        {
            $_SESSION["username"] = $txtusername;
            $_SESSION["role"] = "staff";
            header("Location: admin.php");
            exit();
        }
        else
        {
            $loginError = "Invalid username or password";
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mochi Pets Store - Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style_index.css">
</head>

<body>

<div class="header">
    <div class="logo">Mochi Pets Store</div>
    <div class="title">Welcome to Mochi Pets</div>
    <div class="auth">
        <span><a href="signup.php">Sign Up</a></span>
    </div>
</div>

<div class="content">

    <h2 style="text-align:center;">Login</h2>
    <p style="text-align:center;">Login as Customer or Staff</p>

    <!-- FLEX CONTAINER -->
    <div style="
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
    ">
        <!-- LOGIN BOX -->
        <div style="
            width: 380px;
            background-color: #F5F5DC;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #D2B48C;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        ">
            <form method="post" action="login.php">
                Username:
                <input type="text" name="txtusername" required><br><br>
                Password:
                <input type="password" name="txtpassword" required><br><br>
                <span class="feedback"><?php echo $loginError; ?></span><br><br>
                <input type="submit" value="Login">
                <input type="reset" value="Reset">
            </form>

            <br>

            <p>
                New customer? <a href="signup.php">Sign up here</a>
            </p>

        </div>

    </div>

</div>
<br><br><br>
<div class="footer">
    &copy; 2026 Mochi Pets All Rights Reserved 
</div>

</body>
</html>