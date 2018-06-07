<?php
	session_start();
	include'functions.php';
	user_access();
	//Get Profile Info
	require_once'connection.php';
	
	if(isset($_SESSION['id'])){
		$id = $_SESSION['id'];
		$sql="SELECT imgpath FROM tbluser WHERE userid='$id'";
		
		$result=$conn->query($sql);

		if($result->num_rows == 0){
			die('<div id="thanks-message"><p>This username doesn\'t exist.</p></div>');
		}

		$rows=$result->fetch_object();
		
		$image=$rows->imgpath;
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
			<h1><i class="fas fa-camera"></i> Profile Picture</h1>
			<div class="edit-form">
				<center>
							<p>*Please don't post nudes or offensive photos</p> 
					<div class="profile-pic-wrap">
						<?php
							if($image){
								$fimage= '<img src="'.$image.'"/>';
							}else if(!$image){
								$fimage='<img src="img/default.png" />';
							}
							echo $fimage;
						?>
					</div>

					<form action="insertphoto.php" method="POST" enctype="multipart/form-data">
						
						<div>Select Picture:
							<br>
							<input type="file" value="Choose File" name="img"/>
						</div>
						<div>
							<button type="submit" name="submit"><i class="fas fa-upload"></i> Upload</button><br><br> <button type="submit" name="remove"><i class="fas fa-trash-alt"></i> Remove</button>
						</div>
						<div id="error-message2">
						<?php
							$id=$_SESSION['id'];

							if(isset($_POST['remove'])){
									$sql = "UPDATE tbluser SET imgname='',imgtype='',imgpath='' WHERE userid='$id'";  
									$conn->query($sql);
									echo("<script>window.location.href = 'profile.php?name=".$_SESSION['name']."';</script>");	
							}




							//upload photo
							if(isset($_POST['submit'])){
								$error='';
								
								if(!$_FILES['img']['tmp_name']){
									echo'<div id="error-message2"><i class="fas fa-exclamation-circle"></i>File is empty. Select an image to upload.</div>';
								}else{

								$filetemp=$_FILES['img']['tmp_name'];
								$filename=$_FILES['img']['name'];
								$filetype=$_FILES['img']['type'];
								$filepath="upload/".$filename;
								if($filetype != "image/jpg" && $filetype != "image/png" && $filetype != "image/jpeg"
								&& $filetype != "image/gif") {
								     echo'<div id="error-message2"><i class="fas fa-exclamation-circle"></i>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>';
								 	$error=1;
								}

								if (filesize($filetemp) > 500000) {
								    echo'<div id="error-message2"><i class="fas fa-exclamation-circle"></i>Sorry, your file is too large. <strong>Maximum: 500kb.</strong></div>';
								    $error=1;
								}


								if($error==''){
									move_uploaded_file($filetemp, $filepath);
									$filename=$conn->real_escape_string($filename);
									$filetype=$conn->real_escape_string($filetype);
									$filepath=$conn->real_escape_string($filepath);
									$sql="UPDATE tbluser SET imgname='$filename',imgtype='$filetype',imgpath='$filepath' WHERE userid='$id'";
									$result=$conn->query($sql) or die($conn->error());

									if($result){
										echo("<script>window.location.href = 'profile.php?name=".$_SESSION['name']."';</script>");
									}
								}
								}
							}
							?>
							</div>
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