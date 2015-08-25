<!DOCTYPE html>
<html lang="en" ng-app="FoodInventory">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- Bootstrap Latest compiled and minified CSS -->
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>

		<!-- Optional Bootstrap theme -->
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" rel="stylesheet"/>

		<!-- LINK TO YOUR CUSTOM CSS FILES HERE -->
		<link type="text/css" href="../lib/css/styles.css" rel="stylesheet"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script type="text/javascript" src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.1/additional-methods.min.js"></script>

		<!-- Latest compiled and minified Bootstrap JavaScript, all compiled plugins included -->
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

		<!-- angular.js -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.min.js"></script>
		<script type="text/javascript" src="../food-inventory.js"></script>
		<script type="text/javascript" src="../services/movement.js"></script>
		<script type="text/javascript" src="../controllers/movement.js"></script>

		<!-- Page Title -->
		<title>Administration</title>
	</head>

	<body>
		<!--  Store Header  -->
		<header>
			<h1 class="text-center">Admin Panel</h1>
			<h2 class="text-center">Do Your Thing</h2>
		</header>

		<!-- Admin Tabs  -->
		<section ng-controller="TabController as tab">
			<ul class="nav nav-pills">
				<li ng-class="{ active:tab.isSet(1) }">
					<a href="" ng-click="tab.setTab(1)">Product</a>
				</li>
				<li ng-class="{ active:tab.isSet(2) }">
					<a href="" ng-click="tab.setTab(2)">Movement</a>
				</li>
				<li ng-class="{ active:tab.isSet(3) }">
					<a href="" ng-click="tab.setTab(2)">Vendor</a>
				</li>
				<li ng-class="{ active:tab.isSet(4) }">
					<a href="" ng-click="tab.setTab(2)">Location</a>
				</li>
				<li ng-class="{ active:tab.isSet(5) }">
					<a href="" ng-click="tab.setTab(2)">Notification</a>
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
				<vendor>
					<!--  Vendor Container  -->
					<div class="list-group">
						<!--  Vendor Container  -->
						<div class="list-group-item" ng-repeat="vendor in vendors">
							<h3> Vendor <em>Number One</em></h3>

							<!--  Vendor Buttons -->
							<div class="vendor button row">
								<div class="col-md-4">
									<button class="btn btn-default" ng-click="addVendor(vendor)" value="ADD">+</button>
								</div>
								<div class="col-md-4">
									<button class="btn btn-default" ng-click="editVendor(vendor)" value="Edit">E</button>
								</div>
								<div class="col-md-4">
									<button class="btn btn-default" ng-click="deleteVendor(vendor)" value="Delete">-</button>
								</div>
							</div>


							<ul>
								<h4>Reports</h4>
								<li ng-repeat="product in vendor.products">
									<blockquote>
										<strong>{{product.title}} </strong>
										{{product.description}}
										<cite class="clearfix">-{{product.sku}} on {{product.leadtime}}</cite>
									</blockquote>
								</li>
							</ul>

							<!--  Review Form -->
							<form name="VendorForm" class="container" ng-controller="VendorController as VendorCtrl" ng-submit="VendorForm.$valid && VendorCtrl.addVendor(movement)" novalidate>

								<!--  Live Preview -->
								<blockquote ng-show="review">
									<strong>{{reviewCtrl.review.stars}} Stars</strong>
									{{reviewCtrl.review.body}}
									<cite class="clearfix">-{{reviewCtrl.review.author}}</cite>
								</blockquote>

								<!--  Review Form -->
								<h4>Submit a Vendor</h4>
								<fieldset class="form-group">
									<input ng-model="VendorCtrl.contactName" type="text" class="form-control" placeholder="Topher Sucks" title="Contact Name" required />
								</fieldset>
								<fieldset class="form-group">
									<input ng-model="VendorCtrl.vendorEmail" type="email" class="form-control" placeholder="topersucks@myunit.test" title="Vendor Email" required />
								</fieldset>
								<fieldset class="form-group">
									<input ng-model="VendorCtrl.vendorName" type="text" class="form-control" placeholder="Angular Company" title="Vendor Name" required />
								</fieldset>
								<fieldset class="form-group">
									<input ng-model="VendorCtrl.vendorPhoneNumber" type="number" class="form-control" placeholder="5555555" title="Phone Number" required />
								</fieldset>
								<fieldset class="form-group">
									<div> VendorForm is {{vendorForm.$valid}}</div>
									<input type="submit" class="btn btn-primary pull-right" value="Submit Vendor" />
								</fieldset>
							</form>
						</div>
					</div>
				</vendor>
			</div>

			<!--  Location Tab's Contents  -->
			<div ng-show="tab.isSet(4)">
				<location></location>
			</div>

			<!--  Notification Tab's Contents  -->
			<div ng-show="tab.isSet(5)">
				<notification></notification>
			</div>

	</body>
</html>