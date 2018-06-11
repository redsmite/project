<?php
session_start();
include'connection.php';
include'functions.php';
addSidebar();
setupCookie();
user_access();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
  	<link rel="stylesheet" href="css/fontawesome-all.css">
	<title>Reloading...</title>
</head>
<body>
	<div class="main-container">
	<!-- Header -->
		<header id="main-header">
			<div class="grid-header">
				<div class="box1">
					<h1 id="header-text"><a href="index.php"><span id="first-text"></span><span id="second-text"></span></a></h1>
				</div>
				<div class="box2">
					<nav class="main-nav">
						<ul class="header-list">
							<li><a href="index.php">HOME</a></li>
							<li><a href="about.php">ABOUT</a></li>
							<li><a href="services.php">SERVICES</a></li>
							<li><a href="contact.php">CONTACT</a></li>
						</ul>
					</nav>
				</div>
				<div class="box3">	
					<?php
						search_function();
					?>
				</div>
			</div>
		</header>
	<!-- Sub Header -->
		<div class="subheader">
			<div class="subgrid">
				<div class="svg">
					<p class="open-slide" onclick="openSlideMenu()">
						<svg width="30" height="30">
							<path d="M0,5 30,5" stroke="#fafafa" stroke-width="5"/>
							<path d="M0,14 30,14" stroke="#fafafa" stroke-width="5"/>
							<path d="M0,23 30,23" stroke="#fafafa" stroke-width="5"/>	
						</svg>
					</p>
				</div>
				<div class="profile-grid">
					<?php
						session_button()
					?>
				</div>
			</div>
		</div>
	<!-- Main Content -->
		<div class="other-content">
			<h1><a class="btp" href="profile.php?name=<?php echo $_SESSION['name'] ?>">Go back to your profile</a></h1>
<?php
$id=$_SESSION['id'];
$sql="SELECT notifid,username,receiverid,notif,notifdate,notiftype FROM tblnotif
LEFT JOIN tbluser
ON tblnotif.userid=tbluser.userid
WHERE receiverid='$id' 
ORDER BY notifid DESC";

$result=$conn->query($sql);
$count=$result->num_rows;
echo '<h4>Notifications('.$count.')</h4>
<ul id="notiflist">';
while($rows=$result->fetch_object())
{
$nid=$rows->notifid;
$uname=$rows->username;
$rid=$rows->receiverid;
$notif=$rows->notif;
$type=$rows->notiftype;
$date=time_elapsed_string($rows->notifdate);

if($type==1){

	echo'<li><i class="far fa-comment-dots"></i> <a href="profile.php?name='.$uname.'">'.$uname.'</a> '.$notif.' '.$date.'</li>';
}
}

echo '</ul>';
?>
</div>
<!-- Footer -->
		<footer class="main-footer">
			<div class="container">
				<p>Copyright &copy; <span id="company"></span> | 2018</p>
			</div>
		</footer>
	</div>
	<!-- End of Container -->
	</div>
	<script src="js/main.js"></script>
	<script>
		modal();
		ajaxLogin();
	</script>
</body>
</html>