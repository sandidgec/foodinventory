/**
 * service for the movement api endpoint
 **/
app.service("NotificationService", function($http, $q) {
	this.NOTIFICATION_ENDPOINT = "/~invtext/backend/php/api/notification/";

	/**
	 * method that promises to add a notification
	 *
	 * @return accepts the promise when movement is added, rejected otherwise
	 **/
	this.addNotification = function(notification) {
		return ($http.post(this.NOTIFICATION_ENDPOINT, notification)
			.then(function(reply) {
				if(typeof reply.data === "object") {
					return (reply.data);
				} else {
					return ($q.reject(reply.data));
				}
			}, function(reply) {
				return ($q.reject(reply.data));
			}));
	};
	/**
	 * method that promises to get notifications by notificationId
	 *
	 * @return accepts the promise when movements are found, rejected otherwise
	 **/
	this.getNotificationByNotificationId = function(notificationId) {
		return ($http.get(this.NOTIFICATION_ENDPOINT +  notificationId)
			.then(function(reply) {
				if(typeof reply.data === "object") {
					return (reply.data);
				} else {
					return ($q.reject(reply.data));
				}
			}, function(reply) {
				return ($q.reject(reply.data));
			}));
	};
	/**
	* method that promises to get notifications by alertId
	*
	* @return accepts the promise when movements are found, rejected otherwise
	**/
	this.getNotificationByAlertId = function(alertId) {
		return ($http.get(this.NOTIFICATION_ENDPOINT + "?alertId=" + alertId)
			.then(function(reply) {
				if(typeof reply.data === "object") {
					return (reply.data);
				} else {
					return ($q.reject(reply.data));
				}
			}, function(reply) {
				return ($q.reject(reply.data));
			}));
	};
	/**
	* method that promises to get notifications by emailStatus
	*
	* @return accepts the promise when movements are found, rejected otherwise
	**/
	this.getNotificationByEmailStatus = function(emailStatus) {
		return ($http.get(this.NOTIFICATION_ENDPOINT + "?emailStatus=" + emailStatus)
			.then(function(reply) {
				if(typeof reply.data === "object") {
					return (reply.data);
				} else {
					return ($q.reject(reply.data));
				}
			}, function(reply) {
				return ($q.reject(reply.data));
			}));
	};
	/**
	 * method that promises to get notifications by notificationDateTime
	 *
	 * @return accepts the promise when movements are found, rejected otherwise
	 **/
	this.getNotificationByNotificationDateTime = function(notificationDateTime) {
		return ($http.get(this.NOTIFICATION_ENDPOINT + "?notificationDateTime=" + notificationDateTime)
			.then(function(reply) {
				if(typeof reply.data === "object") {
					return (reply.data);
				} else {
					return ($q.reject(reply.data));
				}
			}, function(reply) {
				return ($q.reject(reply.data));
			}));
	};
	/**
	 * method that promises to get products by alertId
	 *
	 * @return accepts the promise when movements are found, rejected otherwise
	 **/
	this.getProductByAlertId = function(alertId) {
		return ($http.get(this.NOTIFICATION_ENDPOINT + "?alertId=" + alertId)
			.then(function(reply) {
				if(typeof reply.data === "object") {
					return (reply.data);
				} else {
					return ($q.reject(reply.data));
				}
			}, function(reply) {
				return ($q.reject(reply.data));
			}));
	};
	/**
	 * method that promises to get notifications
	 *
	 * @return accepts the promise when movements are found, rejected otherwise
	 **/
	this.getAllNotifications = function(page) {
		return ($http.get(this.NOTIFICATION_ENDPOINT + "?page=" + page)
			.then(function(reply) {
				if(typeof reply.data === "object") {
					return (reply.data);
				} else {
					return ($q.reject(reply.data));
				}
			}, function(reply) {
				return ($q.reject(reply.data));
			}));
	};

});