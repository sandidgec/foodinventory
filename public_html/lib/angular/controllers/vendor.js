var globalVendor = null;
/**
 * controller for the vendor service
 **/
app.controller("VendorController", function($http, $modal, $scope, VendorService) {
	$scope.vendors = null;
	$scope.editedVendor = null;
	$scope.isEdited = false;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 * method that controls the action table and will fill the table or display errors
	 **/
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

	/**
	 * method that controls the action table and will fill the table or display errors
	 **/
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

	/**
	 * method that controls the action table and will fill the table or display errors
	 **/
	$scope.deleteVendor = function(vendorId) {
		var message = "Do you really want to delete this Vendor?";
		var modalHtml = '<div class="modal-body">' + message + '</div>' +
			'<div class="modal-footer"><button class="btn btn-primary" ng-click="yes()">Yes</button><button class="btn btn-warning" ng-click="no()">No</button></div>';

		$scope.modalInstance = $modal.open({
			template: modalHtml,
			controller: ModalInstanceCtrl
		});

		$scope.modalInstance.result.then(function() {
			VendorService.deleteVendor(vendorId)
				.then(function(reply) {
					if(reply.status === 200) {
						$scope.vendors = reply.data;
					} else {
						$scope.statusClass = "alert-danger";
						$scope.statusMessage = reply.message;
					}
				});
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

	$scope.setEditedVendor = function(vendor){
		$scope.editedVendor = angular.copy(vendor);
		$scope.isEditing = true;
		globalVendor = vendor;
	};

	$scope.cancelEditing = function(){
		$scope.editedVendor = null;
		$scope.isEdiitng = false;
	};

	$("#EditVendorModal").on("shown.bs.modal", function(){
		var angularRoot = angular.element(document.querySelector("#EditVendorModal"));
		var scope = angularRoot.scope();
		scope.$apply(function(){
			$scope.isEditing = true;
			$scope.editedVendor = globalVendor;
		});
	});

	$scope.vendors = $scope.getAllVendors();
});