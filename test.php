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
		$timestamp = date("Y-m-d H:i:s");
		echo $timestamp;
	?>

	<input type="hidden" id="hidden" <?php echo 'value="'.$hidden.'"'?>/>
	<script>
		var rize = document.getElementById('hidden').value;

		console.log(rize)
	</script>
</body>
</html>