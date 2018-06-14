<?php
	session_start();
	include'functions.php';
	user_nonAccess();
	addSidebar();
	addLogin();
	setupCookie();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
  	<link rel="stylesheet" href="css/fontawesome-all.css">
	<title><?php companytitle()?></title>
</head>
<body>
	<div class="main-container">
	<!-- Header -->
	<?php
		addheader();
	?>
	<!-- Contact Form -->
		<div class="other-content">
			<h1>Register</h1>
			<div class="container">
				<div class="content-box">
					<h2><span id="highlight-text">Join</span> Us Today</h2>
					<div class="form">
						<center>	
						<p>*Required</p>
						<form action="registerprocess.php" id="reg-form" method="post">
							<div class="grid-register">
								<div class="box-reg1">
									<div>
										<label for="">*Username</label><br>
										<input type="text" required id="reg-name" placeholder="Enter Username...">
									</div>
									<div>
										<label for="">*Email</label><br>
										<input type="email" required id="reg-email" placeholder="Enter Email...">
									</div>
									<div>
										<label for="">*Password</label><br>
										<input type="password" required id="reg-password" placeholder="Enter Password...">
									</div>
									<div>
										<label for="">*Re-type Password</label><br>
										<input type="password" required id="reg-retype" placeholder="Retype Password...">
									</div>
									<div>
										<label for="">First Name (optional)</label><br>
										<input type="text" id="reg-first" placeholder="Enter First Name...">
									</div>
									<div>
										<label for="">Last Name (optional)</label><br>
										<input type="text" id="reg-last" placeholder="Enter Last Name...">
									</div>
								</div>
								<div class="box-reg2">
									<div id="gender-box">
										<label for="">*Gender</label><br><input type="radio" checked required name="gender" value="1"> Male
  										<input type="radio" name="gender" value="2"> Female
  										<input type="radio" name="gender" value="3"> Non-Binary
									</div>
									<div>
										<label for="">Nickname (optional)</label><br>
										<input type="text" id="reg-middle" placeholder="Enter Nickname...">
									</div>
									<div>
										<label for="">Birthday (optional)</label><br>
										<input type="date" id="reg-birthday">
									</div>
									<div>
										<label for="">Website (optional)</label><br>
										<textarea id="reg-website"></textarea>
									</div>
									<div>
										<label for="">Location (optional)</label><br>
										<textarea id="reg-location"></textarea>
									</div>
									<div>
										<button type="submit" name="contact-button" id="contact-button">Submit</button>
									</div>
								</div>
								<div id="error-message2"></div>								
							</div>	
						</form>
						</center>
					</div>
				</div>
			</div>
		</div>
	<!-- Footer -->
		<?php
			addfooter();
		?>
	<!-- End of Container -->
	</div>
	<script src="js/main.js"></script>
	<script>
		modal();
		ajaxRegister();
		ajaxLogin();
	</script>
</body>
</html>