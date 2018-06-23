<?php
	session_start();
	require_once'connection.php';
	include'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  	<link rel="stylesheet" href="css/style.css">
  	<link rel="stylesheet" href="css/fontawesome-all.css">
	<title>Test</title>
</head>
<body>
	<script>
		var messages = [
		'We should work towards world peace.',
		'Finally... Mayushii was... useful.',
		'Mayushii here! I\'ve become more wonderful! Kyaha',
		'Tuturuuuu',
		'Mayushii\'s in a good mood~♪',
		'Hrm. The next job\'s location.. wha, today\'s an off day... I see...',
		'Mayushii belongs to everyone, so don\'t touch her too much, okay?',
		'Mayushii\'s the best! The number one highlight!',
		'You\'re welcome here as always~!',
		'Even if this is boring, please don\'t hate Mayushii!',
		'I worked pretty hard right? praise me! Praise me!',
		'Nice to meet you! I\'m Mayushii! Thanks for having me!',
		'Mayushii here! Thanks for having me today as well.',
		'Thank you very much, it\'s Mayushii! Yes, I\'ll do my best!',
		'What would you like me to do next?',
		'I\'ll be resting for a bit.',
		'Let\'s be cheerful and go!',
		'I\'ll try my best again today!',
		'I-I can still keep going!',
		'Today feels like a good day.',
		'Yes! I\'ll work even harder',
		]
		var rand = Math.floor((Math.random() * messages.length-1) + 1);
		console.log(messages[rand]);
	</script>
</body>
</html>
<?php
	mysqli_close($conn);
?>