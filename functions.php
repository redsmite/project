<!-- Side Menu -->
<?php
date_default_timezone_set('Asia/Manila');

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
function addSidebar(){
	if(isset($_SESSION["id"])){
		echo '
		<div class="side-nav" id="side-menu">
			<ul>
				<li><p href="#" class="btn-close" onclick="closeSlideMenu()">&times;</p></li>
				<li><a title="Go to your profile" href="profile.php?name='.$_SESSION["name"].'"><i class="fas fa-user-alt"></i></a></li>
				<li><a title="Check your notifications" href="#"><i class="far fa-bell"></i></a></li>
				<li><a title="Check your private messages" href="privatemessage.php"><i class="far fa-envelope"></i></a></li>
				<li><a title="Like us on Facebook" href="#"><i class="fab fa-facebook-square"></i></a></li>
				<li><a title="Follow us on Twitter" href="#"><i class="fab fa-twitter"></i></a></li>
				<li><a title="Follow us on Instagram" href="#"><i class="fab fa-instagram"></i></a></li>
				<li><a title="Subscribe to our Youtube Channel" href="#"><i class="fab fa-youtube"></i></a></li>
				<li><a title="Follow us on LinkedIn" href="#"><i class="fab fa-linkedin"></i></a></li>
			</ul>
		</div>';
	}else{
	echo'
		<div class="side-nav" id="side-menu">
			<ul>
				<li><p href="#" class="btn-close" onclick="closeSlideMenu()">&times;</p></li>
				
				<li><a title="Like us on Facebook" href="#"><i class="fab fa-facebook-square"></i></a></li>
				<li><a title="Follow us on Twitter" href="#"><i class="fab fa-twitter"></i></a></li>
				<li><a title="Follow us on Instagram" href="#"><i class="fab fa-instagram"></i></a></li>
				<li><a title="Subscribe to our Youtube Channel" href="#"><i class="fab fa-youtube"></i></a></li>
				<li><a title="Follow us on LinkedIn" href="#"><i class="fab fa-linkedin"></i></a></li>
			</ul>
		</div>';
	}
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
		echo'<a class="button" href=profile.php?name='.$_SESSION['name'].'><i class="fas fa-user-alt"></i> '
			 .$_SESSION["name"].'\'s Profile</a>
		
		<a href="logout.php" class="button"><i class="fas fa-sign-out-alt"></i>Logout</a>';
	}else{
		echo'<a href ="register.php" class="button"><i class="fas fa-user-plus"></i>Sign Up</a>
		<a id="modalBtn" class="button"><i class="fas fa-sign-in-alt"></i>Login</a>';
	}
}

function setupCookie(){
	if(isset($_COOKIE['id'])){
		$_SESSION['id'] = $_COOKIE['id'];
		$_SESSION['name']= $_COOKIE['name'];
		$_SESSION['type']= $_COOKIE['type'];
	}
}

function destroyCookie(){
	if (isset($_COOKIE['id'])) {
	    
	    unset($_COOKIE['id']);
	    unset($_COOKIE['name']);
	    unset($_COOKIE['type']);

	    setcookie('id', '', time() - 3600, '/');
	    setcookie('name', '', time() - 3600, '/');
	    setcookie('type', '', time() - 3600, '/');
	}
}

function user_access(){
	if(!isset($_SESSION['id'])){
		header('location:index.php');
	}
}

function user_nonAccess(){
	if(isset($_SESSION['id'])){
		header('location:index.php');
	}
}

//Profile functions
function get_user_info(){
	//Get Profile Info

	if(!$name = $_GET['name']){
		die();
	}
	$sql="SELECT userid,username,firstname,middlename,lastname,birthday,datecreated,email,phoneno,address,usertypeid,image,bio FROM tbluser WHERE username='$name'";
	if(!$result=$conn->query($sql)){
		die('<div id="thanks-message">
			This page doesn\'t exist
			</div>');
	}

	$rows=$result->fetch_object();
	$id=$rows->userid;
	$user=$rows->username;
	$firstname=$rows->firstname;
	$lastname=$rows->lastname;
	$datecreated=$rows->datecreated;
	$email=$rows->email;
	$usertype=$rows->usertypeid;
	if(isset($rows->middlename)){
		$middlename=$rows->middlename;

	}else{
		$middlename='';
	}


	if(isset($rows->birthday)){
		$birthday=$rows->birthday;

	}else{
		$birthday='';
	}


	if(isset($rows->phoneno)){
		$phoneno=$rows->phoneno;

	}else{
		$phoneno='';
	}


	if(isset($rows->address)){
		$address=$rows->address;

	}else{
		$address='';
	}


	if(isset($rows->image)){
		$image=$rows->image;

	}else{
		$image='';
	}


	if(isset($rows->bio)){
		$bio=$rows->bio;

	}else{
		$bio='';
	}
}

function user_info(){

	get_user_info();

	echo'<h1>'.$user.'\'s Profile</h1>
		<h3>Date Joined:'.$datecreated.'</h3>
		<ul>
			<li>First Name:'.$firstname.'</li>
			<li>Middle Name:'.$middlename.'</li>
			<li>Last Name:'.$lastname.'</li>
		</ul>';
}

function adminAccess(){
	if($_SESSION['usertype']!=3){
		die('You cannot access this page');
	}
}