<?php
	session_start();
	include'functions.php';
	user_access();
	//Get Profile Info
	require_once'connection.php';
	
	if(isset($_SESSION['id'])){
		$id = $_SESSION['id'];
		$sql="SELECT image FROM tbluser WHERE userid='$id'";
		
		$result=$conn->query($sql);

		if($result->num_rows == 0){
			die('<div id="thanks-message"><p>This username doesn\'t exist.</p></div>');
		}

		$rows=$result->fetch_object();
		
		$image=$rows->image;
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
			<h1>Edit Profile Photo</h1>
			<div class="edit-form">
				<center>
					<div class="profile-pic-wrap">
						<?php
							if($image){
								$image= '<img src="data:image/jpeg;base64,'.base64_encode( $image ).'"/>';
							}else if(!$image){
								$image='<img src="img/default.png" />';
							}
							echo $image;
						?>
					</div>

					<form action="insertphoto.php" method="POST" enctype="multipart/form-data">
						
						<div>File:
							<input type="file" name="image">
							<p>*Please don't post nudes or offensive photos</p> 
						</div>
						<div>
							<input type="submit" name="submit" value ="upload"> <input type="submit" name="remove" value ="remove">
						</div>
						<div id="error-message2">
						<?php
							$id=$_SESSION['id'];

							if(isset($_POST['remove'])){
									$sql = "UPDATE tbluser SET image='' WHERE userid='$id'";  
									$conn->query($sql);
									echo("<script>window.location.href = 'profile.php?name=".$_SESSION['name']."';</script>");	
							}




							//upload photo
							if(isset($_POST['submit'])){

							//check if the uploaded file is empty
							if($_FILES["image"]["tmp_name"]==""){
								echo '<i class="fas fa-exclamation-circle"></i>File is empty. Select an image to upload';
							}else{
							$target_dir = "uploads/";
							$target_file = $target_dir . basename($_FILES["image"]["name"]);
							$uploadOk = 1;
							$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
							// Check if image file is a actual image or fake image
							if(isset($_POST["submit"])) {
							    $check = getimagesize($_FILES["image"]["tmp_name"]);
							    if($check !== false) {
							        echo "<i class='fas fa-exclamation-circle'></i>File is an image - " . $check["mime"] . ".<br>";
							        $uploadOk = 1;
							    } else {
							        echo "<i class='fas fa-exclamation-circle'></i>File is not an image.<br>";
							        $uploadOk = 0;
							    }
							}


							// Check if file already exists
							if (file_exists($target_file)) {
							    echo "<i class='fas fa-exclamation-circle'></i>Sorry, file already exists.<br>";
							    $uploadOk = 0;
							}

							// Allow certain file formats
							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
							&& $imageFileType != "gif" ) {
							    echo "<i class='fas fa-exclamation-circle'></i>Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
							    $uploadOk = 0;
							}

							// Check file size
							if ($_FILES["image"]["size"] > 500000) {
							    echo "<i class='fas fa-exclamation-circle'></i>Sorry, your file is too large. <strong>Maximum: 500kb.</strong><br>";
							    $uploadOk = 0;
							}

							// Check if $uploadOk is set to 0 by an error
							if ($uploadOk == 0) {
							    echo "<i class=fas fa-exclamation-circle'></i>Sorry, your file was not uploaded.";
							// if everything is ok, try to upload file
							} else {
							    //if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
							        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
									$sql = "UPDATE tbluser SET image='$image' WHERE userid='$id'";  
									$conn->query($sql);
									echo("<script>window.location.href = 'profile.php?name=".$_SESSION['name']."';</script>");	
							   /* } else {
							        echo "Sorry, there was an error uploading your file.";
							    }*/
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