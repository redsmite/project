<?php
	session_start();
	include'functions.php';
	require_once'connection.php';
	addSidebar();
	addLogin();
	setupCookie();
	updateStatus();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  	<link rel="stylesheet" href="css/style.css">
  	<link rel="stylesheet" href="css/fontawesome-all.css">
	<title><?php companytitle()?></title>
</head>
<body>
	<div class="main-container">
	<!-- Header -->
	<?php
		addheader();
	?>
	<!-- Showcase -->
		<div class="showcase">
			<div class="container">
				<div class="showcase-content">
					<div class="showcase-container">
						<h1>Welcome to RainbowDream</h1>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos suscipit, quis vel inventore, autem possimus a! Debitis ipsa, nobis aperiam.</p><br>
						<p><a href="about.php">Read More</a></p>
					</div>
				</div>
			</div>
		</div>
	<!-- Content -->
		<div class="main-content">
			<div class="main-content-grid">
				<div class="announcement">
					<h2>Announcements</h2>
					<p>None...</p>
				</div>
				<div class="content-body">
					<h2>Recent Discussions</h2>
					<p>None...</p>
				</div>
				<div class="sidebar">
					<h3>Newest Users</h3>
<?php
//fetch users
	$sql="SELECT username,imgpath,datecreated FROM tbluser ORDER BY userid DESC LIMIT 5";
	$result=$conn->query($sql);
	while($row=$result->fetch_object()){

		$name=$row->username;
		$img=$row->imgpath;
		if(!$img){
			$img='img/default.png';
		}
		$date = date("M j, Y", strtotime($row->datecreated));
		$time = date("g:i:s A", strtotime($row->datecreated));

		echo'
		<div>
		<ul class="drop-ul"><li><a href="profile.php?name='.$name.'"><div class="drop-tn"><img src="'.$img.'"></div><p>'.$name.'</a></p><small>Joined: '.$date.'</small><br>
			<small>'.$time.'</small>
		<li></ul>
		</div>';
	}

?>
				</div>
				<div class="sidebar2">
					<h3>Popular Users</h3>
<?php
//fetch users
	$sql="SELECT username,imgpath,datecreated FROM tbluser ORDER BY profileviews DESC LIMIT 5";
	$result=$conn->query($sql);
	while($row=$result->fetch_object()){

		$name=$row->username;
		$img=$row->imgpath;
		if(!$img){
			$img='img/default.png';
		}
		$date = date("M j, Y", strtotime($row->datecreated));
		$time = date("g:i:s A", strtotime($row->datecreated));

		echo'
		<div>
		<ul class="drop-ul"><li><a href="profile.php?name='.$name.'"><div class="drop-tn"><img src="'.$img.'"></div><p>'.$name.'</a></p><small>Joined: '.$date.'</small><br>
			<small>'.$time.'</small>
		<li></ul>
		</div>';
	}

?>		
				</div>
			</div>
		</div>
	<!-- Footer -->
		<?php
			addfooter();
		?>
	<!-- End of Container -->
	</div>
	<script src="js/main.js"></script>
	<script>
		modal();
		ajaxLogin();
	</script>
</body>
</html>