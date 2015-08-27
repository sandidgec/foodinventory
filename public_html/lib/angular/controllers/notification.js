/**
 * controller for the notification service
 **/
app.controller("NotificationController", function($http, $scope, NotificationService) {
	$scope.notification = null;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 * method that controls the action table and will fill the table or display errors
	 */
	$scope.addNotification = function(notification) {
		NotificationService.addNotification(notification)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
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
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};
});