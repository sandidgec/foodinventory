<?php
require_once(dirname(dirname(dirname(__DIR__))) . "/backend/php/classes/autoload.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>
<!DOCTYPE html>
<html lang="en" ng-app="FoodInventory">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- Font Awesome -->
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"/>

		<!-- Google Font -->
		<link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>

		<!-- Bootstrap Latest compiled and minified CSS -->
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>

		<!-- Optional Bootstrap theme -->
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" rel="stylesheet"/>

		<!-- LINK TO YOUR CUSTOM CSS FILES HERE -->
		<link type="text/css" href="../../css/admin-panel.css" rel="stylesheet"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script type="text/javascript" src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

		<!-- Latest compiled and minified Bootstrap JavaScript, all compiled plugins included -->
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

		<!-- angular.js -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular-route.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular-messages.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.13.0/ui-bootstrap-tpls.min.js"></script>
		<script type="text/javascript" src="../food-inventory.js"></script>
		<script type="text/javascript" src="../services/login.js"></script>
		<script type="text/javascript" src="../services/user.js"></script>
		<script type="text/javascript" src="../services/product.js"></script>
		<script type="text/javascript" src="../services/movement.js"></script>
		<script type="text/javascript" src="../services/vendor.js"></script>
		<script type="text/javascript" src="../services/location.js"></script>
		<script type="text/javascript" src="../services/notification.js"></script>
		<script type="text/javascript" src="../services/alert.js"></script>
		<script type="text/javascript" src="../controllers/login.js"></script>
		<script type="text/javascript" src="../controllers/modal-instance-ctrl.js"></script>
		<script type="text/javascript" src="../controllers/tab-controller.js"></script>
		<script type="text/javascript" src="../controllers/product.js"></script>
		<script type="text/javascript" src="../controllers/movement.js"></script>
		<script type="text/javascript" src="../controllers/vendor.js"></script>
		<script type="text/javascript" src="../controllers/location.js"></script>
		<script type="text/javascript" src="../controllers/notification.js"></script>
		<script type="text/javascript" src="../controllers/alert.js"></script>
		<script type="text/javascript" src="../directives/logout.js"></script>
		<script type="text/javascript" src="../directives/product.js"></script>
		<script type="text/javascript" src="../directives/movement.js"></script>
		<script type="text/javascript" src="../directives/vendor.js"></script>
		<script type="text/javascript" src="../directives/location.js"></script>
		<script type="text/javascript" src="../directives/notification.js"></script>
		<script type="text/javascript" src="../directives/alert.js"></script>

		<!-- Page Title -->
		<title>Administration</title>
	</head>

	<body class="adminback">
		<?php
		if(empty($_SESSION["user"]) === false && $_SESSION["user"]->getUserId() > 0) {
			?>
			<section class="container">
				<!--  Admin Panel Sidebar  -->
				<div class="vertical-text col-md-1">
					<h1 class="text-center adminpanel">Admin-Panel</h1>
				</div>

				<!-- Admin Tabs  -->
				<section class="col-md-10" ng-controller="TabController as tab">
					<ul class="nav nav-pills">
						<li ng-class="{ active:tab.isSet(1) }">
							<a href="" ng-click="tab.setTab(1)">Product</a>
						</li>
						<li ng-class="{ active:tab.isSet(2) }">
							<a href="" ng-click="tab.setTab(2)">Movement</a>
						</li>
						<li ng-class="{ active:tab.isSet(3) }">
							<a href="" ng-click="tab.setTab(3)">Vendor</a>
						</li>
						<li ng-class="{ active:tab.isSet(4) }">
							<a href="" ng-click="tab.setTab(4)">Location</a>
						</li>
						<li ng-class="{ active:tab.isSet(5) }">
							<a href="" ng-click="tab.setTab(5)">Notification</a>
						</li>
						<li> <?php require_once "logout.php"; ?></li>
					</ul>

					<!--  Product Tab's Contents  -->
					<div ng-show="tab.isSet(1)">
						<product></product>
					</div>

					<!--  Movement Tab's Contents  -->
					<div ng-show="tab.isSet(2)">
						<movement></movement>
					</div>

					<!--  Vendor Tab's Contents  -->
					<div ng-show="tab.isSet(3)">
						<vendor></vendor>
					</div>

					<!--  Location Tab's Contents  -->
					<div ng-show="tab.isSet(4)">
						<location></location>
					</div>

					<!--  Notification Tab's Contents  -->
					<div ng-show="tab.isSet(5)">
						<notification></notification>
					</div>
				</section>

				<div class="vertical-text-rev col-md-1">
					<h1 class="text-center invtext">Inventory-Text</h1>
				</div>

			</section>
		<?php
		} else {
			?>
			<section>

				<div class="headtext"><a href="../../../pages/launch-page.php"><span class="inv">Inventory</span><span class="text">TEXT</span></a></div>

				<nav class="navbar pull-right main-menu">
					<div class="navbar-header">
						<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#main-menu">
							<span class="sr-only">Menu</span>
							<span class="glyphicon glyphicon-menu-hamburger"></span>
						</button>
					</div>

					<div class="collapse navbar-collapse" id="main-menu">
						<ul class="nav navbar-nav navbar-right">
							<li><?php require_once("signup.php"); ?></li>
							<li><?php require_once("login.php"); ?></li>
						</ul>
					</div>
				</nav>
				<h2>Please Log In </h2>
				<?php var_dump($_SESSION); ?>
			</section>
		<?php
		}
		?>
	</body>
</html>