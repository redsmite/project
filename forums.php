<?php
session_start();
include'functions.php';
require_once('connection.php');

if(!isset($_GET['id'])){
	die('This forum doesn\'t exists.');
}

//Get forum information
$forums = $_GET['id'];
$uid = $_SESSION['id'];

$sql = "SELECT forumid,title,name,description,datecreated,subscriber FROM tblforum WHERE forumid='$forums'";
$result = $conn->query($sql);	
$fetch = $result->fetch_object();

$fid = $fetch->forumid;
$title = $fetch->title;
$name = $fetch->name;
$desc = $fetch->description;
$subcount = $fetch->subscriber;
$date = date("M j, Y", strtotime($fetch->datecreated));

//forum views

$sql = "UPDATE tblforum SET views=views+1 WHERE forumid='$forums'";
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
$sql = "SELECT postid,tblpost.forumid,name,tblpost.title,tblpost.datecreated,username,comments,score FROM tblpost
	LEFT JOIN tblforum
		ON tblpost.forumid = tblforum.forumid
	LEFT JOIN tbluser
		ON userid = starter
	WHERE tblpost.forumid='$forums'
	ORDER BY postid DESC
	LIMIT 50";
	$result = $conn->query($sql);
	while($row=$result->fetch_object()){
		$id = $row->postid;
		$forumid = $row->forumid;
		$forum = $row->name;
		$ptitle = $row->title;
		$name = $row->username;
		$comments = $row->comments;
		$datep = $row->datecreated;
		$score = $row->score;

		$sql2 = "SELECT upvoteid FROM tblupvotepost WHERE user='$uid' and post='$id'";
		$result2 = $conn->query($sql2);
		$upvote = $result2->num_rows;

		$sql3 = "SELECT downvoteid FROM tbldownvotepost WHERE user='$uid' and post='$id'";
		$result3 = $conn->query($sql3);
		$downvote = $result3->num_rows;

		echo '<li value="'.$id.'">
 		<div class="forum-post-grid">';
//login'd user can only vote
 		if(isset($_SESSION['id'])){
 		echo'
 		<div class="vote">
 			<div id="up-'.$id.'" value="'.$id.'" onclick="upvotepost(this)" class="upvote">';
			
 			if(!$upvote){
				echo'<i class="fas fa-sort-up"></i>';
 			}else{
 				echo'<font color="magenta"><i class="fas fa-sort-up"></i></font>';
 			}
			

			echo'</div>
			<div id="score-'.$id.'">'.$score.'</div>
			<div id="down-'.$id.'" value="'.$id.'" onclick="downvotepost(this)" class="downvote">';
			if(!$downvote){
				echo'<i class="fas fa-sort-down"></i>';
			}else{
				echo'<font color="cyan"><i class="fas fa-sort-down"></i></font>';
			}

			echo'</div>
		</div>';

		}else{
			echo'
		<div class="vote">
 			<div class="upvote">
			<i class="fas fa-sort-up"></i>
			</div>
			<div>'.$score.'</div>
			<div class="downvote">
			<i class="fas fa-sort-down"></i>
		</div>
		</div>';
		}
		echo'<div class="post-right">
		<p class="main-forum-title"><a href="reply.php?id='.$forumid.'&thread='.$id.'">'.$ptitle.'</a></p>
		<p>From: <a href="forums.php?id='.$forumid.'">'.$forum.'</a> By:<a href="profile.php?name='.$name.'">'.$name.'</a> '.time_elapsed_string($datep).'</p>
		<p>(<a href="reply.php?id='.$forumid.'&thread='.$id.'">'.$comments.' Comments</a>)</p>
		</div>
		</div>
		</li>';
	}
?>
			</ul>
			</div>
			<div class="forum-sidebar">
				<?php
					forumcontrols();
				?>
				<div class="forum-panel">
					<h2 id="forum-name"><?php echo $title?></h2>
					<div class="" id="forum-date"><?php echo 'Created: '.$date ?></div>
					<p id="description"><?php echo $desc ?></p>
					<p id="subscriber-count"><?php echo $subcount ?> Subscribers.</p>
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