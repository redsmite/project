<?php
	session_start();
	include'functions.php';
	addSidebar();
	setupCookie();
	user_access();
	//Get Profile Info
	require_once'connection.php';
	
	if(isset($_SESSION['id'])){
		$id = $_SESSION['id'];
		$sql="SELECT userid,firstname,middlename,lastname,birthday,website,location,usertypeid,bio,is_show_email,gender FROM tbluser WHERE userid='$id'";
		
		$result=$conn->query($sql);

		if($result->num_rows == 0){
			die('<div id="thanks-message"><p>This username doesn\'t exist.</p></div>');
		}

		$rows=$result->fetch_object();
		
		$id=$rows->userid;
		$firstname=$rows->firstname;
		$lastname=$rows->lastname;
		$usertype=$rows->usertypeid;
		$email_access=$rows->is_show_email;
		$gender=$rows->gender;

		if(isset($rows->middlename)){
			$middlename=$rows->middlename;

		}else{
			$middlename='';
		}


		if(isset($rows->birthday)){
			$birthday=$rows->birthday;

		}else{
			$birthday='';
		}


		if(isset($rows->website)){
			$website=$rows->website;

		}else{
			$website='';
		}


		if(isset($rows->location)){
			$location=$rows->location;

		}else{
			$location='';
		}


		if(isset($rows->bio)){
			$bio=$rows->bio;

		}else{
			$bio='';
		}
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
			<h1><i class="fas fa-pen-square"></i> Personal Info</h1>
			<div class="edit-form">
				<center>
				<form action="editinfoprocess.php"id="edit-form" method="post">
					<div>
						<label for="">First Name</label><br>
						<input type="text"  <?php echo 'value="'.$firstname.'"'?> id="edit-first" name="edit-first"placeholder="Enter First Name...">
					</div>
					<div>
						<label for="">Last Name</label><br>
						<input type="text" <?php echo 'value="'.$lastname.'"'?> id="edit-last" name="edit-last" placeholder="Enter Last Name...">
					</div>
					<div>
						<label for="">Nickname</label><br>
						<input type="text" <?php echo 'value="'.$middlename.'"'?> id="edit-middle" name="edit-middle"placeholder="Enter Nickname...">
					</div>
					<div>
						<label for="">Birthday</label><br>
						<input type="date" <?php echo 'value="'.$birthday.'"'?> id="edit-birthday" name="edit-birthday">
					</div>
					<div>
						<label for="">Website</label><br>
						<textarea id="edit-website" name="edit-website"><?php echo $website?></textarea>
					</div>
					<div>
						<label for="">Location</label><br>
						<textarea id="edit-location" name="edit-location"><?php echo $location?></textarea>
						<br><br>
					</div>
					<div id="gender-box">

						<?php
						if($gender==1){
							echo'<label for="">Gender</label><br><input type="radio" checked required name="gender" id="gender" value="1"> Male
							<input type="radio" name="gender" id="gender" value="2"> Female
							<input type="radio" name="gender" id="gender" value="3"> Non-Binary';
						}else if ($gender==2){
							echo'<label for="">Gender</label><br><input type="radio" required name="gender" id="gender" value="1"> Male
								<input type="radio"  checked name="gender" id="gender" value="2"> Female
								<input type="radio" name="gender" id="gender" value="3"> Non-Binary';
						}else{
							echo'<label for="">Gender</label><br><input type="radio" required name="gender" id="gender" value="1"> Male
								<input type="radio" name="gender" id="gender" value="2"> Female
								<input type="radio" name="gender" id="gender" checked value="3"> Non-Binary';
						}
						?>
					</div>
					<br>
					<div>
						<label for="">About me</label><br>
						<textarea id="edit-bio" name="edit-bio" placeholder="Tell us about yourself..."><?php echo $bio?></textarea>
					</div>
					<div>

						<label for="">Show email?</label>
						<?php
							if($email_access==1){
								echo'<input type="checkbox" id="privacy" checked value="1" name="privacy">';
							}else{
								echo'<input type="checkbox" value="1" id="privacy"name="privacy">';
							}
						?>
						
					</div>
						<br><br>
					<div>
						<button type="submit" name="edit-button" id="edit-button">Submit</button>
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