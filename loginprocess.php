<?php
require_once'connection.php';

if(isset($_POST['username'])){
	//insert into Database
	$username = $conn->real_escape_string($_POST['username']);
	$password = md5($_POST['password']);

	$sql = "SELECT userid,username,password,usertypeid,access FROM tbluser WHERE username='$username' and password='$password'";

		if($result=$conn->query($sql)){
		
			if ($result->num_rows != 0) {

				$row=$result->fetch_object();

				if($row->access==1){


					$id = $row->userid;
					$name = $row->username;
					$type = $row->usertypeid;

					$sessions = array(0,$id,$name,$type);

					echo json_encode($sessions);

				}else{

					echo'<i class="fas fa-exclamation-triangle"></i>Sorry, your account has been banned.';

				}
		
			}else{
				$sessions =array(1,'<i class="fas fa-exclamation-triangle"></i>Invalid username or password.');
				echo json_encode($sessions);
			}
		}
}





