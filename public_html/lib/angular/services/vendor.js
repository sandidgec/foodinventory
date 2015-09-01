/**
 * service for the vendor api endpoint
 **/
app.service("VendorService", function($http, $q) {
	this.VENDOR_ENDPOINT = "/~invtext/backend/php/api/vendor/";

	/**
	 * method that promises to add vendors
	 *
	 * @return accepts the promise when vendors are added, rejected otherwise
	 **/
	this.addVendor = function(vendor) {
		return ($http.post(this.VENDOR_ENDPOINT, vendor)
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
		return ($http.put(this.VENDOR_ENDPOINT + vendor.vendorId, vendor)
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
	this.deleteVendor = function(vendor) {
		return ($http.delete(this.VENDOR_ENDPOINT + vendor.vendorId, vendor)
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
	this.getVendorByVendorId = function(vendorId) {
		return ($http.get(this.VENDOR_ENDPOINT + vendorId)
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
	this.getVendorByVendorEmail = function(vendorEmail) {
		return ($http.get(this.VENDOR_ENDPOINT + "?vendorEmail=" + vendorEmail)
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
	this.getVendorByVendorName = function(vendorName) {
		return ($http.get(this.VENDOR_ENDPOINT + "?vendorName=" + vendorName)
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
		return ($http.get(this.VENDOR_ENDPOINT)
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