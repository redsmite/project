<?php
session_start();
include'connection.php';
include'functions.php';
addSidebar();
setupCookie();
user_access();
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
			<h1><a class="btp" href="profile.php?name=<?php echo $_SESSION['name'] ?>">Go back to your profile</a></h1>
<?php
$id=$_SESSION['id'];
$sql="SELECT notifid FROM tblnotif WHERE receiverid='$id'";
$result=$conn->query($sql);
$rows=$result->num_rows;
$page_rows = 10;
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
	$textline1 = "Notifications (<b>$rows</b>)";
	$textline2 = "Page <b>$pagenum</b> of <b>$last</b>";
	$paginationCtrls = '';
	if($last != 1){
		if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a> &nbsp; &nbsp; ';
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
				}
	   		}
    	}
	    $paginationCtrls .= ''.$pagenum.' &nbsp; ';
	    for($i = $pagenum+1; $i <= $last; $i++){
			$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
			if($i >= $pagenum+4){
				break;
			}
		}
		if ($pagenum != $last) {
	        $next = $pagenum + 1;
	        $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a> ';
	    }
	}
	echo'<h2>  '.$textline1.'</h2>
	<p>  '.$textline2.' </p>
	<div id="pagination_controls"> '.$paginationCtrls.'</div>';



$sql="SELECT notifid,username,imgpath,receiverid,notifdate,notiftype,details,details2 FROM tblnotif
LEFT JOIN tbluser
ON tblnotif.userid=tbluser.userid
WHERE receiverid='$id' 
ORDER BY notifid DESC $limit";

$result=$conn->query($sql);
$count=$result->num_rows;
echo '<ul id="notiflist">';
while($rows=$result->fetch_object())
{
$nid=$rows->notifid;
$uname=$rows->username;
$rid=$rows->receiverid;
$type=$rows->notiftype;
$date=time_elapsed_string($rows->notifdate);
$details=$rows->details;
$details2=$rows->details2;
$imgpath=$rows->imgpath;

if($type==1){

	echo'<li><div class="comment-tn">
				<img src="'.$imgpath.'">
			</div><a class="n1" href="profile.php?name='.$uname.'">'.$uname.'</a> <a class="n2" href="profile.php?name='.$_SESSION['name'].'#comment'.$details.'"> has commented on your profile '.$date.'</a></li>';
} else if($type==2){
	if ($details2==1){
	echo'<li><div class="comment-tn">
				<img src="'.$imgpath.'">
			</div>
			 <a class="n1" href="profile.php?name='.$uname.'">'.$uname.'</a> has sent a friend request '.$date.'<br>
		<div id="fr-'.$nid.'"><a class="fr-btn" onclick="friendyes()" value="'.$nid.'">Yes</a> <a class="fr-btn" onclick="friendno()" value="'.$nid.'">No</a>
		</div>
		</li>';
	} else if($details2==2){
		echo'<li><div class="comment-tn">
				<img src="'.$imgpath.'">
			</div>
			 <a class="n1" href="profile.php?name='.$uname.'">'.$uname.'</a> has sent a friend request '.$date.'<br>
		<div id="fr-'.$nid.'">
			Request Accepted
		</div>
		</li>';
	} else if($details2==3){
		echo'<li><div class="comment-tn">
				<img src="'.$imgpath.'">
			</div>
			 <a class="n1" href="profile.php?name='.$uname.'">'.$uname.'</a> has sent a friend request '.$date.'<br>
		<div id="fr-'.$nid.'">
			Request Denied
		</div>
		</li>';
	}
}
}

echo '</ul>';
mysqli_close($conn);
?>
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