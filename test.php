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

	
		<audio id='myAudio'>
  			<source src='audio/tuturumayushiidesuring.mp3' type='audio/mpeg'>
		</audio>
		<button onclick="playAudio()" type="button">Play Audio</button>
	<script>
		

		var x = document.getElementById("myAudio"); 

function playAudio() { 
    x.play(); 
}	 
	</script>
</body>
</html>
<?php
	mysqli_close($conn);
?>