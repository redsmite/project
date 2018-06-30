<?php
session_start();
require_once'connection.php';
include'functions.php';

if(isset($_POST['title'])){
	$title = $conn->real_escape_string($_POST['title']);
	$name = $conn->real_escape_string($_POST['name']);
	$desc = $conn->real_escape_string($_POST['desc']);
	$id = $_SESSION['id'];

	$error="";


	if (preg_match('/[^A-Z]/i',$name)){
		$error.='<p><i class="fas fa-exclamation-circle"></i>Forum name must not contain special characters or spaces</p>';
	}

// Test if forum name exists
	$sql= "SELECT forumid FROM tblforum WHERE name = '$name'";
	$result = $conn->query($sql);
	$exist = $result->num_rows;
	
	if($exist!=0){
		$error.='<p><i class="fas fa-exclamation-circle"></i>Forum name already exists';
	}

	if(!$error){

	$sql = "INSERT INTO tblforum (title,name,datecreated,description,creator) VALUES('$title','$name',NOW(),'$desc','$id')";
	$result = $conn->query($sql);

	$sql="SELECT COALESCE(MAX(forumid), 0) AS newForumID FROM tblforum";
	$result=$conn->query($sql);
	$row=$result->fetch_object();
	$forumid=$row->newForumID;

	echo $forumid;
	}else{
		echo $error;
	}
}

if(isset($_POST['newpost'])){
	$title = $conn->real_escape_string($_POST['newpost']);
	$text = $conn->real_escape_string($_POST['text']);
	$forum = $_POST['forum'];
	$user = $_POST['user'];

	$error="";

	if(strlen($text) < 30)
	{
	    $error.='<i class="fas fa-exclamation-circle"></i>Text must be atleast 30 characters<br>';
	}


	if(!$error){

	$sql = "INSERT INTO tblpost(forumid,title,datecreated,description,starter) VALUES ('$forum','$title',NOW(),'$text','$user')";
	$result = $conn->query($sql);
	echo 'success';

	}else{
		echo $error;
	}
}

if(isset($_POST['sub'])){
	$id = $_SESSION['id'];
	$sub = $_POST['sub'];

	$sql = "SELECT subid FROM tblsubscribe WHERE subscriber='$id' AND forum='$sub'";

	$result= $conn->query($sql);
	if($result->num_rows==0){

	$sql = "INSERT INTO tblsubscribe(subscriber,forum) VALUES('$id','$sub')";
	$result= $conn->query($sql);
	
	$sql = "UPDATE tblforum SET subscriber=subscriber+1 WHERE forumid='$sub'";
	$result= $conn->query($sql);

	$sql = "SELECT subscriber FROM tblforum WHERE forumid='$sub'";
	$result=$conn->query($sql);
	$row= $result->fetch_object();
	$subcount = $row->subscriber;
	echo $subcount.' Subscribers';

	} else {
	$sql = "DELETE FROM tblsubscribe WHERE subscriber='$id' AND forum='$sub' ";
	$result= $conn->query($sql);

	$sql = "UPDATE tblforum SET subscriber=subscriber-1 WHERE forumid='$sub'";
	$result= $conn->query($sql);
	$sql = "SELECT subscriber FROM tblforum WHERE forumid='$sub'";
	$result=$conn->query($sql);
	$row= $result->fetch_object();
	$subcount = $row->subscriber;
	echo $subcount.' Subscribers';
	}

}

if(isset($_POST['upvote'])){
	$upvote = $_POST['upvote'];
	$id = $_SESSION['id'];

	$sql = "SELECT upvoteid FROM tblupvotepost WHERE user='$id' and post='$upvote'";
	$result = $conn->query($sql);
	$count = $result->num_rows;
	if($count){
	
	$sql = "DELETE FROM tblupvotepost WHERE user='$id' and post='$upvote'";
	$result = $conn->query($sql);

	$sql = "UPDATE tblpost SET score=score-1 WHERE postid='$upvote'";
	$result = $conn->query($sql);

	$sql = "SELECT score FROM tblpost WHERE postid='$upvote'";
	$result= $conn->query($sql);
	$row = $result->fetch_object();
	$score = $row->score;
	echo $score;

	}else{
	
	$sql = "INSERT INTO tblupvotepost (user,post) VALUES ('$id','$upvote')";
	$result = $conn->query($sql);

	$sql = "SELECT downvoteid FROM tbldownvotepost WHERE user ='$id' AND post ='$upvote'";
	$result = $conn->query($sql);
	$downvoted = $result->num_rows;

	if($downvoted){
	$sql = "DELETE FROM tbldownvotepost WHERE user ='$id' AND post ='$upvote' ";
	$result = $conn->query($sql);

	$sql = "UPDATE tblpost SET score=score+2 WHERE postid='$upvote'";
	$result = $conn->query($sql);
	}else{
	$sql = "UPDATE tblpost SET score=score+1 WHERE postid='$upvote'";
	$result = $conn->query($sql);

	}
	$sql = "SELECT score FROM tblpost WHERE postid='$upvote'";
	$result= $conn->query($sql);
	$row = $result->fetch_object();
	$score = $row->score;
	echo $score;
	}
}

if(isset($_POST['downvote'])){
	$downvote = $_POST['downvote'];
	$id = $_SESSION['id'];

	$sql = "SELECT downvoteid FROM tbldownvotepost WHERE user='$id' and post='$downvote'";
	$result = $conn->query($sql);
	$count = $result->num_rows;
	if($count){
		$sql = "DELETE FROM tbldownvotepost WHERE user ='$id' AND post ='$downvote' ";
		$result = $conn->query($sql);

		$sql = "UPDATE tblpost SET score=score+1 WHERE postid='$downvote'";
		$result = $conn->query($sql);

		$sql = "SELECT score FROM tblpost WHERE postid='$downvote'";
		$result= $conn->query($sql);
		$row = $result->fetch_object();
		$score = $row->score;
		echo $score;
	}else{

	$sql = "SELECT upvoteid FROM tblupvotepost WHERE user='$id' and post='$downvote'";
	$result = $conn->query($sql);
	$upvoted = $result->num_rows;

		if(!$upvoted){
		
		$sql = "INSERT INTO tbldownvotepost (user,post) VALUES ('$id','$downvote')";
		$result = $conn->query($sql);
		$sql = "UPDATE tblpost SET score=score-1 WHERE postid='$downvote'";
		$result = $conn->query($sql);


		}else{

		$sql = "DELETE FROM tblupvotepost WHERE user='$id' and post='$downvote'";
		$result = $conn->query($sql);
		
		$sql = "INSERT INTO tbldownvotepost (user,post) VALUES ('$id','$downvote')";
		$result = $conn->query($sql);
		$sql = "UPDATE tblpost SET score=score-2 WHERE postid='$downvote'";
		$result = $conn->query($sql);
		}
		$sql = "SELECT score FROM tblpost WHERE postid='$downvote'";
		$result= $conn->query($sql);
		$row = $result->fetch_object();
		$score = $row->score;
		echo $score;
	}
}

?>