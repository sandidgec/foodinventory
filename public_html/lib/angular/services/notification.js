app.service("RegisterService", function($http, $q) {
	this.REGISTER_ENDPOINT = "../../backend/php/api/notification/";

	/**
	 * method that promises to get notifications by notificationId
	 *
	 * @return accepts the promise when movements are found, rejected otherwise
	 **/
	this.getNotificationByNotificationId = function(notificationId) {
		return ($http.get(this.REGISTER_ENDPOINT +  notificationId)
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
		return ($http.get(this.REGISTER_ENDPOINT + "?alertId=" + alertId)
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
		return ($http.get(this.REGISTER_ENDPOINT + "?emailStatus=" + emailStatus)
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
		return ($http.get(this.REGISTER_ENDPOINT + "?notificationDateTime=" + notificationDateTime)
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
		return ($http.get(this.REGISTER_ENDPOINT + "?alertId=" + alertId)
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
	this.getAllNotifications = function() {
		return ($http.get(this.REGISTER_ENDPOINT)
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
 * method that promises to add a notification
 *
 * @return accepts the promise when movement is added, rejected otherwise
 **/
	this.addNotification = function(notification) {
		return ($http.post(this.REGISTER_ENDPOINT, notification)
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