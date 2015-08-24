app.service("LoginService", function($http, $q) {
	this.LOGIN_ENDPOINT = "../../backend/php/api/user/";


	this.getUsersByEmail = function(email) {
		return ($http.get(this.LOGIN_ENDPOINT + "?email=" + email)
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




