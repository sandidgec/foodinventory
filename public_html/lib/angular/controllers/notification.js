var globalNotification = null;
/**
 * controller for the notification service
 **/
app.controller("NotificationController", function($http, $scope, NotificationService) {
	$scope.notifications = null;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 * method that controls the action table and will fill the table or display errors
	 */
	$scope.addNotification = function(notification) {
		NotificationService.addNotification(notification)
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

	$scope.getNotificationByNotificationId = function(NotificationId) {
		NotificationService.getNotificationByNotificationId(NotificationId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getNotificationByAlertId = function(alertId) {
		NotificationService.getNotificationByAlertId(alertId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getNotificationByEmailStatus = function(emailStatus) {
		NotificationService.getNotificationByEmailStatus(emailStatus)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getNotificationByNotificationDateTime = function(notificationDateTime) {
		NotificationService.getNotificationByNotificationDateTime(notificationDateTime)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getProductByAlertId = function(alertId) {
		NotificationService.getProductByAlertId(alertId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getAllNotifications = function() {
		NotificationService.getAllNotifications()
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.notifications = reply.data;
					//console.log(reply.data);
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.setEditedNotification = function(notification){
		$scope.editedNotification = angular.copy(notification);
		$scope.isEditing = true;
		globalNotification = notification;
	};

	$scope.cancelEditing = function(){
		$scope.editedNotification = null;
		$scope.isEdiitng = false;
	};

	$("#EditNotificationModal").on("shown.bs.modal", function(){
		var angularRoot = angular.element(document.querySelector("#EditNotificationModal"));
		var scope = angularRoot.scope();
		scope.$apply(function(){
			$scope.isEditing = true;
			$scope.editedNotification = globalNotification;
		});
	});

	$scope.notifications = $scope.getAllNotifications(0);
});