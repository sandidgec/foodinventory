app.controller("LoginController", function($http, LoginService, $window, $scope) {
	$scope.user = null;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;


	/**
	 *method that controls the action table and will fill the table or display errors
	 */
	$scope.getUsersByEmail = function(email) {
		if(user.password !== user.confirmPassword) {
			UserService.getUsersByEmail(user)
				.then(function(reply) {
					if(reply.status === 200) {
						$scope.actions = reply.data;
					} else {
						$scope.statusClass = "alert-danger";
						$scope.statusMessage = reply.message;
					}
				});
		}
	};

	$scope.login = function(user) {
		var result = $http.post("/~invtext/backend/php/lib/login.php", user)
			.then(function(reply) {
				if(typeof reply.data === "object") {
					if(result.status === 200) {
						$window.location.href = "../angular/views/admin-panel.php"
					} else {

					}

				} else {
					return ($q.reject(reply.data));
				}
			}, function(reply) {
				return ($q.reject(reply.data));
			});


	};

	$scope.logout = function() {
		$http.get("/~invtext/backend/php/lib/logout.php");
	};
});