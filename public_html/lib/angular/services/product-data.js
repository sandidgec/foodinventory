/**
 * creating service for products
 * in the food inventory web application
 *
 *
 * file started by Marie on Sunday 8/23/15—
 * may need revisions based on
 * other team members' code
 */


function angularModule() {
// wrapping angular.module within a javaScript function

	var app = angular.module("", []);

	// create app.product using $http service
	//angular.js documentation—$http service is a core Angular service that facilitates communication with the remote HTTP servers via the browser's XMLHttpRequest object or via JSONP.
	app.product("Data", ["$http",
		function ($http, $q) {
			// retrieve api data information for products using api index.php document
			var serviceProduct = "/backend/php/api/product/index.php";

			var obj = {};
			// Get object and return $http.get
			obj.get = function (q) {
				return $http.get(serviceProduct + q).then(function (results) {
					return results.data;
				});
			};
			// Post object and return $http.get
			obj.post = function (q, object) {
				return $http.post(serviceProduct + q, object).then(function (results) {
					return results.data;
				});
			};
			// Put object and return $http.get
			obj.put = function (q, object) {
				return $http.put(serviceProduct + q, object).then(function (results) {
					return results.data;
				});
			};
			// Delete object and return results
			obj.delete = function (q) {
				return $http.delete(serviceProduct + q).then(function (results) {
					return results.data;
				});
			};
			return obj;
		}]);
}