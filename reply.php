<?php
session_start();
include'functions.php';
require_once('connection.php');

if(!isset($_GET['id'])){
	die('This forum doesn\'t exists.');
}

if(!isset($_GET['thread'])){
	die('This post doesn\'t exists.');
}

//Get forum information
$forums = $_GET['id'];
$thread = $_GET['thread'];

$sql = "SELECT forumid,title,name,description,datecreated FROM tblforum WHERE forumid='$forums'";
$result = $conn->query($sql);	
$fetch = $result->fetch_object();

$fid = $fetch->forumid;
$title = $fetch->title;
$name = $fetch->name;
$desc = $fetch->description;
$date = date("M j, Y", strtotime($fetch->datecreated));

//forum views

$sql = "UPDATE tblforum SET views=views+1 WHERE forumid='$thread'";
$result= $conn->query($sql);

//Post views

$sql = "UPDATE tblpost SET views=views+1 WHERE postid='$forums'";
$result= $conn->query($sql);


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
				<h1><?php echo '<a id="top-title" href="forums.php?id='.$fid.'">'.$title.'</a>' ?></h1>
				<ul id="forum-list">
<?php
	$sql = "SELECT postid,tblpost.forumid,name,tblpost.title,tblpost.datecreated,tblpost.description,tblpost.score ,username,comments FROM tblpost
 	LEFT JOIN tblforum
 		ON tblpost.forumid = tblforum.forumid
 	LEFT JOIN tbluser
 		ON userid = starter
 	WHERE tblforum.forumid = '$forums' AND postid='$thread'";
 	$result = $conn->query($sql);
 	$row=$result->fetch_object();
 		$id = $row->postid;
 		$forumid = $row->forumid;
 		$forum = $row->name;
 		$ptitle = $row->title;
 		$name = $row->username;
 		$pdesc = $row->description;
 		$score = $row->score;
 		$comments = $row->comments;
 		$pdate = $row->datecreated;

 		echo '<li value="'.$id.'">
 		<div class="forum-post-grid">
 		<div class="vote">
 		<div class="upvote">
			<i class="fas fa-sort-up"></i>
			</div>
			<div>'.$score.'</div>
			<div class="downvote">
			<i class="fas fa-sort-down"></i>
		</div>
		</div>
		<div class="right-post">
			<p class="main-forum-title">'.$ptitle.'</p>
		</div>
 		</div>
 		<div class="text-content">'.$pdesc.'</div>
 		<p>Submitted by: <a href="profile.php?name='.$name.'">'.$name.'</a> '.time_elapsed_string($pdate).'
 		</li>';
?>
			</ul>
			<div class="reply-form">
				<form id="reply-submit">
					<div>
						<textarea id="reply-text"></textarea>
					</div>
					<div>
						<input type="submit" value="Submit">
					</div>
				</form>
			</div>
			</div>
			<div class="forum-sidebar">
				<?php
					forumcontrols();
				?>
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
	<?php if(!isset($_SESSION['id'])){echo'<div id="create-forum-form"></div><div id="create-post-form"></div>';}?>
	<script src="js/main.js"></script>
	<script>
		newForumForm();
		newPostForm();
		modal();
		ajaxLogin();
	</script>
</body>
</html>