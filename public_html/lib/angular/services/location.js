app.service("LocationEditorService", function($http, $q) {
	this.PRODUCTEDITOR_ENDPOINT = "../../backend/php/api/location/";

	/**
	 * method that promises to get locations
	 *
	 * @returns accepts the promise when locations are found, rejected otherwise
	 **/
	this.getLocations = function() {
		return($http.get(this.LOCATIONEDITOR_ENDPOINT)
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
	 * method that promises to get locations by locationId
	 *
	 * @returns accepts the promise when locations are found, rejected otherwise
	 **/
	this.getlocations = function(locationId) {
		return($http.get(this.LOCATIONEDITOR_ENDPOINT + locationId)
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
	this.getLocations = function(storageCode) {
		return($http.get(this.LOCATIONEDITOR_ENDPOINT + "?storageCode=" + storageCode)
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
	this.getLocations = function(locationId) {
		return($http.get(this.LOCATIONEDITOR_ENDPOINT + "?locationId=" + locationId)
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
	 * method that promises to add a location
	 *
	 * @returns accepts the promise when the product is added, rejected otherwise
	 **/
	this.addLocation = function(location) {
		return($http.post(this.ProductEDITOR_ENDPOINT + location)
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
});

/**
 * method that promises to edit a location
 *
 * @returns accepts the promise when the location is edited, rejected otherwise
 **/
this.editLocation = function(location) {
	return ($http.put(this.REGISTER_ENDPOINT + location.locationId, location)
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

this.deleteLocation = function(user) {
	return ($http.delete(this.REGISTER_ENDPOINT + location.locationId)
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