<?php
session_start();
include'functions.php';
require_once'connection.php';
$name=$_GET['name'];
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
			<h1><a class="btp" href="profile.php?name=<?php echo $name ?>">Back to <?php echo $name ?>'s Profile</a></h1>
<?php

$sql2="SELECT userid FROM tbluser WHERE username='$name'";
$result2=$conn->query($sql2);
$row=$result2->fetch_object();
$rid=$row->userid;

$sql3="SELECT commentid,tblcomment.userid,username,comment,dateposted,imgpath,modified FROM tblcomment
LEFT JOIN tbluser
	ON tblcomment.userid = tbluser.userid
WHERE receiver='$rid'
ORDER BY commentid DESC";


$result3=$conn->query($sql3);
$count=$result3->num_rows;

echo '<h4>Comments('.$count.')</h4>';
while($rows2=$result3->fetch_object()){
	$Cid=$rows2->commentid;
	$Cuid=$rows2->userid;
	$Cuser=$rows2->username;
	$Ccomment=$rows2->comment;
	$dateposted=$rows2->dateposted;
	$Cimg=$rows2->imgpath;
	$modified=$rows2->modified;
	if($Cimg==''){
		$Cimg='img/default.png';
	}
	if($modified==0){
		$modified='';
	}else{
		$modified='<i>Modified: '.time_elapsed_string($modified).'</i>';
	}

	echo'<div class="comment-box">
	<div class="comment-header">
	<a class="cm-user" href="profile.php?name='.$Cuser.'">
	<div class="comment-tn">
	<img src="'.$Cimg.'">
	</div>
	'.$Cuser.'</a>
	<small>'.time_elapsed_string($dateposted).'</small>
	</div>
	<div class="comment-body">
	<p>'.nl2br($Ccomment).'
		<p class="modified">'.$modified.'</p>';
//Delete / Edit Comment
if($name==$_SESSION['name']||$Cuid==$_SESSION['id']){
echo'
<form align="right" action="commentprocess.php" method="post">
<input type="hidden" name="hidden4" value="'.$_GET["name"].'" />
<input type="hidden" name="hidden3" value="'.$Cid.'">'; 
if($Cuid==$_SESSION['id']){
	echo'<a href="editcomment.php?id='.$Cid.'&name='.$name.'&this='.$Cuid.'">edit</a>';
}
echo'	<input type="submit" value="delete" name="deletebtn">   

</form>';

}				


		

		echo'</p>
		</div>
		</div>';
	}	
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