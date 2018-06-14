<?php
session_start();
include'functions.php';
addSidebar();
setupCookie();
updateStatus();
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
			<h1><a class="btp" href="profile.php?name=<?php echo $name ?>">Back to <?php echo $name ?>'s Profile</a></h1>
			<div class="wrap-center">
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
	$textline1 = $name."'s Friends (<b>$rows</b>)";
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





$sql="SELECT user1,user2,friendsince,username,imgpath,lastonline FROM tblfriend
LEFT JOIN tbluser
	ON userid=user1 or userid=user2
 WHERE (user1='$id' or user2='$id') AND accepted=2 AND userid!='$id'
 ORDER BY lastonline DESC $limit";

$result=$conn->query($sql);
while($rows=$result->fetch_object()){
$user1=$rows->user1;
$user2=$rows->user2;
$since=date("M j, Y", strtotime($rows->friendsince));
$online=$rows->lastonline;
$time=time();


$username=$rows->username;
$imgpath=$rows->imgpath;

	echo'<div class="fr-div">
	<div class="showfr-tn">
			<a href="profile.php?name='.$username.'"><img src="'.$imgpath.'"></a></div>
		<p><a href="profile.php?name='.$username.'">'.$username.'</a></p>
		<p>Friend Since: '.$since.'</p>';
		if($time-strtotime($online)< 300){
			echo'<h5><font color="green">Online</font></h5>';
		} else{
			echo'<p>Last Online: '.time_elapsed_string($online).'</p>';
		}

		echo'</div>';

}

	mysqli_close($conn);
?>
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
		modal();
		ajaxLogin();
	</script>
</body>
</html>