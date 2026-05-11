<?php
session_start();


if (!isset($_SESSION["username"]) || $_SESSION["role"] != "staff") {
    header("Location: login.php");
    exit();
}


$conn = new mysqli("localhost", "root", "1234", "pet_store");


if ($conn->connect_error) {
    die("Connection failed");
}


/* UPDATE APPLICATION */
if (isset($_POST['update'])) {


    $app_id = $_POST['app_ID'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];


    $conn->query("
        UPDATE adoption_application
        SET status='$status', remarks='$remarks'
        WHERE app_id='$app_id'
    ");
}


/* FETCH APPLICATIONS (with pet details like my_applications.php) */
$sql = "
SELECT a.*,
       c.cat_name, c.cat_breed, c.image AS cat_image,
       d.dog_name, d.dog_breed, d.image AS dog_image
FROM adoption_application a
LEFT JOIN cat c ON a.pet_type='cat' AND a.pet_id=c.cat_ID
LEFT JOIN dog d ON a.pet_type='dog' AND a.pet_id=d.dog_ID
ORDER BY a.app_ID DESC
";


$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Applications</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mycss.css/style_manage_applications.css">
</head>


<body>


<div class="header">
    <div class="logo">Mochi Pets Store</div>
    <div class="title">Pet Application Management</div>
    <div class="auth">
        <span>Staff Panel</span> |
        <a href="login.php">Logout</a>
    </div>
</div>


<div class="menu">
    <a href="admin.php">Dashboard</a>


    <div class="menu-item">
        Manage Pets
        <div class="dropdown">
            <a href="manage_cats.php">Cats</a>
            <a href="manage_dogs.php">Dogs</a>
        </div>
    </div>


    <a href="manage_applications.php" class="currentpage">Manage Applications</a>
</div>


<div class="content">


    <h2>Adoption Applications</h2>


    <div class="table-container">


        <table>


        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Pet</th>
            <th>Details</th>
            <th>Status</th>
            <th>Remarks</th>
            <th>Action</th>
        </tr>


        <?php while($row = $result->fetch_assoc()) {


            $isCat = ($row['pet_type'] == "cat");


            $petName = $isCat ? $row['cat_name'] : $row['dog_name'];
            $breed   = $isCat ? $row['cat_breed'] : $row['dog_breed'];
            $image   = $isCat ? "images/cats/".$row['cat_image'] : "images/dogs/".$row['dog_image'];


        ?>


        <tr>


        <form method="POST">


            <td>
                <?php echo $row['app_ID']; ?>
                <input type="hidden" name="app_ID" value="<?php echo $row['app_ID']; ?>">
            </td>


            <td>
                <?php echo $row['first_name'] . " " . $row['last_name']; ?>
                <br>
                <small><?php echo $row['email']; ?></small>
            </td>


            <td>
                <img src="<?php echo $image; ?>" width="60"><br>
                <?php echo $petName; ?>
            </td>


            <td>
                <?php echo $breed; ?><br>
                <?php echo $row['city']; ?>, <?php echo $row['country']; ?>
            </td>


            <td>
                <select name="status">
                    <?php if($row['status'] == "Withdrawal Requested") { ?>
                        <option value="Withdrawn">Approve Withdrawal</option>
                        <option value="Pending">Reject Withdrawal</option>
                    <?php } else { ?>
                        <option value="Pending" <?php if($row['status']=="Pending") echo "selected"; ?>>Pending</option>
                        <option value="Approved" <?php if($row['status']=="Approved") echo "selected"; ?>>Approved</option>
                        <option value="Rejected" <?php if($row['status']=="Rejected") echo "selected"; ?>>Rejected</option>
                    <?php } ?>
                </select>
            </td>


            <td>
                <input type="text" name="remarks" value="<?php echo $row['remarks']; ?>">
            </td>


            <td>
                <button type="submit" name="update">Update</button>
            </td>


        </form>


        </tr>


        <?php } ?>


        </table>


    </div>


</div>


<div class="footer">
    &copy; 2026 Mochi Pets Store. All Rights Reserved.
</div>


</body>
</html>
