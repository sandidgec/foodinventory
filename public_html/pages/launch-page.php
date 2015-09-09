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
			<header>
				<?php require_once "header.php"; ?>
			</header>
			<div class="warehouse">
				<h2 class="welcome">Welcome your new employee.</h2>
			</div>
		</div>
		<main class="home">

			<section class="col-xs-3 leftgraphic text-center">
				<img src="../lib/images/dylanhead.png" class="headshot" alt="testimonial pic">
				<p class="outtests">
					<p class="nametext"> - Dylan McDonald, Acme Inc.</p>

					<p class="testtext">"Being a small business owner, I've tried every inventory management software out there. Inventory Text is the easiest and most complete package I've come
					across. 10 out of 10!"
				</p>
			</section>

			<section class="col-xs-6 testimonials text-center">
				<h3></h3>

				<p class="test">
					<img src="../lib/images/invtextboxlogo.png" alt="box logo">
				</p>
			</section>

			<section class="col-xs-3 rightgraphic text-center">
				<img src="../lib/images/womanheadshot.jpg" class="headshot" alt="testimonial pic">
				<p class="outtests">
					<p class="nametext"> - Ann Miller, Cogs N' Things</p>

					<p class="testtext">"There's a million inventory management products, but Inventory Text really acts like an extra employee."</p>
				</p>
			</section>

		</main>
		<footer>
			<?php require_once "footer.php"; ?>
		</footer>
	</body>
</html>
