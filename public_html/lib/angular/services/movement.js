/**
 * service for the movement api endpoint
 **/
app.service("MovementService", function($http, $q) {
	this.MOVEMENT_ENDPOINT = "../../backend/php/api/movement/";

	/**
	 * method that promises to get movements
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovements = function() {
		return($http.get(this.MOVEMENT_ENDPOINT)
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
	 * method that promises to get movements by movementId
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovements = function(movementId) {
		return($http.get(this.MOVEMENT_ENDPOINT + movementId)
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
	 * method that promises to get movements by fromLocationId
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovements = function(fromLocationId) {
		return($http.get(this.MOVEMENT_ENDPOINT + "?fromLocationId=" + fromLocationId)
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
	 * method that promises to get movements by toLocationId
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovements = function(toLocationId) {
		return($http.get(this.MOVEMENT_ENDPOINT + "?toLocationId=" + toLocationId)
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
	 * method that promises to get movements by productId
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovements = function(productId) {
		return($http.get(this.MOVEMENT_ENDPOINT + "?productId=" + productId)
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
	 * method that promises to get movements by userId
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovements = function(userId) {
		return($http.get(this.MOVEMENT_ENDPOINT + "?userId=" + userId)
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
	 * method that promises to get movements by movementDate
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovements = function(movementDate) {
		return($http.get(this.MOVEMENT_ENDPOINT + "?movementDate=" + movementDate)
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
	 * method that promises to get movements by movementType
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovements = function(movementType) {
		return($http.get(this.MOVEMENT_ENDPOINT + "?movementType=" + movementType)
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
	 * method that promises to add a movement
	 *
	 * @returns accepts the promise when the movement is added, rejected otherwise
	 **/
	this.addMovement = function(movement) {
		return($http.post(this.MOVEMENT_ENDPOINT + movement)
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