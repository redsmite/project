<?php
require_once'connection.php';

if(isset($_POST['username'])){
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

	if($password==$retype){
		$sql="SELECT username FROM tbluser WHERE username='$username'";
		if($res_u=$conn->query($sql)){
			if ($res_u->num_rows == 0) {
				$sql2="SELECT email FROM tbluser WHERE email='$email'";
				$res_e =$conn->query($sql2);
				if($res_e->num_rows == 0){
					
					$sql3="INSERT INTO tbluser(username,password,firstname,middlename,lastname,birthday,datecreated,email,phoneno,address,usertypeid,access) VALUES('$username','$password','$firstname','$middlename','$lastname','$birthday','$timestamp','$email','$phoneno','$address','1','1')";

					if($conn->query($sql3)){
						echo 'success';
					} else {
							echo '<i class="fas fa-exclamation-triangle"></i>Sorry, we are having some problems.';
					}

				}else{
					echo '<i class="fas fa-exclamation-triangle"></i>Email is already taken';
				}
			

			}	else {
				echo '<i class="fas fa-exclamation-triangle"></i>Username is already taken';
			}

		} else {
				echo '<i class="fas fa-exclamation-triangle"></i>Sorry, we are having some problems.';
		}

	} else {
		echo'<i class="fas fa-exclamation-triangle"></i>Password doesn\'t match';
	}
}
?>