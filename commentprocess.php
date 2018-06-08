<?php
session_start();
include'connection.php';
if(isset($_POST['comment-submit'])){
	$comment=$conn->real_escape_string($_POST['comment']);
	$id=$conn->real_escape_string($_POST['hidden']);
	$receiver=$conn->real_escape_string($_POST['hidden2']);


	$sql="SELECT userid FROM tbluser WHERE username='$receiver'";
	$result=$conn->query($sql);
	$row=$result->fetch_object();
	$rid=$row->userid;

	$sql2="INSERT INTO tblcomment (userid,receiver,comment,dateposted) VALUES('$id','$rid','$comment',NOW())";
	$result2=$conn->query($sql2) or die(mysqli_error($conn));

	header("Location:profile.php?name=".$receiver."");
}

?>