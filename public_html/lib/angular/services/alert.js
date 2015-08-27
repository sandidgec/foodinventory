/**
 * service for the alertLevel api endpoint
 **/
app.service("AlertService", function($http, $q) {
	this.ALERTLEVEL_ENDPOINT = "/~invtext/backend/php/api/alert-level/";

	/**
	 * method that promises to add vendors
	 *
	 * @return accepts the promise when vendors are added, rejected otherwise
	 **/
	this.addAlertLevel = function(alertLevel) {
		return ($http.post(this.ALERTLEVEL_ENDPOINT, alertLevel)
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
	 * method that promises to edit vendors
	 *
	 * @return accepts the promise when vendors are edited, rejected otherwise
	 **/
	this.editAlertLevel = function(alertLevel) {
		return ($http.put(this.ALERTLEVEL_ENDPOINT + alertLevel.alertId, alertLevel)
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
	 * method that promises to delete vendors
	 *
	 * @return accepts the promise when vendors are deleted, rejected otherwise
	 **/
	this.deleteAlertLevel = function(alertLevel) {
		return ($http.delete(this.ALERTLEVEL_ENDPOINT + alertLevel.alertId, alertLevel)
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
	 * method that promises to get vendors by vendorId
	 *
	 * @return accepts the promise when vendors are found, rejected otherwise
	 **/
	this.getAlertLevelByAlertId= function(alertId) {
		return ($http.get(this.ALERTLEVEL_ENDPOINT +  alertId)
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
	 * method that promises to get vendors by vendorEmail
	 *
	 * @return accepts the promise when vendors are found, rejected otherwise
	 **/
	this.getAlertLevelByAlertCode = function(alertCode) {
		return ($http.get(this.ALERTLEVEL_ENDPOINT + "?alertCode=" + alertCode)
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
	 * method that promises to get vendors by vendorName
	 *
	 * @return accepts the promise when vendors are found, rejected otherwise
	 **/
	this.getProductByAlertId = function(alertId) {
		return ($http.get(this.ALERTLEVEL_ENDPOINT + "?alertId=" + alertId)
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
	 * method that promises to get vendors
	 *
	 * @return accepts the promise when vendors are found, rejected otherwise
	 **/
	this.getAllAlerts = function() {
		return ($http.get(this.ALERTLEVEL_ENDPOINT)
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