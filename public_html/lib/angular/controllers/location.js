/**
 * controller for the location service
 **/
app.controller("LocationController", function($http, $scope, LocationService) {
	$scope.locations = null;
	$scope.editedLocation = null;
	$scope.isEditing = false;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 * method that controls the action table and will fill the table or display errors
	 */
	$scope.addLocation = function(location) {
		LocationService.addLocation(location)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.statusClass = "alert-success";
					$scope.statusMessage = reply.message;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.editLocation = function(location) {
		LocationService.editLocation(location)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.locations = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.deleteLocation = function(locationId) {
		var medage = "Do you really want to delete this location?";
		var modalHTML = '<div class="modal-body">' + message + '</div>' +
			'<div class="modal-footer"><button class="btn btn-primary" ng-click="yes()">Yes</button><button class="btn btn-warning" ng-click="no()">No</button></div>';


		LocationService.deleteLocation(location)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.locations = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getLocationByLocationId = function(locationId) {
		LocationService.getLocationByLocationId(locationId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.locations = reply.data;
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
					$scope.locations = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getProductByLocationId = function(locationId) {
		LocationService.getProductByLocationId(locationId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.locations = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getAllLocations = function() {
		LocationService.getAllLocations()
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.locations = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.setEditedLocation = function(location){
		$scope.editedLocation = angular.copy(location);
		$scope.isEditing = true;
	};

	$scope.cancelEditing = function(){
		$scope.editedLocation = null;
		$scope.isEditing = false;
	};
	$scope.locations = $scope.getAllLocations(0);
});