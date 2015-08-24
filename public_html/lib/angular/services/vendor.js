app.service("RegisterService", function($http, $q) {
	this.REGISTER_ENDPOINT = "../../backend/php/api/vendor/";


	this.getVendorByVendorId = function(vendorId) {
		return ($http.get(this.REGISTER_ENDPOINT +  vendorId)
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

	this.getVendorByVendorEmail = function(vendorEmail) {
		return ($http.get(this.REGISTER_ENDPOINT + "?vendorEmail=" + vendorEmail)
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
	this.getVendorByVendorName = function(vendorName) {
		return ($http.get(this.REGISTER_ENDPOINT + "?vendorName=" + vendorName)
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

	this.getAllVendors = function() {
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

	this.addVendor = function(vendor) {
		return ($http.post(this.REGISTER_ENDPOINT, vendor)
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

	this.editVendor = function(vendor) {
		return ($http.put(this.REGISTER_ENDPOINT + vendor.vendorId, vendor)
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

	this.deleteVendor = function(user) {
		return ($http.delete(this.REGISTER_ENDPOINT + vendor.vendorId)
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