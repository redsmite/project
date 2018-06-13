<?php
session_start();
include'functions.php';
addSidebar();
setupCookie();
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
					<?php
						search_function();
					?>
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
// Show friends
$sql="SELECT userid FROM tbluser WHERE username='$name'";
$result=$conn->query($sql);
$rows=$result->fetch_object();
$id=$rows->userid;

$sql="SELECT friendid FROM tblfriend
LEFT JOIN tbluser
	ON userid=user1 or userid=user2
 WHERE (user1='$id' or user2='$id') AND accepted=2 AND userid!='$id'";

$result=$conn->query($sql);
$rows=$result->num_rows;
$page_rows = 8;
	$last = ceil($rows/$page_rows);
	if($last < 1){
		$last = 1;
	}
	$pagenum = 1;
	if(isset($_GET['pn'])){
		$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
	}
	if ($pagenum < 1) { 
	    $pagenum = 1; 
	} else if ($pagenum > $last) { 
	    $pagenum = $last; 
	}
	$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
	$textline1 = "Friends (<b>$rows</b>)";
	$textline2 = "Page <b>$pagenum</b> of <b>$last</b>";
	$paginationCtrls = '';
	if($last != 1){
		if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?name='.$name.'&pn='.$previous.'">Previous</a> &nbsp; &nbsp; ';
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?name='.$name.'&pn='.$i.'">'.$i.'</a> &nbsp; ';
				}
	   		}
    	}
	    $paginationCtrls .= ''.$pagenum.' &nbsp; ';
	    for($i = $pagenum+1; $i <= $last; $i++){
			$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?name='.$name.'&pn='.$i.'">'.$i.'</a> &nbsp; ';
			if($i >= $pagenum+4){
				break;
			}
		}
		if ($pagenum != $last) {
	        $next = $pagenum + 1;
	        $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?name='.$name.'&pn='.$next.'">Next</a> ';
	    }
	}
	echo'<h2>  '.$textline1.'</h2>
	<p>  '.$textline2.' </p>
	<div id="pagination_controls"> '.$paginationCtrls.'</div>';





$sql="SELECT user1,user2,friendsince,username,imgpath FROM tblfriend
LEFT JOIN tbluser
	ON userid=user1 or userid=user2
 WHERE (user1='$id' or user2='$id') AND accepted=2 AND userid!='$id'
 ORDER BY friendid DESC $limit";

$result=$conn->query($sql);
while($rows=$result->fetch_object()){
$user1=$rows->user1;
$user2=$rows->user2;
$since=date("M j, Y", strtotime($rows->friendsince));


$username=$rows->username;
$imgpath=$rows->imgpath;

	echo'<div class="fr-div">
	<div class="showfr-tn">
			<a href="profile.php?name='.$username.'"><img src="'.$imgpath.'"></a></div>
		<p><a href="profile.php?name='.$username.'">'.$username.'</a></p>
		<p>Friend Since: '.$since.'</p>
		</div>';

}

	mysqli_close($conn);
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