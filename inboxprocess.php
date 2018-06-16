<?php
session_start();
require_once'connection.php';
include'functions.php';

if(isset($_POST['message'])){

	$message=$_POST['message'];
	$name=$_POST['name'];

	$sql="SELECT userid FROM tbluser WHERE username='$name'";
	$result=$conn->query($sql);
	$row=$result->fetch_object();
	$Rid=$row->userid;

	$sender=$conn->real_escape_string($_SESSION['id']);
	$receiver=$conn->real_escape_string($Rid);
	$message=$conn->real_escape_string($_POST['message']);
	$timestamp='NOW()';
	
	$sql="INSERT INTO tblpm (senderid,receiverid,message,pmdate) VALUES('$sender','$receiver','$message',$timestamp)";
	$result=$conn->query($sql);



	//Reset Inbox

$id=$_SESSION['id'];

$Rquery="SELECT userid FROM tbluser WHERE username='$name'";
$result=$conn->query($Rquery);
$row=$result->fetch_object();
$Rid=$row->userid;

$sql="SELECT username,imgpath,message,pmdate FROM tblpm
LEFT JOIN tbluser
	ON senderid=userid
WHERE (receiverid='$id' and username='$name') or (senderid='$id' and receiverid='$Rid')
ORDER BY pmid DESC 
LIMIT 30
";

$data='';
$result=$conn->query($sql);
while($row=$result->fetch_object()){
	$Sname=$row->username;
	$message=$row->message;
	$imgpath=$row->imgpath;
	$date=$row->pmdate;
	if($imgpath==''){
		$imgpath='img/default.png';
	}

	if($Sname==$_SESSION['name']){
	$data.= '<div class="chat-me">
	<a class="sender" href="profile.php?name='.$Sname.'"><span class="inbox-date">'.time_elapsed_string($date).'</span>
		<div class="comment-tn">
			<img src="'.$imgpath.'">
		</div>'.$Sname.'</a><br>
	<div class="inbox-div"> 
		<p class="inbxmsg">'.createlink(nl2br($message)).'</p>
	</div>
	</div>';
	}else{
	$data.= '<div class="chat-notme">
	<a class="sender" href="profile.php?name='.$Sname.'"><span class="inbox-date">'.time_elapsed_string($date).'</span>
		<div class="comment-tn">
			<img src="'.$imgpath.'">
		</div>'.$Sname.'</a><br>
	<div class="inbox-div"> 
		<p class="inbxmsg">'.createlink(nl2br($message)).'</p>
	</div>
	</div>';
	}

}
		$data.='</div>
	</div>';
}

echo $data;


?>