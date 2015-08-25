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
<!--	<link type="text/css" href="../lib/css/styles.css" rel="stylesheet"/>-->

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

	<script type="text/javascript" src="../food-inventory.js"></script>
	<script type="text/javascript" src="../services/signup.js"></script>
	<script type="text/javascript" src="../controllers/signup.js"></script>

</head>

	<body>

<!--		<div class="modal fade">-->
<!--			<div class="modal-dialog">-->
<!--				<div class="modal-content">-->
<!--					<div class="modal-header">-->
<!--						<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--						<span aria-hidden="true">&times;</span></button>-->
						<div ng-controller="SignUpController">
							<form novalidate class="simple-form" ng-submit="addUser(user);">

								<label for="lastName">Last Name:</label>
								<input type="text" id="lastName" name="lastName" ng-model="user.lastName"/>

								<label for="firstName">First Name</label>
								<input type="text" id="firstName" name="firstName" ng-model="user.firstName"/>

								<label for="email">Email</label>
								<input type="email" id="email" name="email" ng-model="user.email"/>

								<label for="phoneNumber">Phone Number</label>
								<input type="text" id="phoneNumber" name="phoneNumber" ng-model="user.phoneNumber"/>

								<label for="attention">Attention</label>
								<input type="text" id="attention" name="attention" ng-model="user.attention"/>

								<label for="addressLineOne">Address Line One</label>
								<input type="text" id="addressLineOne" name="addressLineOne" ng-model="user.addressLineOne"/>

								<label for="addressLineTwo">Address Line Two</label>
								<input type="text" id="addressLineTwo" name="addressLineTwo" ng-model="user.addressLineTwo"/>

								<label for="city">City</label>
								<input type="text" id="city" name="city" ng-model="user.city"/>

								<label for="state">State</label>
								<input type="text" id="state" name="state" ng-model="user.state"/>

								<label for="zipCode">Zipcode</label>
								<input type="text" id="zipCode" name="zipCode" ng-model="user.zipCode"/>

								<label for="password">Password</label>
								<input type="password" id="password" name="password" ng-model="user.password"/>

								<label for="passwordConfirm">Password Confirm</label>
								<input type="password" id="passwordConfirm" name="passwordConfirm" ng-model="user.passwordConfirm"/>

								<button type="submit">Sign Up</button>
								<button type="reset">Reset</button>
							</form>
							<pre>form = {{user | json}}</pre>
						</div>
</body>

</html>






