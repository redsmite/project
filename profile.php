<?php
	session_start();
	include'functions.php';
	//Get Profile Info
	require_once'connection.php';

	if(!isset($_GET['name'])){
		die('<div id="thanks-message"><p>This page doesn\'t exist.</p></div>');
	}

	if(isset($_GET['name'])){
		$name = $_GET['name'];
		$sql="SELECT userid,username,firstname,middlename,lastname,birthday,datecreated,email,website,location,usertypeid,imgpath,bio,is_show_email,gender FROM tbluser WHERE username='$name'";
		
		$result=$conn->query($sql);

		if($result->num_rows == 0){
			die('<div id="thanks-message"><p>This username doesn\'t exist.</p></div>');
		}

		$rows=$result->fetch_object();
		
		$id=$rows->userid;
		$user=$rows->username;
		$firstname=$rows->firstname;
		$lastname=$rows->lastname;
		$datecreated=$rows->datecreated;
		$email=$rows->email;
		$usertype=$rows->usertypeid;
		$gender=$rows->gender;
		$email_access=$rows->is_show_email;
		if(isset($rows->middlename)){
			$middlename=$rows->middlename;

		}else{
			$middlename='';
		}


		if(strtotime($rows->birthday)!=0){
			$birthday=date("M j, Y", strtotime($rows->birthday));

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


		if(isset($rows->imgpath)){
			$image=$rows->imgpath;
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
		<div class="profile-content">
			<div class="user-grid">
				<div class="left-grid">
					<div class="profile-pic-wrap">
						<?php
							if($image){
								$image= '<img src="'.$image.'"/>';
							}else if(!$image){
								$image='<img src="img/default.png" />';
							}
							echo $image;
						?>
					</div>
					<div class="user-header">
						<?php
							echo'<h1>			
							'.$user.'					
							</h1>
							<h3>Joined: '.time_elapsed_string($datecreated).'</h3>';
							if($usertype==1){
								echo'<p>User</p>';
							}else if ($usertype==2){
								echo'<p>Moderator</p>';
							}else if ($usertype==3){
								echo'<p>DB Admin</p>';
							}else if ($usertype==4){
								echo'<p>Site Admin</p>';
							}
						?>
					</div>
					<div class="friends">
						<h1>Friends</h1>
						<p>None</p>
					</div>
					<div class="dashboard">
						<?php
							if($_SESSION['name']==$_GET['name']){
								echo'<ul>
									<li><a href="inbox.php"><i class="fas fa-envelope"></i> Check Inbox</a></li>
									<li><a href="insertphoto.php"><i class="fas fa-camera"></i> Change Profile Picture</a></li>
									<li><a href="editinfo.php"><i class="fas fa-pen-square"></i> Edit Personal Info</a></li>
									<li><a href="accountsetting.php"><i class="fas fa-cog"></i> Account Settings</a></li>
									</ul>';
							}else{
								echo'<ul>
									<li><a href="adduser.php"><i class="fas fa-user-plus"></i> Add as friend</a></li>
									<li><a href="sendpm.php"><i class="fas fa-envelope"></i> Send Private Message</a></li>
									</ul>';
							}
						?>
					</div>
				</div>
				<div class="right-grid">
					<div class="user-info">
						<?php
							echo'<h1>'.$user.'\'s Personal Info</h1>
							<ul>';
							if($middlename==''){
								echo'<li>Name: '.$firstname.' '.$lastname.'</li>';
							}else{
								echo'<li>Name: '.$firstname.' "'.$middlename.'" '.$lastname.'</li>';
							}
							
							if($gender==1){
								echo'<li>Gender: Male </li>';
							} else if ($gender==2){
								echo'<li>Gender: Female </li>';
							} else{
								echo'<li>Gender: Non-binary </li>';
							}
							
							if($email_access==0){
								echo'<li>Email: <i class="fas fa-exclamation-circle"></i> Restricted by user</li>';
							}else{
								echo'<li>Email: '.$email.'</li>';
							}
							echo'<li>Birthday: '.$birthday.'</li>
							<li>Website: '.createlink(nl2br($website)).'</li>
							<li>Location: '.nl2br($location).'</li>
							</ul>';
						?>
						<div class="biography">
							<h1>About me</h1>
							<p>
							<?php
								echo nl2br($bio);
							?>
							</p>
						</div>
					</div>
					<div id="profile-comments">
						<h1>Comments</h1>
						<div>
						<form action="commentprocess.php" method="post" id="postcomment">
							<textarea name="comment" id="comment"></textarea>
							<input type="hidden" id="hidden" name="hidden" <?php echo 'value="'.$_SESSION['id'].'"'?> />
							<input type="hidden" id="hidden2" name="hidden2" <?php echo 'value="'.$_GET['name'].'"'?> />
						</div>
						<div>
							<input type="submit" name="comment-submit">
						</div>
							<?php
								$sql2="SELECT userid FROM tbluser WHERE username='$name'";
								$result2=$conn->query($sql2);
								$row=$result2->fetch_object();
								$rid=$row->userid;

								$sql3="SELECT commentid,username,comment,dateposted,imgpath FROM tblcomment
								LEFT JOIN tbluser
									ON tblcomment.userid = tbluser.userid
								WHERE receiver='$rid'
								ORDER BY commentid DESC
								LIMIT 10";

								$result3=$conn->query($sql3);
								while($rows2=$result3->fetch_object()){
									$Cid=$rows2->commentid;
									$Cuser=$rows2->username;
									$Ccomment=$rows2->comment;
									$dateposted=$rows2->dateposted;
									$Cimg=$rows2->imgpath;
									if($Cimg==''){
										$Cimg='img/default.png';
									}

									echo'<div class="comment-box">
									<div class="comment-header">
									<a href="profile.php?name='.$Cuser.'">
									<div class="comment-tn">
									<img src="'.$Cimg.'">
									</div>
									'.$Cuser.'</a>
									<small>'.time_elapsed_string($dateposted).'</small>
									</div>
									<div class="comment-body">
									<p>'.nl2br($Ccomment).'</p>
									</div>
									</div>';
								}
								
							?>
						</form>
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
	<script>
		modal();
		ajaxLogin();
	</script>
</body>
</html>