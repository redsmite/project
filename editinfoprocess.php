<?php
session_start();
require_once'connection.php';
if(isset($_POST['edit-button'])){
	$username=$_SESSION['name'];
	$firstname= $conn->real_escape_string($_POST['edit-first']);
	$middlename= $conn->real_escape_string($_POST['edit-middle']);
	$lastname= $conn->real_escape_string($_POST['edit-last']);
	$birthday= $conn->real_escape_string($_POST['edit-birthday']);
	$phoneno= $conn->real_escape_string($_POST['edit-phone']);
	$address= $conn->real_escape_string($_POST['edit-address']);
	$bio= $conn->real_escape_string($_POST['edit-bio']);
	$privacy=$_POST['privacy'];

	$sql="UPDATE tbluser SET firstname='$firstname', middlename='$middlename',lastname='$lastname',birthday='$birthday',phoneno='$phoneno',address='$address',bio='$bio',is_show_email='$privacy' WHERE username='$username'";
	if($result =$conn->query($sql)){
		header("Location:profile.php?name=".$_SESSION['name']."");
	}
}

?>