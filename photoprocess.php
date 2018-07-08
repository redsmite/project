<?php
session_start();
include'functions.php';
user_access();
require_once'connection.php';


if(isset($_POST['img'])){
	$imgname = $_FILES['img']['name'];

	echo $imgname;
}

// $id=$_SESSION['id'];

// if(isset($_POST['remove'])){
// 		$sql = "UPDATE tbluser SET imgname='',imgtype='',imgpath='' WHERE userid='$id'";  
// 		$conn->query($sql);
// 		echo("<script>window.location.href = 'profile.php?name=".$_SESSION['name']."';</script>");	
// }

// //upload photo
// if(isset($_POST['submit'])){
// 	$error='';
	
// 	if(!$_FILES['img']['tmp_name']){
// 		echo'<div id="error-message2"><i class="fas fa-exclamation-circle"></i>File is empty. Select an image to upload.</div>';
// 	}else{

// 	$filetemp=$_FILES['img']['tmp_name'];
// 	$filename=$_FILES['img']['name'];
// 	$filetype=$_FILES['img']['type'];
// 	$filepath="upload/".$filename;
// 	if($filetype != "image/jpg" && $filetype != "image/png" && $filetype != "image/jpeg"
// 	&& $filetype != "image/gif") {
// 	     echo'<div id="error-message2"><i class="fas fa-exclamation-circle"></i>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>';
// 	 	$error=1;
// 	}

// 	if (filesize($filetemp) > 500000) {
// 	    echo'<div id="error-message2"><i class="fas fa-exclamation-circle"></i>Sorry, your file is too large. <strong>Maximum: 500kb.</strong></div>';
// 	    $error=1;
// 	}


// 	if($error==''){
// 		move_uploaded_file($filetemp, $filepath);
// 		$filename=$conn->real_escape_string($filename);
// 		$filetype=$conn->real_escape_string($filetype);
// 		$filepath=$conn->real_escape_string($filepath);
// 		$sql="UPDATE tbluser SET imgname='$filename',imgtype='$filetype',imgpath='$filepath' WHERE userid='$id'";
// 		$result=$conn->query($sql) or die($conn->error());

// 		if($result){
// 			echo("<script>window.location.href = 'profile.php?name=".$_SESSION['name']."';</script>");
// 		}
// 	}
// 	}
// }
?>