<?php
	session_start();
	include'functions.php';
	updateStatus();
	addSidebar();
	setupCookie();
	addLogin();
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
	<!-- Main Content -->
		<div class="other-content">
			<h1><i class="fas fa-info-circle"></i> About</h1>
			<div class="container">
				<div class="content-box">
					<h2><span id="highlight-text">What</span> is this site?</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, sunt aliquam ipsum officia molestiae cum amet natus totam. At soluta, molestiae dicta! Illum dicta temporibus nobis architecto assumenda, perferendis, aperiam hic excepturi suscipit, quaerat sit enim perspiciatis amet accusamus nam, eveniet labore dignissimos! Veritatis, consequuntur, dolorem! Velit magnam laboriosam in, veritatis labore? Voluptatum cupiditate saepe excepturi fugit officia nam, ipsum doloribus officiis omnis nihil eligendi vitae sit velit assumenda quas tempore commodi nesciunt quidem eos. Architecto ad, provident quo. Obcaecati molestiae similique repellendus voluptatem necessitatibus. Exercitationem dolorum, quam recusandae repellendus iste laudantium laboriosam autem. Corporis et sequi optio veniam deleniti totam, eaque ipsum tenetur voluptatem, id vel mollitia laudantium dolores, ut saepe. Quos, quo porro eum accusamus omnis. Nam facilis corporis est reiciendis accusamus cum officia repellat perferendis adipisci consequatur, iste voluptatibus, aspernatur fugiat eum alias aut iure ducimus earum ipsum ipsa esse velit eaque delectus laboriosam. Ducimus modi eos ut reprehenderit, consequatur consequuntur iusto. Consectetur laudantium accusantium vel porro voluptates, voluptatum voluptatibus eos excepturi aperiam tempora, possimus iure quos itaque tempore culpa illo unde a libero veniam ipsa dicta in esse. Ab ad temporibus cumque rerum natus voluptatum, sunt quod eligendi quam, magnam? Sed, quo! Esse a ab accusamus!</p>
				</div>
				<div class="content-box">
					<h2 class="next-h2"><span id="highlight-text">F</span>AQ</h2>
					<h3>Lorem ipsum dolor sit amet, consectetur adipisicing elit?</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero rerum deserunt ea repellendus dicta saepe nostrum laudantium sint quibusdam fuga, animi eaque distinctio adipisci aliquid vel facere repellat eligendi voluptatem numquam architecto obcaecati et, enim hic. Veritatis labore, consectetur illo.</p>
					<h3>Lorem ipsum dolor sit amet, consectetur?</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta porro ex, illo illum dolore officia! Voluptatum veritatis aliquam a, fuga blanditiis impedit! Commodi numquam, delectus.</p>
					<h3>Lorem ipsum dolor sit amet, consectetur adipisicing?</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas doloribus aliquid dolorum quisquam sed debitis, numquam soluta! Suscipit enim assumenda illum esse unde, sunt eos ipsam earum quisquam sint molestias, nemo dolore perspiciatis. Architecto, ad.</p>
					<h3>Lorem ipsum dolor sit amet, consectetur adipisicing elit.?</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos iure culpa rerum libero provident voluptatem velit autem, ab est commodi ipsum tempora quisquam a molestias, sed assumenda minima!</p>
					<h3>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet, rerum?</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia dolore doloribus dignissimos odio animi deleniti laboriosam. Praesentium itaque iure repudiandae doloribus debitis laboriosam explicabo, deleniti autem. Sequi quidem eum eveniet. Error, est?</p>
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
		activepage('#main-nav2');
		modal();
		ajaxLogin();
	</script>
</body>
</html>