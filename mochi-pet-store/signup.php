<?php
$valid = true;
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $txtname = $_POST["txtname"];
    $txtphone = $_POST["txtphone"];
    $txtcity = $_POST["txtcity"];
    $txtemail = $_POST["txtemail"];
    $txtpassword = $_POST["txtpassword"];
    $txtpassword1 = $_POST["txtpassword1"];
    $pattern = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';        
     //(?=.*[A-Z]). min of 1 upper case // (?=.*[0-9]) min of 1 digit

    if (!preg_match($pattern, $txtpassword))
        {
                $valid=false;
                $errPatternPassword="password should be atleast 8 characters long"; 
                // with min one digit or uppcase letter
               }
               $txtpassword1=$_POST["txtpassword1"];
               if ($txtpassword!=$txtpassword1)
               {
                    $valid=false;
                    $errPatternPassword1="passwords don't match";
               }

    if ($valid == true)
    {
        $servername = "localhost";
        $username = "root";
        $password = "1234";
        $db = "mochi_pets";
        $conn = new mysqli($servername, $username, $password, $db);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $role = "customer";
        $sql = "INSERT INTO customer 
        (cust_name, cust_email, phone_no, city, username, password)
        VALUES 
        ('$txtname', '$txtemail', '$txtphone', '$txtcity', '$txtusername', '$txtpassword')";
        if ($conn->query($sql) === TRUE)
        {
            echo "Registration successful. You can now login.";
        }
        else
        {
            echo "Error: Could not register user";
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mochi Pets Store - Sign Up</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style_index.css">
</head>

<body>

<div class="header">
    <div class="logo">Mochi Pets Store</div>
    <div class="title">Welcome to Mochi Pets | Create Account</div>
    <div class="auth">
        <span><a href="login.php">Login</a></span> 
    </div>
</div>

<div class="content">
    <h2 style="text-align:center;">Sign Up</h2>
    <p style="text-align:center;">Create a customer account</p>
    <!-- FLEX CONTAINER -->
    <div style="
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
    ">

        <!-- FORM BOX -->
        <div style="
            width: 400px;
            background-color: #F5F5DC;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #D2B48C;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        ">
            <form method="post" action="signup.php">
                Name:
                <input type="text" name="txtname" required><br><br>
                Email:
                <input type="email" name="txtemail" required><br><br>
                Phone:
                <input type="text" name="txtphone" required><br><br>
                City:
                <select name="txtcity" required>
                    <option value="">-- Select City --</option>
                    <option value="Abu Dhabi">Abu Dhabi</option>
                    <option value="Dubai">Dubai</option>
                    <option value="Sharjah">Sharjah</option>
                    <option value="Ajman">Ajman</option>
                    <option value="Fujeirah">Fujeirah</option>
                    <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                    <option value="Umm Al Quwain">Umm Al Quwain</option>
                </select>
                <br><br>
                Password:
                <input type="password" name="txtpassword" required><br><br>
                Confirm Password:
                <input type="password" name="txtpassword1" required><br><br>
                <span class="feedback"><?php echo $errorMessage; ?></span><br><br>
                <input type="submit" value="Sign Up">
                <input type="reset" value="Reset">
            </form>
        </div>
    </div>
</div>

<div class="footer">
    &copy; 2026 Mochi Pets All Rights Reserved 
</div>

</body>
</html>