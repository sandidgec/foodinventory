/**
 * controller for the movement service
 **/
app.controller("MovementController", function($http, $scope, $rootScope, MovementService, ProductService, LocationService) {
	$scope.movements = null;
	$scope.products = [];
	$scope.locations = [];
	$scope.users = [];
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 * method that controls the action table and will fill the table or display errors
	 */
	$scope.addMovement = function(movement) {
		var newmovement = {
			fromLocationId: movement.fromLocationId,
			toLocationId: movement.toLocationId,
			productId: movement.productId,
			unitId: 1,
			userId: 1,
			cost: movement.cost,
			quantity: movement.quantity,
			movementDate: null,
			movementType: movement.movementType,
			price: movement.price
		};
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
		// first, call the getAllMovements() - the parent service
		MovementService.getAllMovements(page)
			// wait for the first promise (Movement)
			.then(function(reply) {
				if(reply.status === 200) {
					// foreach() through the array from the first promise
					reply.data.forEach(function(movement, index) {
						// call the getProductByProductId() - the child service
						ProductService.getProductByProductId(reply.data[index].productId)
							// wait for the second promise (Product)
							.then(function(product) {
								if(reply.status === 200) {
									// inject the child into the parent
									reply.data[index].product = product.data;
								}
							});
						// call the getLocationByLocationId() - the child service
						LocationService.getLocationByLocationId(reply.data[index].toLocationId)
							// wait for the third promise (Location)
							.then(function(location) {
								if(reply.status === 200) {
									// inject the child into the parent
									reply.data[index].toLocation = location.data;
								}
							});
						// call the getLocationByLocationId() - the child service
						LocationService.getLocationByLocationId(reply.data[index].fromLocationId)
		// wait for the fourth promise (Location)
		.then(function(location) {
			if(reply.status === 200) {
				// inject the child into the parent
				reply.data[index].fromLocation = location.data;
			}
		});
});

// finally, assign the parent array
//$scope.movements = reply.data;
$rootScope.$broadcast("updateMovements", reply.data);
} else {
	$scope.statusClass = "alert-danger";
	$scope.statusMessage = reply.message;
}
});
};

$scope.getProductByTitle = function(title) {
	var products = ProductService.getProductByTitle(title)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.products = reply.data;
					return ($scope.products);
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	return ($scope.products);
};

$scope.getLocationByStorageCode = function(storageCode) {
	var locations = LocationService.getLocationByStorageCode(storageCode)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.locations = reply.data;
					return ($scope.locations);
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	return ($scope.locations);
};

$scope.$on("updateMovements", function(event, movements) {
	$scope.movements = movements;
});

$scope.getAllMovements(0);
});