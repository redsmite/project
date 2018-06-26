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
			<div id="fetch"></div>
		</div>
		<div class="admin-reports">
			<h1>Reports</h1>
<?php
	$sql = "SELECT username,reason,tblreport.datecreated FROM tblreport
	LEFT JOIN tbluser
		ON tblreport.userid=tbluser.userid";
	$result = $conn->query($sql);
	while($row=$result->fetch_object()){
		$username= $row->username;
		$reason = $row->reason;
		$date= time_elapsed_string($row->datecreated);

		echo '<p>'.$username.'</p>';
		
		if($reason==1){
			echo'<p>This user has nude or offensive profile picture</p>';
		}else if($reason==2){
			echo'<p>This user has a toxic behavior</p>';
		} else{
			echo'<p>'.$reason.'</p>';
		} 
		echo'<p>'.$date.'</p>
		<br>';
	}
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
		sendAllUser();
	</script>
</body>
</html>