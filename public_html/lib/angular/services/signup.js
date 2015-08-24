app.service("RegisterService", function($http, $q) {
	this.REGISTER_ENDPOINT = "../../backend/php/api/user/";

	this.addUser = function(user) {
		return ($http.post(this.REGISTER_ENDPOINT, user)
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