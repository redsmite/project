<?php
	session_start();
	include'functions.php';
	user_access();
	updateStatus();
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
	chattab();
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
	<!-- Main Content -->
		<div class="other-content">
			<h1><i class="fas fa-camera"></i> Profile Picture</h1>
			<div class="edit-form">
				<center>
							<p>*Please don't post nudes or offensive pictures</p> 
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

					<form id="profile-pic-form" method="POST" enctype="multipart/form-data">
						
						<progress id="progressBar" value="0" max="100"></progress>

						<div>Select Picture:
							<br>
							<input type="file" name="photos[]" id="img" value="Choose Image" name="img"/>
						</div>
						<div>
							<button type="submit" onclick="
							addProfilePhoto()" id="submit">
								<i class="fas fa-upload"></i> Upload
							</button><br><br> 

							<button type="
							submit" id="remove" onclick="
							removeProfilePhoto()">
								<i class="fas fa-trash-alt"></i> Remove
							</button>
						</div>
						<div id="error-message2">
							</div>
					</form>
				</center>
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
	</script>
</body>
</html>