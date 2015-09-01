<!DOCTYPE html>
<html lang="en" ng-app="FoodInventory">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- Font Awesome -->
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />

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
		<script type="text/javascript" src="../services/product.js"></script>
		<script type="text/javascript" src="../services/movement.js"></script>
		<script type="text/javascript" src="../services/vendor.js"></script>
		<script type="text/javascript" src="../services/location.js"></script>
		<script type="text/javascript" src="../controllers/modal-instance-ctrl.js"></script>
		<script type="text/javascript" src="../controllers/product.js"></script>
		<script type="text/javascript" src="../controllers/tab-controller.js"></script>
		<script type="text/javascript" src="../controllers/movement.js"></script>
		<script type="text/javascript" src="../controllers/vendor.js"></script>
		<script type="text/javascript" src="../controllers/location.js"></script>
		<script type="text/javascript" src="../directives/logout.js"></script>
		<script type="text/javascript" src="../directives/product.js"></script>
		<script type="text/javascript" src="../directives/movement.js"></script>
		<script type="text/javascript" src="../directives/vendor.js"></script>
		<script type="text/javascript" src="../directives/location.js"></script>
<!--		<script type="text/javascript" src="../directives/notification.js"></script>-->

		<!-- Page Title -->
		<title>Administration</title>
	</head>

	<body>
		<section class="container">
			<!--  Admin Panel Sidebar  -->
			<div class="vertical-text col-md-1">
				<h1 class="text-center">Admin-Panel</h1>
			</div>

			<!-- Admin Tabs  -->
			<section class="col-md-11" ng-controller="TabController as tab">
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
					<li>
						<logout></logout>
					</li>
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
		</section>
	</body>
</html>