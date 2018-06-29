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

	echo 'Thanks for subbing in.';

	} else {
	$sql = "DELETE FROM tblsubscribe WHERE subscriber='$id' AND forum='$sub' ";
	$result= $conn->query($sql);

	$sql = "UPDATE tblforum SET subscriber=subscriber-1 WHERE forumid='$sub'";
	$result= $conn->query($sql);
	echo 'You have unsubscribed.';
	}

}
?>