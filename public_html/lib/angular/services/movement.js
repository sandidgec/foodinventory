/**
 * service for the movement api endpoint
 **/
app.service("MovementService", function($http, $q) {
	this.MOVEMENT_ENDPOINT = "/~invtext/backend/php/api/movement/";

	/**
	 * method that promises to add a movement
	 *
	 * @returns accepts the promise when the movement is added, rejected otherwise
	 **/
	this.addMovement = function(movement) {
		return ($http.post(this.MOVEMENT_ENDPOINT, movement)
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
	 * method that promises to get movements by movementId
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovementByMovementId = function(movementId) {
		return ($http.get(this.MOVEMENT_ENDPOINT + movementId)
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
	 * method that promises to get movements by fromLocationId
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovementByFromLocationId = function(fromLocationId) {
		return ($http.get(this.MOVEMENT_ENDPOINT + "?fromLocationId=" + fromLocationId)
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
	 * method that promises to get movements by toLocationId
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovementByToLocationId = function(toLocationId) {
		return ($http.get(this.MOVEMENT_ENDPOINT + "?toLocationId=" + toLocationId)
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
	 * method that promises to get movements by productId
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovementByProductId = function(productId) {
		return ($http.get(this.MOVEMENT_ENDPOINT + "?productId=" + productId)
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
	 * method that promises to get movements by userId
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovementByUserId = function(userId) {
		return ($http.get(this.MOVEMENT_ENDPOINT + "?userId=" + userId)
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
	 * method that promises to get movements by movementDate
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovementByMovementDate = function(movementDate) {
		return ($http.get(this.MOVEMENT_ENDPOINT + "?movementDate=" + movementDate)
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
	 * method that promises to get movements by movementType
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovementByMovementType = function(movementType) {
		return ($http.get(this.MOVEMENT_ENDPOINT + "?movementType=" + movementType)
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
	 * method that promises to get all movements
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getAllMovements = function(page) {
		return ($http.get(this.MOVEMENT_ENDPOINT + "?page=" + page)
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