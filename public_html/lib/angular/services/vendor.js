app.service("RegisterService", function($http, $q) {
	this.VENDOREDITOR_ENDPOINT = "../../backend/php/api/vendor/";

	/**
	 * method that promises to get vendors by vendorId
	 *
	 * @return accepts the promise when vendors are found, rejected otherwise
	 **/
	this.getVendors = function(vendorId) {
		return ($http.get(this.VENDOREDITOR_ENDPOINT +  vendorId)
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
	this.getVendors = function(vendorEmail) {
		return ($http.get(this.VENDOREDITOR_ENDPOINT + "?vendorEmail=" + vendorEmail)
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
	this.getVendors = function(vendorName) {
		return ($http.get(this.VENDOREDITOR_ENDPOINT + "?vendorName=" + vendorName)
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
	this.getAllVendors = function() {
		return ($http.get(this.VENDOREDITOR_ENDPOINT)
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
	 * method that promises to add vendors
	 *
	 * @return accepts the promise when vendors are added, rejected otherwise
	 **/
	this.addVendor = function(vendor) {
		return ($http.post(this.VENDOREDITOR_ENDPOINT, vendor)
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
	this.editVendor = function(vendor) {
		return ($http.put(this.VENDOREDITOR_ENDPOINT + vendor.vendorId, vendor)
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
	this.destroyVendor = function(user) {
		return ($http.delete(this.VENDOREDITOR_ENDPOINT + vendor.vendorId)
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