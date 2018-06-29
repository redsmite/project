<?php
	session_start();
	include'functions.php';
	require_once'connection.php';
	addSidebar();
	addLogin();
	setupCookie();
	updateStatus();
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
	<!-- Showcase -->
		<div class="showcase">
			<div class="container">
				<div class="showcase-content">
					<div class="showcase-container">
						<h1>Welcome to RainbowDream</h1>
						<p>This is a website where farmers, breeders or craftsman sell their goods and stuff.</p><br>
						<p><a href="about.php">Read More</a></p>
					</div>
				</div>
			</div>
		</div>
	<!-- Content -->
		<div class="main-content">
			<div class="main-content-grid">
				<div class="announcement">
					<h2>Announcements</h2>
					<p>None...</p>
				</div>
				<div class="content-body">
					<h2>Trending Posts</h2>
					<ul id="forum-list">
<?php
$sql = "SELECT postid,tblpost.forumid,name,tblpost.title,tblpost.datecreated,username,comments,score FROM tblpost
	LEFT JOIN tblforum
		ON tblpost.forumid = tblforum.forumid
	LEFT JOIN tbluser
		ON userid = starter
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
		$date = $row->datecreated;
		$score = $row->score;

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
		<div class="post-right">
		<p class="main-forum-title"><a href="reply.php?id='.$forumid.'&thread='.$id.'">'.$ptitle.'</a></p>
		<p>From: <a href="forums.php?id='.$forumid.'">'.$forum.'</a> By:<a href="profile.php?name='.$name.'">'.$name.'</a> '.time_elapsed_string($date).'</p>
		<p>(<a href="reply.php?id='.$forumid.'&thread='.$id.'">'.$comments.' Comments</a>)</p>
		</div>
		</div>
		</li>';
	}
?>
				</ul>
				</div>
				<div class="sidebar">
					<h3>Newest Users</h3>
<?php
//newest users
	$sql="SELECT username,imgpath,datecreated FROM tbluser ORDER BY userid DESC LIMIT 5";
	$result=$conn->query($sql);
	while($row=$result->fetch_object()){

		$name=$row->username;
		$img=$row->imgpath;
		if(!$img){
			$img='img/default.png';
		}
		$date = date("M j, Y", strtotime($row->datecreated));
		$time = date("g:i:s A", strtotime($row->datecreated));

		echo'
		<div>
		<ul class="drop-ul"><li><a href="profile.php?name='.$name.'"><div class="drop-tn"><img src="'.$img.'"></div><p>'.$name.'</a></p><small>Joined: '.$date.'</small><br>
			<small>'.$time.'</small>
		<li></ul>
		</div>';
	}

?>
				</div>
				<div class="sidebar2">
					<h3>Popular Forums</h3>
					<ul id="forum-list">
<?php
//Popular Forums
	$sql = "SELECT forumid,name, (views+subscriber) AS popular FROM tblforum ORDER BY popular DESC LIMIT 10";
	$result = $conn->query($sql);
	while($row=$result->fetch_object()){
		$id = $row->forumid;
		$name = $row->name;

		echo'<li><a href="forums.php?id='.$id.'">'. $name.'</a></li>';
	}
?>
				</ul>
				</div>
				<div class="sidebar3">
					<h3>Popular Users</h3>
<?php
//Popular Users
	$count=1;
	$sql="SELECT username,imgpath,datecreated FROM tbluser ORDER BY profileviews DESC LIMIT 5";
	$result=$conn->query($sql);
	while($row=$result->fetch_object()){

		$name=$row->username;
		$img=$row->imgpath;
		if(!$img){
			$img='img/default.png';
		}
		$date = date("M j, Y", strtotime($row->datecreated));
		$time = date("g:i:s A", strtotime($row->datecreated));

		echo'
		<div>
		<ul class="drop-ul"><li><a href="profile.php?name='.$name.'"><div class="drop-tn"><img src="'.$img.'"></div><p>';
		if ($count==1){
			echo'<i class="fas fa-trophy gold"></i>';
		}else if ($count==2){
			echo'<i class="fas fa-trophy silver"></i>';
		}else if ($count==3){
			echo'<i class="fas fa-trophy bronze"></i>';
		}
		echo ' '.$name.'</a></p><small>Joined: '.$date.'</small><br>
			<small>'.$time.'</small>
		<li></ul>
		</div>';
		$count++;
	}

?>		
				</div>
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