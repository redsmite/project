<?php
session_start();
include'functions.php';
require_once'connection.php';
adminpanelAccess();
?>
<h1>Hello <?php echo $_SESSION['name']?></h1>
<h3>Admin Panel</h3>
<a href="profile.php?name=<?php echo $_SESSION['name']?>"><p>Go to your profile</p></a>
<a href="logout.php"><p>Logout</p></a>