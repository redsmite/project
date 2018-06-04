<!-- Side Menu -->
<?php

function addSidebar(){
	echo'
<div class="side-nav" id="side-menu">
	<ul>
		<li><p href="#" class="btn-close" onclick="closeSlideMenu()">&times;</p></li>
		<?php
			if(isset($_SESSION["id"])){
			echo"<li><a title="Go to your profile" href="profile.php"><i class="fas fa-user-alt"></i></a></li>";
		}?>
		<li><a title="Like us on Facebook" href="#"><i class="fab fa-facebook-square"></i></a></li>
		<li><a title="Follow us on Twitter" href="#"><i class="fab fa-twitter"></i></a></li>
		<li><a title="Follow us on Instagram" href="#"><i class="fab fa-instagram"></i></a></li>
		<li><a title="Subscribe to our Youtube Channel" href="#"><i class="fab fa-youtube"></i></a></li>
		<li><a title="Follow us on LinkedIn" href="#"><i class="fab fa-linkedin"></i></a></li>
	</ul>
</div>';
}

// Login Pop Out
function addLogin(){
	echo'<div id="simpleModal" class="modal">
			<div class="modal-content">
				<div class="modal-header">
					<span id="closeBtn">&times;</span>	
					<h5>Login Form</h5>
				</div>
				<div class="modal-body">
					<form action="loginprocess.php" method="post" id="log-form" >
						<center><label for="">Username:</label>
						<input type="text" required name="username" id="log-user" placeholder="Enter Username...">
						<br>
						<label for="">Password:</label>
						<input type="password" required name="password" id="log-pass" placeholder="Enter Password...">
						<br>
						<label for="">Remember Me?</label>
						<input type="checkbox" id="log-remember" name="remember">
						<br>
						<input type="submit" class="modal-button" value="Login"></center>
					</form>
					<div id="error-message"></div>	
				</div>
				<div class="modal-footer">
					<a href="register.php">Doesn\'t have an account?</a>
				</div>
			</div>
		</div>
	';
}

function session_button(){
	if(isset($_SESSION['id'])){
		echo'Hello ' 
		
			 .$_SESSION["name"].'!
		
		<a href="logout.php" class="button"><i class="fas fa-sign-out-alt"></i>LOGOUT</a>';
	}else{
		echo'<a id="modalBtn" class="button"><i class="fas fa-sign-in-alt"></i>LOGIN</a>';
	}
}

function profile_button(){
	
}

function adminAccess(){
	session_start();
	if($_SESSION['usertype']!=3){
		die('You cannot access this page');
	}
}