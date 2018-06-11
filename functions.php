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

function createlink($string){
$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i'; 
$string = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $string);
return $string;
}

//Sidebar
function addSidebar(){
	if(isset($_SESSION["id"])){
		echo '
		<div class="side-nav" id="side-menu">
			<ul>
				<li><p href="#" class="btn-close" onclick="closeSlideMenu()">&times;</p></li>
				<li><a title="Go to your profile" href="profile.php?name='.$_SESSION["name"].'"><i class="fas fa-user-alt"></i></a></li>
				<li><a title="Check your private messages" href="inbox.php?name='.$_SESSION["name"].'"><i class="far fa-envelope"></i></a></li>
				<li><a title="Change your profile picture" href="insertphoto.php"><i class="fas fa-camera"></i></i></a></li>
				<li><a title="Edit your personal info" href="editinfo.php"><i class="fas fa-pen-square"></i></a></li>
				<li><a title="Change your account settings" href="accountsetting.php"><i class="fas fa-cog"></i></a></li>
				<li><a title="Like us on Facebook" href="#"><i class="fab fa-facebook-square"></i></a></li>
				<li><a title="Follow us on Twitter" href="#"><i class="fab fa-twitter"></i></a></li>
				<li><a title="Follow us on Instagram" href="#"><i class="fab fa-instagram"></i></a></li>
				<li><a title="Logout" href="logout.php"><i class="fas fa-power-off"></i></a></li>
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
						<center><label for="">Username/Email:</label>
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
	$conn = mysqli_connect ("localhost", "root", "", "itsproject");
	if(isset($_SESSION['id'])){

	$id=$_SESSION['id'];
		$sql="SELECT imgpath FROM tbluser WHERE userid=".$id."";
		$result=$conn->query($sql);
		$row=$result->fetch_object();
		$tn_image=$row->imgpath;
		if($tn_image==''){
			$tn_image='img/default.png';
		}

//PM Count
$sql="SELECT pmid FROM tblpm WHERE receiverid='$id' AND checked=0";
$result=$conn->query($sql);
$count=$result->num_rows;
		echo'<a class="button" title="Check your private messages" href="inbox.php?name='.$_SESSION["name"].'"><i class="far fa-envelope"></i><span id="pmnum">'.$count.'</span></a>';

//Notification Count

$sql="SELECT notifid,username,receiverid,notif,notifdate,notiftype FROM tblnotif
	LEFT JOIN tbluser
		ON tblnotif.userid=tbluser.userid
	WHERE receiverid='$id' and checked=0
	ORDER BY notifid DESC";
$result=$conn->query($sql);
$count=$result->num_rows;

		echo'<a class="button" id="notifbtn" title="Check your notifications" onclick="toggleNotif()""><i class="far fa-bell"></i><span id="notifnum">'.$count.'</span></a>
		<a class="button" href=profile.php?name='.$_SESSION['name'].'>
		'.$_SESSION["name"].'\'s Profile<div class="top-tn"><img src="'.$tn_image.'""></div></a>';
		echo'<div id="notifdrop">
		Notifications
		<ul>';

//Notification Drop down
if($count==0){
	echo'<li>No notifications yet...</li>';
}else{

while($rows=$result->fetch_object())
{
$nid=$rows->notifid;
$uname=$rows->username;
$rid=$rows->receiverid;
$notif=$rows->notif;
$date=time_elapsed_string($rows->notifdate);
$type=$rows->notiftype;

$uname=$rows->username;


if($type==1){

	echo'<li><i class="far fa-comment-dots"></i> <a href="profile.php?name='.$uname.'">'.$uname.'</a> '.$notif.' '.$date.'</li>';
}
}
}

		echo'<center><a href="notification.php">See all notifications</a></center>
		</ul>
		</div>';
	}else{
		echo'<a href ="register.php" class="button"><i class="fas fa-pencil-alt"></i></i>Sign Up</a>
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

function adminAccess(){
	if($_SESSION['usertype']!=3){
		die('You cannot access this page');
	}
}