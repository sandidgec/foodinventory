var globalAlert = null;
/**
 * controller for the alertLevel service
 **/
app.controller("AlertLevelController", function($http, $scope, AlertLevelService, ProductService) {
	$scope.alertLevels = null;
	$scope.products =[];
	$scope.editedAlert= null;
	$scope.isEditing= false;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 * method that controls the action table and will fill the table or display errors
	 */
	$scope.addAlertLevel = function(alertLevel) {
		AlertLevelService.addAlertLevel(alertLevel)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.alertLevels = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.editAlertLevel = function(alertLevel) {
		AlertLevelService.editAlertLevel(alertLevel)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.alertLevels = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.deleteAlertLevel = function(alertId) {
		var message = "Do you really want to delete this alert?";
		var modalHtml = '<div class="modal-body">' + message + '</div>' +
			'<div class="modal-footer"><button class="btn btn-primary" ng-click="yes()">Yes</button><button class="btn btn-warning" ng-click="no()">No</button></div>';

		$scope.modalInstance = $modal.open({
			template: modalHtml,
			controller: ModalInstanceCtrl
		});

		$scope.modalInstance.result.then(function() {
			AlertLevelService.deleteAlertLevel(alertId)
				.then(function(reply) {
					if(reply.status === 200) {
						$scope.actions = reply.data;
					} else {
						$scope.statusClass = "alert-danger";
						$scope.statusMessage = reply.message;
					}
				});
		});
		$scope.alerts = $scope.getAllAlerts(0);
	};

	$scope.getAlertLevelByAlertId = function(alertId) {
		AlertLevelService.getAlertLevelByAlertId(alertId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.alertLevels = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getAlertLevelByAlertCode = function(alertCode) {
		AlertLevelService.getAlertLevelByAlertCode(alertCode)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.alertLevels = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getProductByAlertId = function(alertId) {
		AlertLevelService.getProductByAlertId(alertId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.products = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getAllAlerts = function() {
		AlertLevelService.getAllAlerts()
			.then(function(reply) {
				if(reply.status === 200) {
					console.log(reply);
					reply.data.forEach(function(alertLevel, index) {
						ProductService.getProductByProductId(reply.data[index].productId)
							.then(function(product) {
								if(reply.status === 200) {
									reply.data[index].product = product.data;
								}
							});
					});
					$scope.alertLevels = reply.data;
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
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
		return($scope.products);
	};

	$scope.setEditedAlert = function(alert) {
		$scope.editedAlert = angular.copy(alert);
		$scope.isEditing = true;
		globalAlert = alert;
	};

	$scope.cancelEditing = function() {
		$scope.editedAlert = null;
		$scope.isEditing = false;
	};

	$("#EditAlertModal").on("shown.bs.modal", function() {
		var angularRoot = angular.element(document.querySelector("#EditAlertModal"));
		var scope = angularRoot.scope();
		scope.$apply(function() {
			$scope.isEditing = true;
			$scope.editedAlert = globalAlert;
		});
	});

	$scope.closeAddModal = function(){
		var angularRoot = angular.element(document.querySelector("#AddAlertModal"));
		angularRoot.modal("hide");
	};

	$scope.closeEditModal = function(){
		var angularRoot = angular.element(document.querySelector("#EditAlertModal"));
		angularRoot.modal("hide");
	};

	$scope.alerts = $scope.getAllAlerts(0);
});