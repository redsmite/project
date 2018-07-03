<?php
	session_start();
	include'functions.php';
	require_once'connection.php';
	addSidebar();
	addLogin();
	setupCookie();
	updateStatus();
	chattab();
	if(isset($_SESSION['id'])){
		$uid = $_SESSION['id'];
	}
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
					<div class="tab-control">
						<a id="tab1" onclick="showallforum()">All</a>
						<?php
						if(isset($_SESSION['id'])){
							echo'<a id="tab2" onclick="showsubforum()">Subscribed</a>';
							}else{
							echo'<a id="tab2" onclick="showlogin()">Subscribed</a>';
							}
						?>
					</div><br>
					<div id="list-container">
						<h2>All Forum Posts</h2>
						<ul id="forum-list">
<?php
$sql = "SELECT postid,tblpost.forumid,upvoteid,downvoteid,name,tblpost.title,tblpost.datecreated,username,comments,score FROM tblpost
	LEFT JOIN tblforum
		ON tblpost.forumid = tblforum.forumid
	LEFT JOIN tbluser
		ON userid = starter
	LEFT JOIN tblupvotepost
		ON postid = tblupvotepost.post
	LEFT JOIN tbldownvotepost
		ON postid = tbldownvotepost.post
	GROUP BY postid
	ORDER BY postid DESC
	LIMIT 25";
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
		$upvote = $row->upvoteid;
		$downvote = $row->downvoteid;


		echo '<li value="'.$id.'">
 		<div class="forum-post-grid">';
//login'd user can only vote
 		if(isset($_SESSION['id'])){
 		$sql2 = "SELECT upvoteid FROM tblupvotepost WHERE user='$uid' and post='$id'";
		$result2 = $conn->query($sql2);
		$upvote = $result2->num_rows;

		$sql3 = "SELECT downvoteid FROM tbldownvotepost WHERE user='$uid' and post='$id'";
		$result3 = $conn->query($sql3);
		$downvote = $result3->num_rows;
 		echo'
 		<div class="vote">';
 			
 			if(!$upvote){
 			echo'<div id="up-'.$id.'" style="color:black;" value="'.$id.'" onclick="upvotepost(this)" class="upvote"><i class="fas fa-sort-up"></i></div>';
 			}else{
 			echo'<div id="up-'.$id.'" style="color:magenta;" value="'.$id.'" onclick="upvotepost(this)" class="upvote"><i class="fas fa-sort-up"></i></div>';
 			}
			

			echo'
			<div id="score-'.$id.'">'.$score.'</div>';
			
			if(!$downvote){
			echo'
			<div id="down-'.$id.'" style="color:black;" value="'.$id.'" onclick="downvotepost(this)" class="downvote"><i class="fas fa-sort-down"></i>
			</div>';
			}else{
			echo'
			<div id="down-'.$id.'" style="color:cyan;" value="'.$id.'" onclick="downvotepost(this)" class="downvote"><i class="fas fa-sort-down"></i>
			</div>';
			}

			echo'
		</div>';

		}else{
			echo'
		<div class="vote">
 			<div class="upvote" onclick="showlogin()">
			<i class="fas fa-sort-up"></i>
			</div>
			<div>'.$score.'</div>
			<div class="downvote" onclick="showlogin()">
			<i class="fas fa-sort-down"></i>
		</div>
		</div>';
		}
		echo'<div class="post-right">
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
		let tab1 = document.getElementById('tab1');
		tab1.classList.add('style-tab');

		modal();
		ajaxLogin();
	</script>
</body>
</html>