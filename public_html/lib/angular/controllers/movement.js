/**
 * controller for the movement service
 **/
app.controller("MovementController", function($http, $scope, MovementService, LocationService, ProductService) {
	$scope.movements = null;
	$scope.locations = null;
	$scope.products = null;

	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 * method that controls the action table and will fill the table or display errors
	 */
	$scope.addMovement = function(movement) {
		MovementService.addMovement(movement)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.getAllMovements(0);
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getMovementByMovementId = function(movementId) {
		MovementService.getMovementByMovementId(movementId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.movements = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getMovementByFromLocationId = function(fromLocationId) {
		MovementService.getMovementByFromLocationId(fromLocationId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.movements = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getMovementByToLocationId = function(toLocationId) {
		MovementService.getMovementByToLocationId(toLocationId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.movements = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getMovementByProductId = function(productId) {
		MovementService.getMovementByProductId(productId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.movements = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getMovementByUserId = function(userId) {
		MovementService.getMovementByUserId(userId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.movements = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getMovementByMovementDate = function(movementDate) {
		MovementService.getMovementByMovementDate(movementDate)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.movements = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getMovementByMovementType = function(movementType) {
		MovementService.getMovementByMovementType(movementType)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.movements = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getAllMovements = function(page) {
		MovementService.getAllMovements(page)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.movements = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getLocationByStorageCode = function(storageCode) {
		LocationService.getLocationByStorageCode(storageCode)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getProductByTitle = function(title) {
		ProductService.getProductByTitle(title)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.products = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.movements = $scope.getAllMovements(0);
});