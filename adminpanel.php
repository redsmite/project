<?php
session_start();
include'functions.php';
require_once'connection.php';
addSidebar();
addLogin();
setupCookie();
updateStatus();
adminpanelAccess();
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
<body>
	<div class="main-container">
	<!-- Header -->
	<?php
		addheader();
	?>
	<!-- Admin Panel -->
		<div class="other-content">
			<h3>Admin Panel</h3>
			<h1><i class="fas fa-unlock-alt"></i> Hello <?php echo $_SESSION['name']?></h1>

			<div class="edit-form">
				<form id='sendtoallform'>
					<center>
					<h3>Send message to all users</h3>
					<div>
						<textarea id="sendtoallmessage"  required placeholder="enter message..."></textarea>
					</div>
					<div>
						<input type="submit">
					</div>
					</center>
				</form>
			</div>
			<div class="get-users-div">
				<h1>Get User</h1>
				<input type="text" onkeyup="fetchUser()" id="get-user">
			</div>
			<div id="fetch">
				<div onclick="resetfetch()" class="closethis"><a><i class="fas fa-times"></i></a></div>
			</div>
			<div class="admin-reports">
			<ul class="reportlist">
<?php
	$sql = "SELECT reportid FROM tblreport";
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

	$sql = "SELECT reportid,user1.username AS reported, user2.username AS reporter,reason,tblreport.datecreated,checked FROM tblreport
	LEFT JOIN tbluser AS user1
		ON user1.userid=tblreport.userid
	LEFT JOIN tbluser AS user2
		ON user2.userid = reporter
	ORDER BY reportid DESC $limit";

$textline1 = "<i class='far fa-flag'></i> Reports (<b>$rows</b>)";
$textline2 = "Page <b>$pagenum</b> of <b>$last</b>";
$paginationCtrls = '';
if($last != 1){
	if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'pn='.$previous.'">Previous</a> &nbsp; &nbsp; ';
		// Render clickable number links that should appear on the left of the target page number
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'pn='.$i.'">'.$i.'</a> &nbsp; ';
			}
	    }
    }
    $paginationCtrls .= ''.$pagenum.' &nbsp; ';
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'pn='.$i.'">'.$i.'</a> &nbsp; ';
		if($i >= $pagenum+4){
			break;
		}
	}
	    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'pn='.$next.'">Next</a> ';
    }
}
 echo'<h2>  '.$textline1.'</h2>
  <p>  '.$textline2.' </p>
  <div id="pagination_controls"> '.$paginationCtrls.'</div>';

	$result = $conn->query($sql);
	while($row=$result->fetch_object()){
		$username= $row->reported;
		$reason = $row->reason;
		$date= time_elapsed_string($row->datecreated);
		$reporter = $row->reporter;
		$checked = $row->checked;
		$id = $row->reportid;

		echo '<li id="'.$id.'" onclick="checkedreport(this)">';

		if($checked==0){
			echo'<p id="rp-'.$id.'" class="newreport">Unchecked</p>';
		} else {
			echo '<p class="checkreport">Checked</p>';
		}

		echo'<p>Reported User: <a href="profile.php?name='.$username.'">'.$username.'</a></p>
		<p>Submitted by: <a href="profile.php?name='.$reporter.'">'.$reporter.'</a></p>';
		
		if($reason==1){
			echo'<p>Reason: Pornographic profile picture.</p>';
		}else if($reason==2){
			echo'<p>Reason: Offensive profile picture.</p>';
		}else if($reason==3){
			echo'<p>Reason: This user is toxic.</p>';
		}else if($reason==4){
			echo'<p>Reason: Spamming.</p>';
		}else if($reason==5){
			echo'<p>Reason: I hate this user.</p>';
		}else{
			echo'<p>Reason: '.$reason.'</p>';
		} 
		echo'<p>'.$date.'</p>
		</li>';
	}
?>
			</ul>
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
		sendAllUser();
	</script>
</body>
</html>