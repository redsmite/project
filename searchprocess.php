<?php
session_start();
include'functions.php';
include'connection.php';

if(isset($_POST['search'])){
	$search=$_POST['search'];

	$data='';
	$sql="SELECT username,imgpath,datecreated FROM tbluser WHERE username LIKE '%$search%' ORDER BY lastonline DESC LIMIT 10";
	$result=$conn->query($sql);
	while($row=$result->fetch_object()){

		$name=$row->username;
		$img=$row->imgpath;
		if(!$img){
			$img='img/default.png';
		}
		$date = date("M j, Y", strtotime($row->datecreated));

		$data.= $name.'|'.$img.'|'.$date.'||';
	}
	echo $data;
}

if(isset($_POST['search2'])){
	$search = $conn->real_escape_string($_POST['search2']);

	$data='';

	$sql = "SELECT forumid,name FROM tblforum WHERE name LIKE '%$search%' LIMIT 10";
	$result = $conn->query($sql);
	while($row = $result->fetch_object()){
		$id = $row->forumid;
		$name = $row->name;

		$data.= '<ul class="drop-ul2"><li><a href="forums.php?id='.$id.'">'.$name.'</li></ul>';
	}
	echo $data;
}
?>