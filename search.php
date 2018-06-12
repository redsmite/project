<?php
session_start();
include'functions.php';
include'connection.php';
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
	<title></title>
</head>
<body>
	<div class="main-container">
	<!-- Header -->
		<header id="main-header">
			<div class="grid-header">
				<div class="box1">
					<h1 id="header-text"><a href="index.php"><span id="first-text"></span><span id="second-text"></span></a></h1>
				</div>
				<div class="box2">
					<nav class="main-nav">
						<ul class="header-list">
							<li><a href="index.php">HOME</a></li>
							<li><a href="about.php">ABOUT</a></li>
							<li><a href="services.php">SERVICES</a></li>
							<li><a href="contact.php">CONTACT</a></li>
						</ul>
					</nav>
				</div>
				<div class="box3">
					<?php
						search_function();
					?>
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
				<div class="profile-grid">
					<?php
						session_button()
					?>
				</div>
			</div>
		</div>
	<!-- Main Content -->
	<div class="other-content">
		<h1>Search User</h1>
		<ul class="search-ul">
<?php
if (empty($_GET['search-text'])){
	$_GET['search-text']='Show_All';
	echo '<p>Show All Users</p>';
}
if(isset($_GET['search-text'])){
	$search= $_GET['search-text'];

	if(!$search=='Show_All'){
		$sql="SELECT userid FROM tbluser WHERE username LIKE '$search%'";
	}else if($search=='Show_All'){
		$sql="SELECT userid FROM tbluser";	
	}

	$result=$conn->query($sql);

	if($result->num_rows==0){
		echo'No results found';
	}
	$rows=$result->num_rows;
	$page_rows = 10;
	$last = ceil($rows/$page_rows);
	if($last < 1){
		$last = 1;
	}
	$pagenum = 1;
	if(isset($_GET['pn'])){
		$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
	}
	if ($pagenum < 1) { 
	    $pagenum = 1; 
	} else if ($pagenum > $last) { 
	    $pagenum = $last; 
	}
	$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;

	if(!$search=='Show_All'){
	$sql="SELECT username,imgpath,datecreated FROM tbluser WHERE username LIKE '$search%' ORDER BY username $limit";
	}else if($search=='Show_All'){
		$sql="SELECT username,imgpath,datecreated FROM tbluser ORDER BY username $limit";	
	}
	$textline1 = "Users (<b>$rows</b>)";
	$textline2 = "Page <b>$pagenum</b> of <b>$last</b>";
	$paginationCtrls = '';
	if($last != 1){
		if ($pagenum > 1) {
	        $previous = $pagenum - 1;
			$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?search='.$search.'&pn='.$previous.'">Previous</a> &nbsp; &nbsp; ';
			for($i = $pagenum-4; $i < $pagenum; $i++){
				if($i > 0){
			        $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?search='.$search.'&pn='.$i.'">'.$i.'</a> &nbsp; ';
					}
			    }
		    }
		    $paginationCtrls .= ''.$pagenum.' &nbsp; ';
			for($i = $pagenum+1; $i <= $last; $i++){
				$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?search='.$search.'&pn='.$i.'">'.$i.'</a> &nbsp; ';
				if($i >= $pagenum+4){
					break;
				}
			}
			    if ($pagenum != $last) {
		        $next = $pagenum + 1;
		        $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?search='.$search.'&pn='.$next.'">Next</a> ';
		    }
		}
	 echo'<h2>  '.$textline1.'</h2>
	  <p>  '.$textline2.' </p>
	  <div id="pagination_controls"> '.$paginationCtrls.'</div>';



	$result=$conn->query($sql);

	while($row=$result->fetch_object()){
		$name = $row->username;
		$img = $row->imgpath;
		$date = date("M j, Y", strtotime($row->datecreated));
		if (!$img){
			$img='img/default.png';
		}

		echo'<li><a href="profile.php?name='.$name.'">
		<div class="sch-tn">
		<img src="'.$img.'">
		</div>
		<p>'.$name.'</a></p>
		<p>Joined: '.$date.'</p>
		<li>';

	}
}
mysqli_close($conn);
?>
		</ul>
	</div>
	<!-- Footer -->
		<footer class="main-footer">
			<div class="container">
				<p>Copyright &copy; <span id="company"></span> | 2018</p>
			</div>
		</footer>
	<!-- End of Container -->
	</div>
	<script src="js/main.js"></script>
	<script>
		modal();
		ajaxLogin();
	</script>
</body>
</html>
