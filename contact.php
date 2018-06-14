<?php
	session_start();
	include'functions.php';
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
			<h1>Contact Us</h1>
			<div class="container">
				<div class="content-box">
					<h2><span id="highlight-text">Get</span> in Touch</h2>		
					<div class="form">
						<center>
							<p>Please don't spam or you'll die.</p>
							<form action="#" method="post">
								<div>
									<label for="name">Name</label><br>
									<input type="text" required name="contact-name">
								</div>
								<div>
									<label for="email">Email</label><br>
									<input type="email" required name="contact-email">
								</div>
								<div>
									<label for="message">Message</label><br>
									<textarea name="message" required name="contact-message"></textarea>
								</div>
								<button type="submit" name="contact-button">Submit</button>
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
		activepage('#main-nav4');
		modal();
		ajaxLogin();
	</script>
</body>
</html>