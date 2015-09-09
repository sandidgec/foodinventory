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
				<h2 class="about">About your new employee.</h2><br>
				<h5 class="abouttext">Your new employee is on board to help any small business owner that needs inventory management that intuitively
					messages you when key inventory items reach a low level so the small business owner can stay ahead of ordering new supplies and keeping
					the shelves fully stocked. A missed sale is a missed opportunity for a happy customer. </h5>
			</div>

			<div class="col-md-12 testys ">
				<h3>Features</h3>
			</div>

			<section class="col-xs-3 leftabout text-center">
				<h6>Concise Inventory Control, you can add, edit and delete inventory items with ease.</h6>
			</section>

			<section class="col-xs-6 centerabout text-center">
				<h6>Do you create new finished products from your inventory? You can use Inventory text to automatically remove those raw items
					when you add the new finished item into inventory. Simple. Effective.</h6>
			</section>

			<section class="col-xs-3 rightabout text-center">
				<h6>Automated reports triggered by custom inventory alert levels set by the business owner.</h6>
			</section>

		</div>
		<footer>
			<?php require_once "footer.php"; ?>
		</footer>
	</body>
</html>
