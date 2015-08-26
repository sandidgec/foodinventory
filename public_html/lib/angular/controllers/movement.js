app.controller("MovementController", function($http, $scope, MovementService) {
	$scope.movement = null;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 *method that controls the action table and will fill the table or display errors
	 */
	$scope.addMovement = function(movement) {
		MovementService.addMovement(movement);
		if(reply.status === 200) {
			$scope.actions = reply.data;
		} else {
			$scope.statusClass = "alert-danger";
			$scope.statusMessage = reply.message;
		}
	};
});