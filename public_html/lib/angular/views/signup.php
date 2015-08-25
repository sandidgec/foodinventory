<html lang="en" ng-app="FoodInventory">

	<head>

		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- Bootstrap Latest compiled and minified CSS -->
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>

		<!-- Optional Bootstrap theme -->
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"
				rel="stylesheet"/>

		<!-- LINK TO YOUR CUSTOM CSS FILES HERE -->
		<link type="text/css" href="../../css/forms.css" rel="stylesheet"/>

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
		<script type="text/javascript"
				  src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular-messages.min.js"></script>
		<script type="text/javascript"
				  src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.13.0/ui-bootstrap-tpls.min.js"></script>
		<script type="text/javascript" src="../food-inventory.js"></script>
		<script type="text/javascript" src="../services/signup.js"></script>
		<script type="text/javascript" src="../controllers/signup.js"></script>

	</head>

	<body>
		<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#SignUpModal">
			Sign-Up
		</button>
		<div class="modal fade" id="SignUpModal">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title">Sign-Up</h3>
					</div>

					<div class="modal-body" ng-controller="SignUpController">
						<form class="form-horizontal" ng-submit="addUser(user);">
							<div class="form-group">
								<label for="lastName" class="col-sm-3 control-label">Last Name:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="lastName" name="lastName" ng-model="user.lastName"/>
								</div>
							</div>
							<div class="form-group">
								<label for="firstName" class="col-sm-3 control-label">First Name</label>

								<div class="col-sm-9">
									<input type="text" class="form-control" id="firstName" name="firstName" ng-model="user.firstName"/>
								</div>
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" id="email" name="email" ng-model="user.email"/>
							</div>
							<div class="form-group">
								<label for="phoneNumber">Phone Number</label>
								<input type="text" id="phoneNumber" name="phoneNumber" ng-model="user.phoneNumber"/>
							</div>
							<div class="form-group">
								<label for="attention">Attention</label>
								<input type="text" id="attention" name="attention" ng-model="user.attention"/>
							</div>
							<div class="form-group">
								<label for="addressLineOne">Address Line One</label>
								<input type="text" id="addressLineOne" name="addressLineOne" ng-model="user.addressLineOne"/>
							</div>
							<div class="form-group">
								<label for="addressLineTwo">Address Line Two</label>
								<input type="text" id="addressLineTwo" name="addressLineTwo" ng-model="user.addressLineTwo"/>
							</div>
							<div class="form-group">
								<label for="city">City</label>
								<input type="text" id="city" name="city" ng-model="user.city"/>
							</div>
							<div class="form-group">
								<label for="state">State</label>
								<input type="text" id="state" name="state" ng-model="user.state"/>
							</div>
							<div class="form-group">
								<label for="zipCode">Zipcode</label>
								<input type="text" id="zipCode" name="zipCode" ng-model="user.zipCode"/>
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" id="password" name="password" ng-model="user.password"/>
							</div>
							<div class="form-group">
								<label for="passwordConfirm">Password Confirm</label>
								<input type="password" id="passwordConfirm" name="passwordConfirm"
										 ng-model="user.passwordConfirm"/>
							</div>
						</form>
						<pre>form = {{user | json}}</pre>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Sign-Up</button>
					</div>
				</div>

			</div>
		</div>
	</body>

</html>






