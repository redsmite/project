<?php
session_start();
require_once'connection.php';
include'functions.php';
user_access();
if(isset($_POST['fetch'])){
	$data='<table>
	<tr>
	<th>Profile</th>
	<th>Ban/Allow</th>
	<th>Remove Photo</th>
	</tr>';

	$sql="SELECT userid,username FROM tbluser";
	$result=$conn->query($sql);

	while($row=$result->fetch_object()){
		$id = $row->userid;
		$name = $row->username;

		$data.= '<tr>
		<th><a href="'.$name.'">'.$name.'</a><br></th>
		<th id="user-'.$id.'"><a id="'.$id.'" class="useraccess" value="'.$id.'" onclick="useraccess(this.id)">Access</a></th>
		<th><a value="'.$id.'">Remove Photo</a></th>
		</tr>';
	}
	echo $data;
}
?>