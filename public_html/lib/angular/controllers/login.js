app.controller("LoginController", function($http, LoginService, $scope) {
	$scope.user = null;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;


	/**
	 *method that controls the action table and will fill the table or display errors
	 */
	$scope.getUsersByEmail = function(email) {
		if(user.password !== user.confirmPassword) {
			UserService.getUsersByEmail(user)
				.then(function(reply) {
					if(reply.status === 200) {
						$scope.actions = reply.data;
					} else {
						$scope.statusClass = "alert-danger";
						$scope.statusMessage = reply.message;
					}
				});
		}
	};
});