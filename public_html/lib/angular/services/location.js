/**
 * service for the location api endpoint
 **/
app.service("LocationService", function($http, $q) {
	this.LOCATION_ENDPOINT = "/~invtext/backend/php/api/location/";

	/**
	 * method that promises to add a location
	 *
	 * @returns accepts the promise when the product is added, rejected otherwise
	 **/
	this.addLocation = function(location) {
		return($http.post(this.LOCATION_ENDPOINT + location)
			.then(function(reply) {
				if(typeof reply.data === "object") {
					return(reply.data);
				} else {
					return($q.reject(reply.data));
				}
			}, function(reply) {
				return($q.reject(reply.data));
			}));
	};

	/**
	 * method that promises to edit a location
	 *
	 * @returns accepts the promise when the location is edited, rejected otherwise
	 **/
	this.editLocation = function(location) {
		return ($http.put(this.LOCATION_ENDPOINT + location.locationId, location)
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
	 * method that promises to delete a location
	 *
	 * @returns accepts the promise when the location is deleted, rejected otherwise
	 **/
	this.deleteLocation = function(location) {
		return ($http.delete(this.LOCATION_ENDPOINT + location.locationId, location)
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
	 * method that promises to get locations by locationId
	 *
	 * @returns accepts the promise when locations are found, rejected otherwise
	 **/
	this.getLocationByLocationId = function(locationId) {
		return($http.get(this.LOCATION_ENDPOINT + locationId)
			.then(function(reply){
				if(typeof reply.data === "object") {
					return(reply.data);
				} else {
					return($q.reject(reply.data));
				}
			}, function(reply) {
				return($q.reject(reply.data));
			}));
	};

	/**
	 * method that promises to get locations by Storage Code
	 *
	 * @returns accepts the promise when locations are found, rejected otherwise
	 **/
	this.getLocationByStorageCode = function(storageCode) {
		return($http.get(this.LOCATION_ENDPOINT + "?storageCode=" + storageCode)
			.then(function(reply){
				if(typeof reply.data === "object") {
					return(reply.data);
				} else {
					return($q.reject(reply.data));
				}
			}, function(reply) {
				return($q.reject(reply.data));
			}));
	};
	/**
	 * method that promises to get products by location Id
	 *
	 * @returns accepts the promise when products are found, rejected otherwise
	 **/
	this.getProductByLocationId = function(locationId) {
		return($http.get(this.LOCATION_ENDPOINT + "?locationId=" + locationId)
			.then(function(reply){
				if(typeof reply.data === "object") {
					return(reply.data);
				} else {
					return($q.reject(reply.data));
				}
			}, function(reply) {
				return($q.reject(reply.data));
			}));
	};
	/**
	 * method that promises to get all locations
	 *
	 * @return accepts the promise when locations are found, rejected otherwise
	 **/
	this.getAllLocations = function() {
		return ($http.get(this.LOCATION_ENDPOINT)
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