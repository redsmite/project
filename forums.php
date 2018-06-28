<?php
session_start();
include'functions.php';
require_once('connection.php');

if(!isset($_GET['id'])){
	die('This forum doesn\'t exists.');
}

//Get forum information
$forums = $_GET['id'];

$sql = "SELECT title,name,description,datecreated FROM tblforum WHERE forumid='$forums'";
$result = $conn->query($sql);	
$fetch = $result->fetch_object();

$title = $fetch->title;
$name = $fetch->name;
$desc = $fetch->description;
$date = date("M j, Y", strtotime($fetch->datecreated));

addSidebar();
addLogin();
setupCookie();
updateStatus();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
  	<link rel="stylesheet" href="css/fontawesome-all.css">
	<meta charset="UTF-8">
	<title><?php echo $title?></title>
</head>
<body>
	<div class="main-container">
	<?php
		addheader();
	?>
	<div class="other-content">
		<div class="forum-grid">
			<div class="main-forum">
				<h1><?php echo $title ?></h1>
			</div>
			<div class="forum-sidebar">
				<div id="create-new-post" class="sidebar-button" onclick="createNewPost()">
					<h3><i class="fas fa-plus-square"></i> Create New Post</h3>
				</div>
				<div id="create-new-forum" class="sidebar-button" onclick="createNewForum()">
					<h3><i class="fas fa-plus-square"></i> Create Your Own Forum</h3>
				</div>
				<div id="new-forum-modal" onclick="closeNewForum()"></div>
				<div id="new-forum-form">
					<form id="create-forum-form">
						<div>
							<p>Forum Name:</p>
							<p>*Must not contain spaces or special characters</p>
							<input id="forum-name" type="text">
						</div>
						<div>
							<p>Title:</p>
							<input id="forum-title" type="text">
						</div>
						<div>
							<p>Forum Description:</p>
							<textarea id="forum-desc"></textarea>
						</div>
						<div>
							<input type="submit" value="Submit">
						</div>
						<div id="error-message2"></div>
					</form>
				</div>
				<div id="subscribe">
					<h3>Subscribe</h3>
				</div>
				<div class="forum-panel">
					<h2 id="forum-name"><?php echo $title?></h2>
					<div class="" id="forum-date"><?php echo 'Created: '.$date ?></div>
					<p id="description"><?php echo $desc ?></p>
					<p id="subscriber-count">0 Subscribers.</p>
					<p id="users-count">1 Users here now.</p>
				</div>
			</div>
		</div>
	</div>
	<?php
		addfooter();
	?>
	</div>
	<script src="js/main.js"></script>
	<script>
		newForumForm();
		modal();
		ajaxLogin();
	</script>
</body>
</html>