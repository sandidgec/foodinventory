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
									<input type="text" class="form-control" id="lastName" name="lastName" placeholder=" (e.g. Smith)" ng-model="user.lastName"/>
								</div>
							</div>

							<div class="form-group">
								<label for="firstName" class="col-sm-3 control-label">First Name:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="firstName" name="firstName" placeholder=" (e.g. John)" ng-model="user.firstName"/>
								</div>
							</div>

							<div class="form-group">
								<label for="email" class="col-sm-3 control-label">Email:</label>
								<div class="col-sm-9">
									<input type="email" class="form-control" id="email" name="email" placeholder=" (e.g. john@smith.com)" ng-model="user.email"/>
								</div>
							</div>

							<div class="form-group">
									<label for="phoneNumber" class="col-sm-3 control-label">Phone Number:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder=" (e.g. 5055551234)" ng-model="user.phoneNumber"/>
								</div>
							</div>

								<div class="form-group">
									<label for="attention" class="col-sm-3 control-label">Attention:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="attention" name="attention" placeholder=" (e.g. Acme LLC.)" ng-model="user.attention"/>
									</div>
								</div>

								<div class="form-group">
									<label for="addressLineOne" class="col-sm-3 control-label">Address One:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="addressLineOne" name="addressLineOne" placeholder=" (e.g. 1 Main St.)" ng-model="user.addressLineOne"/>
									</div>
								</div>

								<div class="form-group">
									<label for="addressLineTwo" class="col-sm-3 control-label">Address Two:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="addressLineTwo" name="addressLineTwo" placeholder=" (e.g. Suite 200)" ng-model="user.addressLineTwo"/>
									</div>
								</div>

								<div class="form-group">
									<label for="city" class="col-sm-3 control-label">City:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="city" name="city" placeholder=" (e.g. New York)" ng-model="user.city"/>
									</div>
								</div>

								<div class="form-group">
									<label for="state" class="col-sm-3 control-label">State:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="state" name="state" placeholder=" (e.g. NY)" ng-model="user.state"/>
									</div>
								</div>

								<div class="form-group">
									<label for="zipCode" class="col-sm-3 control-label">Zip Code:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="zipCode" name="zipCode" placeholder=" (e.g. 12345-1111)" ng-model="user.zipCode"/>
									</div>
								</div>

								<div class="form-group">
									<label for="password" class="col-sm-3 control-label">Password:</label>
									<div class="col-sm-9">
										<input type="password" class="form-control" id="password" name="password" placeholder=" (e.g. password1234)" ng-model="user.password"/>
									</div>
								</div>

								<div class="form-group">
									<label for="passwordConfirm" class="col-sm-3 control-label">Password Confirm:</label>
									<div class="col-sm-9">
										<input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" placeholder=" (e.g. password1234)" ng-model="user.passwordConfirm"/>
									</div>
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






