<?php
session_start();
require_once'connection.php';
include'functions.php';
user_access();
if(isset($_POST['fetch'])){
	$data='';

	$sql="SELECT username FROM tbluser";
	$result=$conn->query($sql);

	while($row=$result->fetch_object()){
		$name = $row->username;

		$data.= '<a href="'.$name.'">'.$name.'</a><br>';
	}
	echo $data;
}
?>