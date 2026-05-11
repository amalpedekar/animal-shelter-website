<?php
session_start();
session_destroy();

header("Location: index.php"); // go back to home page
exit();
?>