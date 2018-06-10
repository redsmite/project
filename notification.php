<?php
session_start();
include'connection.php';
include'functions.php';
user_access();



$id=$_SESSION['id'];
$sql="SELECT notifid,userid,receiverid,notif,notifdate FROM tblnotif WHERE receiverid='$id' ORDER BY notifid DESC";
$result=$conn->query($sql);
while($rows=$result->fetch_object())
{
$nid=$rows->notifid;
$uid=$rows->userid;
$rid=$rows->receiverid;
$notif=$rows->notif;
$date=time_elapsed_string($rows->notifdate);

$sql2="SELECT username FROM tbluser WHERE userid='$uid'";
$result2=$conn->query($sql2);
$rows2=$result2->fetch_object();

$uname=$rows2->username;


echo'<p><a href="profile.php?name='.$uname.'">'.$uname.'</a> '.$notif.' '.$date.'</p>';
}


?>