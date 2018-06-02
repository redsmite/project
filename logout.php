<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
  	<link rel="stylesheet" href="css/fontawesome-all.css">
	<title>This Company</title>
</head>
<body>
	<div class="main-container">
		<div id="thanks-message">
			<h1><i class="far fa-check-circle"></i>You have Logout</h1>
			<p>You have successfully logout.</p>
			<p>This page will be redirected shortly.</p>
			<a href="index.php">Click here to redirect</a>
		</div>
	</div>

	<script>

		sessionStorage.removeItem('id');
		sessionStorage.removeItem('username');
		sessionStorage.removeItem('usertype');

		setTimeout(function () {
			  
		window.location.href= 'index.php';
		}, 5000);
	</script>
</body>
</html>