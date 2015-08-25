app.service("AdminService", function($http, $q) {
	this.ADMIN_ENDPOINT = "../../backend/php/api/user/";


	this.getAllUsers = function() {
		return ($http.get(this.ADMIN_ENDPOINT)
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

	this.getUsersByUserId = function(userId) {
		return ($http.get(this.SIGNUP_ENDPOINT +  userId)
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

	this.deleteUser = function(user) {
		return ($http.delete(this.SIGNUP_ENDPOINT + user.userId)
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

