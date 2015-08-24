app.service("RegisterService", function($http, $q) {
	this.REGISTER_ENDPOINT = "../../backend/php/api/notification/";


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