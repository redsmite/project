<?php
session_start();
require_once'connection.php';
include'functions.php';
user_access();

if(isset($_POST['fetch'])){
	$fetch = $_POST['fetch'];

	$data='<table>
	<tr>
	<th>Profile</th>
	<th>Ban/Allow</th>
	<th>Remove Photo</th>
	</tr>';

	$sql="SELECT userid,username,access,usertypeid FROM tbluser WHERE username LIKE '%$fetch%' LIMIT 10";
	$result=$conn->query($sql);
	while($row=$result->fetch_object()){
		$id = $row->userid;
		$name = $row->username;
		$access = $row->access;
		$type = $row->usertypeid;

		$data.= '<tr>
		<th><a href="profile.php?name='.$name.'">'.$name.'</a><br></th>
		<th id="user-'.$id.'"><a id="'.$id.'" class="useraccess" value="'.$id.'" onclick="useraccess(this.id)">';

		
		if($access==1){
			if($type==4){
			}else{
				$data.='<span class="notbanned">Allow</span>';
			}
		} else if ($access==0){
			$data.='<span class="banned">Banned</span>';
		}

		$data.='</a></th>
		<th id="photo-'.$id.'"><a value="'.$id.'" onclick="removephoto(this)">Remove Photo</a></th>
		</tr>';
	}
	echo $data;
}

if(isset($_POST['status'])){
	$id = $_POST['status'];

	$sql = "SELECT access FROM tbluser WHERE userid='$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_object();
	$access = $row->access;

	if($access == 1){
		$change = "UPDATE tbluser SET access=0 WHERE userid='$id'";
		$sql2 = $conn->query($change);
		echo'<span class="banned">Banning...</span>';
	} else if ($access == 0){
		$change = "UPDATE tbluser SET access=1 WHERE userid='$id'";
		$sql2 = $conn->query($change);
		echo '<span class="notbanned">Removing ban...</span>';
	}
}

if(isset($_POST['photo'])){
	$id = $_POST['photo'];

	$sql = "UPDATE tbluser SET imgname='',imgtype='',imgpath='' WHERE userid='$id'";
	$result = $conn->query($sql);

	$sql = "INSERT INTO tblnotif(receiverid,notifdate,notiftype) VALUES('$id',NOW(),3)";
	$result = $conn->query($sql);
}

if(isset($_POST['select'])){
	$select = $_POST['select'];
	$reason = $_POST['reason'];
	$name = $_POST['username'];

	$sql = "SELECT userid FROM tbluser WHERE username ='$name'";
	$result = $conn->query($sql);
	$row = $result->fetch_object();
	$id = $row->userid;

	if (!$reason){

	$sql = "INSERT INTO tblreport (reason,datecreated,userid)
	VALUES ('$select',NOW(),'$id')";
	$result = $conn->query($sql);

	}else{


	$sql = "INSERT INTO tblreport (reason,datecreated,userid)
	VALUES ('$reason',NOW(),'$id')";
	$result = $conn->query($sql);
	
	}
}
?>