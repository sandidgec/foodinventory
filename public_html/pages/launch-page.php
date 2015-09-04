<?php
$CURRENT_DIR = __DIR__;
require_once(dirname(__DIR__) . "/backend/php/classes/autoload.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>

<!DOCTYPE html>
<html lang="en" ng-app="FoodInventory">
	<head>
		<?php require_once "head-utils.php"; ?>
	</head>
	<body class="site">
		<div class="site-content">
			<div class="gradient">
				<header>
					<?php require_once "header.php"; ?>
				</header>

				<div class="placeholder"></div>
				<h2 class="welcome">Welcome your new employee.</h2>
				<img class="center-block" src="../lib/images/invtextboxlogo.png"  alt="Logo Image">
			</div>
			<main class="home">

				<section class="col-xs-3 leftgraphic text-center">
				</section>

				<section class="col-xs-6 testimonials text-center">
					<h3>Testimonials</h3>
					<p class="test">
						"This is inventory management done right, and done better!" - John Smith
					</p>
				</section>

				<section class="col-xs-3 rightgraphic text-center">
				</section>

			</main>
		</div>
		<footer>
			<?php require_once "footer.php"; ?>
		</footer>
	</body>
</html>
