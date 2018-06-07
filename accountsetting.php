<?php
	session_start();
	include'functions.php';
	user_access();
	//Get Profile Info
	require_once'connection.php';
	
	if(isset($_SESSION['id'])){
		$id = $_SESSION['id'];
		$sql="SELECT userid,username,password,lastupdate FROM tbluser WHERE userid='$id'";
		
		$result=$conn->query($sql);

		if($result->num_rows == 0){
			die('<div id="thanks-message"><p>This username doesn\'t exist.</p></div>');
		}

		$rows=$result->fetch_object();
		
		$id=$rows->userid;
		$username=$rows->username;
		$password=$rows->password;
		$lastupdate=$rows->lastupdate;
		$timestamp = time();
	}
	//End of Get Profile Info
	addSidebar();
	addLogin();
	setupCookie();
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
			<h1><i class="fas fa-cog"></i> Account Settings</h1>
			<div class="edit-form">
				<center>
				<form action="" id="edit-username" method="post">
					<div>
						<label for="">New Username</label><br>
						<p>*Warning: Can only change your username once per month</p>
						<input type="text" <?php echo 'value="'.$username.'"'?> required id="edit-name" name="edit-name" placeholder="Enter New Username...">
					</div>
					<div>
						<button type="submit" name="username-submit" id="username-submit">Submit</button>
					</div>
					<?php
						if(isset($_POST['username-submit'])){
							$error='';

							$lastupdate=strtotime($lastupdate);
							$diff=time()-$lastupdate;
							$month=60*60*24*28;
							if($diff<$month){
								echo'<div id="error-message2"><i class="fas fa-exclamation-circle"></i> You have recently changed your username. Please read above.</div>';
							}else{

							if(strlen($_POST['edit-name']) > 20)
							{
							    echo'<div id="error-message2"><i class="fas fa-exclamation-circle"></i>Username must not be longer than 20 characters</div>';
							    $error=1;
							}

							if($username==$_POST['edit-name']){
								echo'<div id="error-message2"><i class="fas fa-exclamation-circle"></i> No changes made.</div>';
							    $error=1;	
							}

							if (preg_match('/[^A-Z]/i',$_POST['edit-name']))
							{
							     echo'<div id="error-message2"><i class="fas fa-exclamation-circle"></i>Username must not contain special characters or spaces.</div>';
							     $error=1;
							}
							if($error==''){
								$username=$_POST['edit-name'];
								$_SESSION['name']=$username;
								$sql="UPDATE tbluser SET username='$username', lastupdate=$timestamp WHERE userid='$id'";
								$conn->query($sql) or die(mysqli_error($conn));
								echo("<script>window.location.href = 'profile.php?name=".$_SESSION['name']."';</script>");
							}
							}
						}
					?>
				</form>
				</center>
			</div>
			<div class="edit-form">
				<center>
				<form action="" id="edit-password" method="post">
					<div>
						<label for="">Old Password</label><br>
						<input type="password" required id="edit-oldpassword" name="edit-oldpassword" placeholder="Enter Old Password...">
					</div>
					<div>
						<label for="">New Password</label><br>
						<input type="password" required id="edit-newpassword" name="edit-newpassword" placeholder="Enter New Password...">
					</div>
					<div>
						<label for="">Re-type New Password</label><br>
						<input type="password" required id="edit-retype" name="edit-retype" placeholder="Retype New Password...">
					</div>
					<div>
						<button type="submit" name="password-submit" id="password-submit">Submit</button>
					</div>
					<?php
						if(isset($_POST['password-submit'])){
							$old=md5($_POST['edit-oldpassword']);
							$new=$_POST['edit-newpassword'];
							$new2=$_POST['edit-retype'];
							if($password!=$old){
								 echo'<div id="error-message2"><i class="fas fa-exclamation-circle"></i> Password doesn\'t match with old password.</div>';
							}else{
								if($new!=$new2){
									echo'<div id="error-message2"><i class="fas fa-exclamation-circle"></i>New Password doesn\'t match.</div>';
								}else{
									$new=md5($new);
									$sql="UPDATE tbluser SET password='$new' WHERE userid='$id'";
									$conn->query($sql) or die($conn->error);
									echo("<script>window.location.href = 'profile.php?name=".$_SESSION['name']."';</script>");
								}
							}
						}
					?>
				</form>
				</center>
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
	<script>
		ajaxLogin();
	</script>
</body>
</html>