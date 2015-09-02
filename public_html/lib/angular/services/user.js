/**
 * service for the user api endpoint
 **/
app.service("UserService", function($http, $q) {
	this.USER_ENDPOINT = "/~invtext/backend/php/api/user/";

	/**
	 * method that promises to get users by email
	 *
	 * @returns accepts the promise when users are found, rejected otherwise
	 **/
	this.getUserByEmail = function(email) {
		return ($http.get(this.USER_ENDPOINT + "?email=" + email)
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