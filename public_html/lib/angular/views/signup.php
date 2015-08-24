

<html lang="en" ng-app="FoodInventory">

<head>

</head>

<div ng-controller="SignUpController">
	<form novalidate class="simple-form" ng-submit="addUser(user);">
		Last Name: <input type="text" ng-model="user.lastName"/><br/>
		First Name: <input type="text" ng-model="user.firstName"/><br/>
		Email: <input type="email" ng-model="user.email"/><br/>
		Phone Number: <input type="text" ng-model="user.phoneNumber"/><br/>
		Attention: <input type="text" ng-model="user.attention"/><br/>
		Address Line One <input type="text" ng-model="user.addressLineOne"/><br/>
		Address Line Two <input type="text" ng-model="user.addressLineTwo"/><br/>
		City <input type="text" ng-model="user.city"/><br/>
		State <input type="text" ng-model="user.state"/><br/>
		Zip Code <input type="text" ng-model="user.zipCode"/><br/>
		Password <input type="password" ng-model="user.password"/><br/>
		Password <input type="password" ng-model="user.password"/><br/>
		<button type="submit">Sign Up</button>
		<button type="reset">Reset</button>
	</form>
	<pre>form = {{user | json}}</pre>
	<pre>master = {{master| json}}</pre>
</div>


</html>






