/**
 * controller for the vendor service
 **/
app.controller("VendorController", function($http, $scope, VendorService) {
	$scope.vendors = null;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 * method that controls the action table and will fill the table or display errors
	 */
	$scope.addVendor = function(vendor) {
		VendorService.addVendor(vendor)
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

	$scope.editVendor = function(vendor) {
		VendorService.editVendor(vendor)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.vendors = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.deleteVendor = function(vendor) {
		VendorService.deleteVendor(vendor)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.vendors = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getVendorByVendorId = function(vendorId) {
		VendorService.getVendorByVendorId(vendorId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.vendors = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getVendorByVendorEmail = function(vendorEmail) {
		VendorService.getVendorByVendorEmail(vendorEmail)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.vendors = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getVendorByVendorName = function(vendorName) {
		VendorService.getVendorByVendorName(vendorName)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.vendors = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getAllVendors = function() {
		VendorService.getAllVendors()
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.vendors = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.movements = $scope.getAllVendors();
});