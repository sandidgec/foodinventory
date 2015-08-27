app.controller("SignUpController", function($http, SignupService, $scope) {
	$scope.users = null;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;


	/**
	 *method that controls the action table and will fill the table or display errors
	 */
	$scope.addUser = function(user) {
		if(user.password !== user.confirmPassword) {
			UserService.addUser(user)
				.then(function(reply) {
					if(reply.status === 200) {
						$scope.users = reply.data;
					} else {
						$scope.statusClass = "alert-danger";
						$scope.statusMessage = reply.message;
					}
				});
		}
	};
});

