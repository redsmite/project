<?php
session_start();
include'connection.php';
include'functions.php';
user_access();

if($_GET['this']!=$_SESSION['id']){
	die('This page doesn\'t exist');
}
addSidebar();
addLogin();
setupCookie();
	
$id= $_GET['id'];
$name= $_GET['name'];

$sql="SELECT comment FROM tblcomment WHERE commentid='$id'";
if($result=$conn->query($sql)){
$row=$result->fetch_object();
$comment=$row->comment;
}else{	
	die('This page doesn\'t exist');
}
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
<body>
	<div class="container">
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
	<!-- Edit Form -->
		<div class="other-content">
			<h1>Edit Comment</h1>
			<div class="container">
				<div class="content-box">
					<div class="editcmt-form">
						<p>Edit Comment</p>
						<center>
							<form action="commentprocess.php" method="POST">
								<textarea id="cmt-val" name="comment"><?php echo nl2br($comment); ?></textarea>
								<br>
								<input type="hidden" name="hidden" <?php echo 'value="'.$id.'"'?> />

								<input type="hidden" name="hidden2" <?php echo 'value="'.$name.'"'?> />
								
								<input type="submit" value="Ok" name="submit"> <input type="submit" value="Cancel" name="back">
							</form>
							<?php
								
							?>
						</center>	
					</div>
				</div>
			</div>
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
</body>
</html>