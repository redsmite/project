<?php
session_start();
require_once'connection.php';

if(isset($_POST['username'])){
	$error=array();
	$username=$_SESSION['name'];
	$time=$_POST['time'];
	$lastupdate=strtotime($_POST['update']);
	$diff=time()-$lastupdate;
	$month=60*60*24*28;
	if($diff<$month){
		array_push($error,'<i class="fas fa-exclamation-circle"></i>You have recently changed your username');
		echo json_encode($error);
	}else{

		$sql="SELECT username FROM tbluser WHERE username='$username'";
		$res_u=$conn->query($sql);
		$row=$res_u->fetch_object();
		if ($res_u->num_rows != 0 && $row->username !=$username) {
			array_push($error,'<i class="fas fa-exclamation-circle"></i>Username is already taken');
		}


		if(strlen($_POST['username']) > 20)
		{
		    array_push($error,'<i class="fas fa-exclamation-circle"></i>Username must not be longer than 20 characters.');
		}

		if($username==$_POST['username']){
			array_push($error,'<i class="fas fa-exclamation-circle"></i> No changes made.');	
		}

		if (preg_match('/[^A-Z]/i',$_POST['username']))
		{
		     array_push($error,'<i class="fas fa-exclamation-circle"></i>Username must not contain special characters or spaces.');
		}
		if(!$error){
			$editname=$_POST['username'];
			$id=$_SESSION['id'];
			$sql="UPDATE tbluser SET username='$editname', lastupdate='$time' WHERE userid='$id'";
			if($conn->query($sql)){

			$_SESSION['name']=$editname;

			echo json_encode('success');
			}
		}else{
			echo json_encode($error);
		}
	}
}

if(isset($_POST['session'])){
	$name=$_SESSION['name'];
	echo json_encode($name);
}

if(isset($_POST['oldpass'])){
	$error=array();

	$id=$_SESSION['id'];
	$old=md5($_POST['oldpass']);
	$new=$_POST['newpass'];
	$new2=$_POST['retype'];
	$true=$_POST['truepass'];
	if($true!=$old){
		 array_push($error,'<i class="fas fa-exclamation-circle"></i> Password doesn\'t match with old password.');
		 echo json_encode($error);
	}else{
		if($new!=$new2){
			array_push($error,'<i class="fas fa-exclamation-circle"></i>New Password doesn\'t match.');
			echo json_encode($error);
		}else{
			$new=md5($new);
			$sql="UPDATE tbluser SET password='$new' WHERE userid='$id'";
			$conn->query($sql) or die($conn->error);

			echo json_encode('success');
		}
	}
}

?>