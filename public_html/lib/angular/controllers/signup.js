app.controller("SignUpController", function($http, SignupService, $scope, $window) {
	$scope.user = null;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;


	/**
	 *method that controls the action table and will fill the table or display errors
	 */
	$scope.addUser = function(user) {
		if(user.password === user.passwordConfirm) {
			SignupService.addUser(user)
				.then(function(reply) {
					if(reply.status === 200) {
						$window.location.href = "../lib/angular/views/admin-panel.php";
					} else {
						$scope.statusClass = "alert-danger";
						$scope.statusMessage = reply.message;
					}
				});
		}
	}});

