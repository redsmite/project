<?php
require_once'connection.php';
session_start();

if(isset($_POST['username'])){
	$error=array();
	
	if(strlen($_POST['username']) > 20)
	{
	    array_push($error,'<i class="fas fa-exclamation-circle"></i>Username must not be longer than 20 characters');
	}
	

	if(strlen($_POST['password']) < 8)
	{
	    array_push($error,'<i class="fas fa-exclamation-circle"></i>Password must be atleast 8 characters');
	}


	//insert into Database
	$username = mysqli_real_escape_string($conn,$_POST['username']);
	$password = md5($_POST['password']);
	$retype= md5($_POST['retype']);
	$firstname= mysqli_real_escape_string($conn,$_POST['firstname']);
	$middlename= mysqli_real_escape_string($conn,$_POST['middlename']);
	$lastname= mysqli_real_escape_string($conn,$_POST['lastname']);
	$birthday= mysqli_real_escape_string($conn,$_POST['birthday']);
	$timestamp = 'NOW()';
	$email= mysqli_real_escape_string($conn,$_POST['email']);
	$phoneno= mysqli_real_escape_string($conn,$_POST['phoneno']);
	$address= mysqli_real_escape_string($conn,$_POST['address']);
	$gender= mysqli_real_escape_string($conn,$_POST['gender']);

	//Check if password is equal
	if($password!=$retype){
		array_push($error,'<i class="fas fa-exclamation-circle"></i>Password doesn\'t match');
	}

	//Check if username is taken
	$sql="SELECT username FROM tbluser WHERE username='$username'";
	$res_u=$conn->query($sql);
	if ($res_u->num_rows != 0) {
		array_push($error,'<i class="fas fa-exclamation-circle"></i>Username is already taken');
	}

	//Check if email is taken		
	$sql2="SELECT email FROM tbluser WHERE email='$email'";
	$res_e =$conn->query($sql2);
	if($res_e->num_rows != 0){
		array_push($error,'<i class="fas fa-exclamation-circle"></i>Email is already taken');
	}

	//Check if no error
	if(!$error){
		$sql3="INSERT INTO tbluser(username,password,firstname,middlename,lastname,birthday,datecreated,email,phoneno,address,usertypeid,access,is_show_email,gender) VALUES('$username','$password','$firstname','$middlename','$lastname','$birthday',$timestamp,'$email','$phoneno','$address','1','1','1','$gender')";
		if($conn->query($sql3)){

			//Auto Login

			$sql4='SELECT COALESCE(MAX(userid), 0) AS newUserID FROM tbluser';
			$result=$conn->query($sql4);
		
			$row=$result->fetch_object();
			$userlogin=$row->newUserID;
			
			$_SESSION['id']=$userlogin;
			$_SESSION['name']=$username;
			$_SESSION['type']=1;

			echo json_encode('success');
		}

	} else {
		echo json_encode($error);
	}
}
?>