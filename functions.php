<?php
date_default_timezone_set('Asia/Manila');

function companytitle(){
	echo'RainbowDream';
}

function updateStatus(){
	if(isset($_SESSION['id'])){
		$conn = new mysqli('localhost','root','','itsproject');
		$id=$_SESSION['id'];
		$sql="UPDATE tbluser SET lastonline=NOW() WHERE userid=$id";
		$result=$conn->query($sql);
		mysqli_close($conn);
	}
}

function addheader(){
	echo'<header id="main-header">
			<div class="grid-header">
				<div class="box1">
					<h1 id="header-text"><a href="index.php"><span id="first-text">Rainbow</span><span id="second-text">Dream</span></a></h1>
				</div>
				<div class="box2">';
					
						search_function();
					
				echo'</div>
				<div class="modal2">
				</div>
				<div id="search-dropdown">

				</div>
			</div>
		</header>
	<!-- Sub Header -->
		<div class="subheader">
			<div class="subgrid">
				<div class="svg">
					<p class="open-slide" onclick="openSlideMenu()">
						<svg width="30" height="30">
							<path d="M0,5 30,5" stroke="#fafafa" stroke-width="5"/>
							<path d="M0,14 30,14" stroke="#fafafa" stroke-width="5"/>
							<path d="M0,23 30,23" stroke="#fafafa" stroke-width="5"/>	
						</svg>
					</p>
				</div>
				<div class="profile-grid">';
					
						session_button();
					
				echo'</div>
			</div>
		</div>
	';
}

function addfooter(){
	echo'<footer id="main-footer">
			<div class="container">
				<p>Copyright &copy; <span id="company">RainbowDream</span> | 2018</p>
			</div>
		</footer>';
}

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
	echo'<div id="sidebarmodal" onclick="closeSlideMenu()">
		</div>';
	if(isset($_SESSION["id"])){
		echo '
		<div id="sidebarmodal">
		</div>
		<div class="side-nav" id="side-menu">
			<ul>
				<li><p href="#" class="btn-close" onclick="closeSlideMenu()">&times;</p></li>';
				
				//If site admin
				if($_SESSION['type']==4){
					echo'<li><a title="Admin Panel" href="admin.php"><i class="fas fa-unlock-alt"></i></a></li>';
				}
				
				echo'<li><a title="Change your profile picture" href="insertphoto.php"><i class="fas fa-camera"></i></i></a></li>
				<li><a title="Edit your personal info" href="editinfo.php"><i class="fas fa-pen-square"></i></a></li>
				<li><a title="Change your account settings" href="accountsetting.php"><i class="fas fa-cog"></i></a></li>
				<li><a target="_blank" title="Like us on Facebook" href="https://www.facebook.com/"><i class="fab fa-facebook-square"></i></a></li>
				<li><a target="_blank" title="Follow us on Twitter" href="https://twitter.com/"><i class="fab fa-twitter"></i></a></li>
				<li><a target="_blank" title="Follow us on Instagram" href="https://www.instagram.com/?hl=ens"><i class="fab fa-instagram"></i></a></li>
				<li><a title="Logout" href="logout.php"><i class="fas fa-power-off"></i></a></li>
			</ul>
		</div>';
	}else{
	echo'
		<div class="side-nav" id="side-menu">
			<ul>
				<li><p href="#" class="btn-close" onclick="closeSlideMenu()">&times;</p></li>
				<li><a target="_blank" title="Like us on Facebook" href="https://www.facebook.com/"><i class="fab fa-facebook-square"></i></a></li>
				<li><a target="_blank" title="Follow us on Twitter" href="https://twitter.com/"><i class="fab fa-twitter"></i></a></li>
				<li><a target="_blank" title="Follow us on Instagram" href="https://www.instagram.com/?hl=ens"><i class="fab fa-instagram"></i></a></li>
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
$sql="SELECT pmid FROM tblpm WHERE receiverid='$id' AND checked=0 GROUP BY senderid";
$result=$conn->query($sql);
$count=$result->num_rows;
		echo'<a class="button" title="Check your messages" href="inbox.php?name='.$_SESSION["name"].'"><i class="far fa-envelope"></i><span id="pmnum">'.$count.'</span></a>';

//Notification Count

$sql="SELECT notifid,username,imgpath,receiverid,notifdate,notiftype,checked,details,details2 FROM tblnotif
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
$date=time_elapsed_string($rows->notifdate);
$type=$rows->notiftype;

$imgpath=$rows->imgpath;
$uname=$rows->username;
$details=$rows->details;
$details2=$rows->details2;
if(!$imgpath){
	$imgpath='img/default.png';
}

if($type==1){


	echo'<li><div class="comment-tn">
				<img src="'.$imgpath.'">
			</div> <a class="n1" href="profile.php?name='.$uname.'">'.$uname.'</a> <a class="n2" href="profile.php?name='.$_SESSION['name'].'#comment'.$details.'"> has commented on your profile '.$date.'</a></li>';
} else if($type==2){
	if ($details2==1){
	echo'<li><div class="comment-tn">
				<img src="'.$imgpath.'">
			</div>
			 <a class="n1" href="profile.php?name='.$uname.'">'.$uname.'</a> has sent a friend request '.$date.'<br>
		<div id="fr-'.$nid.'"><a class="fr-yes" onclick="friendyes()" value="'.$nid.'">Yes</a> <a class="fr-no" onclick="friendno()" value="'.$nid.'">No</a>
		</div>
		</li>';
	} else if($details2==2){
		echo'<li><div class="comment-tn">
				<img src="'.$imgpath.'">
			</div>
			 <a class="n1" href="profile.php?name='.$uname.'">'.$uname.'</a> has sent a friend request '.$date.'<br>
		<div id="fr-'.$nid.'">
			Request Accepted
		</div>
		</li>';
	} else if($details2==3){
		echo'<li><div class="comment-tn">
				<img src="'.$imgpath.'">
			</div>
			 <a class="n1" href="profile.php?name='.$uname.'">'.$uname.'</a> has sent a friend request '.$date.'<br>
		<div id="fr-'.$nid.'">
			Request Denied
		</div>
		</li>';
	}
}
}
}

		echo'<center><a id="seeallnotif" href="notification.php">See all notifications</a></center>
		</ul>
		</div>';
	}else{
		echo'<a href ="register.php" class="button"><i class="fas fa-pencil-alt"></i></i>Sign Up</a>
		<a id="modalBtn" class="button"><i class="fas fa-sign-in-alt"></i>Login</a>';
	}
}

function search_function(){
	echo'
		<form action="search.php" method="get">
			<i class="fas fa-search"></i>
			<label>Search</label>
			<input type="text" onkeyup="searchdropdown()" required name="search-text" id="search-text" autocomplete="off" placeholder="Search user...">
		</form>
	';
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
	if(isset($_SESSION['id'])){
		if($_SESSION['type']!=4){
			header('Location: index.php');
		}
	}
}

function adminpanelAccess(){
	if(isset($_SESSION['admin'])){
		if($_SESSION['admin']!='IchigoParfait'){
			header('Location: admin.php');
		}
	}
}

function admingoback(){
	if(isset($_SESSION['admin'])){
		if($_SESSION['admin']=='IchigoParfait'){
			header('Location: adminpanel.php');
		}
	}
}