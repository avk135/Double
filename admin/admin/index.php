<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="/admin/folders/style/style.css" rel="stylesheet">
</head>

<body>
	<div class="home">
		<div class="container">
			<?php
			require 'db.php';
			?>

			<?php if (isset($_SESSION['logged_user'])) : ?>
				Авторизован! <br />
				Привет, <?php echo $_SESSION['logged_user']->login; ?>!<br />

				<a href="logout.php">Выйти</a>
				<a href="/file-user.php">Вся музыка</a>

			<?php else : ?>
				Вы не авторизованы<br />
				<a href="/login.php">Авторизация</a>
			<?php endif; ?>
		</div>
	</div>
</body>

</html>