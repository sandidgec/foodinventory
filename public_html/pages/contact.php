<?php
$CURRENT_DIR = __DIR__;
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
				<h2 class="about">Contact Us Today.</h2><br>

				<?php require_once "emailform.php"; ?>

			</div>

			<div class="col-md-12 testys ">
				<h3>info@inventorytext.com</h3>
			</div>

		</div>
		<footer>
			<?php require_once "footer.php"; ?>
		</footer>
	</body>
</html>
