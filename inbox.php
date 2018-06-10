<?php
session_start();
include'functions.php';
include'connection.php';
user_access();
addSidebar();
setupCookie();
if(isset($_GET['name'])){
	$name=$_GET['name'];	
}else{
	die('This page doesn\'t exist.');
}
$id=$_SESSION['id'];
$update="UPDATE tblpm SET checked=1 WHERE receiverid='$id'";
$R_up=$conn->query($update);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
  	<link rel="stylesheet" href="css/fontawesome-all.css">
	<title></title>
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
							<li><a href="contact.php" class="current">CONTACT</a></li>
						</ul>
					</nav>
				</div>
				<div class="box3">
					<form action="search.php">
						<i class="fas fa-search"></i>
						<label>Search</label>
						<input type="text" id="search-text" placeholder="Search...">
					</form>
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
		<?php
if($name!=$_SESSION['name']){
	//Send PM
	echo'
		<div class="other-content">
			<p>Send <span id="highlight-text">'.$name.'</span> a private message</p>
			<div class="container">
				<div class="content-box">	
					<div class="edit-form">
						<center>
							<form action="#" method="post">
								<div>
									<label for="name">Subject</label><br>
									<input type="text" placeholder="No subject..." name="subject">
								</div>
								<div>
									<label for="message">Message</label><br>
									<textarea id="sendmsg" name="message" required></textarea>
								</div>
								<button type="submit" name="message-btn">Submit</button>
							</form>
						</center>	
					</div>
				</div>
			</div>
		</div>
	';
	if(isset($_POST['message-btn'])){
		$sql="SELECT userid FROM tbluser WHERE username='$name'";
		$result=$conn->query($sql);
		$row=$result->fetch_object();
		$Rid=$row->userid;

		$sender=$conn->real_escape_string($_SESSION['id']);
		$receiver=$conn->real_escape_string($Rid);
		$subject=$conn->real_escape_string($_POST['subject']);
		$message=$conn->real_escape_string($_POST['message']);
		$timestamp='NOW()';
		
		$sql2="INSERT INTO tblpm (senderid,receiverid,subject,message,pmdate) VALUES('$sender','$receiver','$subject','$message',$timestamp)";
		$result=$conn->query($sql2);
		echo'Message Send';
	}

} else{
	$id=$_SESSION['id'];
	$sql="SELECT username,imgpath,subject,message,pmdate FROM tblpm
	LEFT JOIN tbluser
		ON senderid=userid
	WHERE receiverid='$id'
	ORDER BY pmid DESC";
	$result=$conn->query($sql);
	while($row=$result->fetch_object()){
		$Sname=$row->username;
		$subject=$row->subject;
		$message=$row->message;
		$imgpath=$row->imgpath;
		$date=$row->pmdate;
		if($imgpath==''){
			$imgpath='img/default.png';
		}
		echo '<div class="inbox-box">
		<a class="sender" href="profile.php?name='.$Sname.'">
			<div class="comment-tn">
				<img src="'.$imgpath.'">
			</div>'.$Sname.'</a><br>
		Subject: '.$subject.'<br>
		<div class="inbox-div"> <p class="inbxmsg">'.nl2br($message).'</p></div>
		<a class="reply" href="inbox.php?name='.$Sname.'">Reply</a><span class="inbox-date">'.time_elapsed_string($date).'</span>
		</div>';

	}
}
		?>
	</div>
	<!-- Footer -->
		<footer class="main-footer">
			<div class="container">
				<p>Copyright &copy; <span id="company"></span> | 2018</p>
			</div>
		</footer>
	<!-- End of Container -->
	</div>
	<script src="js/main.js"></script>
	<script>
		modal();
		ajaxLogin();
	</script>
</body>
</html>