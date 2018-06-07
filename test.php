<?php
	session_start();
	require_once'connection.php';
	include'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  	<link rel="stylesheet" href="css/style.css">
  	<link rel="stylesheet" href="css/fontawesome-all.css">
	<title>Test</title>
</head>
<body>
	<?php
		echo $_SESSION['name'].'<br>';
		

		echo time_elapsed_string('2018-06-07 22:50:43');
	?>

	<form action="" method="POST" enctype="multipart/form-data">
		<table align="center">
			<h2 align="center">Image Insertion</h2>
			<tr>
				<td><label>Image</label></td>
				<td><label>:</label></td>
				<td><label><input type="file" name="img" required/></label></td>
			</tr>
			<tr>
				<td><label></label></td>
				<td><label></label></td>
				<td><label><input type="submit" name="save_btn" value="SAVE" required/></label></td>
			</tr>
		</table>
	</form>
	<?php
		if(isset($_POST['save_btn'])){
			$username=$_SESSION['name'];
			$filetemp=$_FILES['img']['tmp_name'];
			$filename=$_FILES['img']['name'];
			$filetype=$_FILES['img']['type'];
			$filepath="upload/".$filename;

			move_uploaded_file($filetemp, $filepath);
			$sql="UPDATE tbluser SET imgname='$filename',imgtype='$filetype',imgpath='$filepath' WHERE username='$username'";
			$result=$conn->query($sql) or die($conn->error());

			if($result){
				echo 'Success';
			}
		}
		$sql2="SELECT imgpath FROM tbluser WHERE username='$username'";
		$result2=$conn->query($sql2) or die($conn->error());
		$rows=$result2->fetch_object();
		$image=$rows->imgpath;
	?>
	<img src="<?php echo $image; ?>">
</body>
</html>