/**
 * service for location
 * in the food inventory web application
 */

app.service("RegisterService", function($http, $q) {
	this.REGISTER_ENDPOINT = "../../backend/php/api/location/";

//get Location by location Id
	this.getLocationByLocationId = function(locationId) {
		return ($http.get(this.REGISTER_ENDPOINT +  locationId)
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

//get Location by Storage Code
	this.getLocationByStorageCode = function(storageCode) {
		return ($http.get(this.REGISTER_ENDPOINT + "?storageCode=" + storageCode)
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

//getProductByLocationId
	this.getProductByLocationId = function(locationId) {
		return ($http.get(this.REGISTER_ENDPOINT + "?locationId=" + locationId)
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

//gets all Locations
	this.getAllLocations = function() {
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


//post the Location
	this.addProduct = function(location) {
		return ($http.post(this.REGISTER_ENDPOINT, location)
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