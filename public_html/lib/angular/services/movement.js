app.service("MovementEditorService", function($http, $q) {
	this.MOVEMENTEDITOR_ENDPOINT = "../../backend/php/api/movement/";

	/**
	 * method that promises to get movements
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getMovements = function() {
		return($http.get(this.MOVEMENTEDITOR_ENDPOINT)
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
		return($http.get(this.MOVEMENTEDITOR_ENDPOINT + movementId)
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
		return($http.get(this.MOVEMENTEDITOR_ENDPOINT + fromLocationId)
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
		return($http.get(this.MOVEMENTEDITOR_ENDPOINT + toLocationId)
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
		return($http.get(this.MOVEMENTEDITOR_ENDPOINT + productId)
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
		return($http.get(this.MOVEMENTEDITOR_ENDPOINT + userId)
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
		return($http.get(this.MOVEMENTEDITOR_ENDPOINT + movementDate)
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
		return($http.get(this.MOVEMENTEDITOR_ENDPOINT + movementType)
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
	this.addMovement = function(movementId) {
		return($http.post(this.MOVEMENTEDITOR_ENDPOINT + movementId)
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