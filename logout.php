<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
  	<link rel="stylesheet" href="css/fontawesome-all.css">
	<title>Notification</title>
</head>
<body>
	<div class="main-container">
		<div id="thanks-message">
			<h1><i class="far fa-check-circle"></i>You have Logout</h1>
			<p>You have successfully logout.</p>
			<p>This page will be redirected shortly.</p>
			<a href="#" id='redirectlink'>Click here to redirect</a>
		</div>
	</div>
	<script src="js/main.js"></script>
	<script>
		redirectPage();
		removeSession();
	</script>
</body>
</html>