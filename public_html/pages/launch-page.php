<?php
$CURRENT_DIR = __DIR__;
?>

<!DOCTYPE html>
<html lang="en">
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

			</div>
			<main class="home">
				<section class="col-xs-3 leftgraphic text-center">
					<h3>The Difference</h3>
				</section>

				<section class="col-xs-6 testimonials text-center">
					<h3>Testimonials</h3>
				</section>

				<section class="col-xs-3 rightgraphic text-center">
					<h3>About</h3>
				</section>
			</main>
		</div>
		<footer>
			<?php require_once "footer.php"; ?>
		</footer>
	</body>
</html>
