app.controller("SignUpController", function($http, UserService, $scope) {
	$scope.user = null;
	$scope.statusClass = "alert-success";
	scope.statusMessage = null;


	/**
	 *method that controls the action table and will fill the table or display errors
	 */
	$scope.addUser = function(user) {
		SignUpController.getActions()
			.then(function(replay) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};
});