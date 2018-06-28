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
?>