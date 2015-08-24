/**
 * service for products
 * in the food inventory web application
 */

app.service("RegisterService", function($http, $q) {
	this.REGISTER_ENDPOINT = "../../backend/php/api/product/";

//gets the Product by productId
	this.getProductByProductId = function(productId) {
		return ($http.get(this.REGISTER_ENDPOINT +  productId)
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

//gets the Product by vendorId
	this.getProductByVendorId = function(VendorId) {
		return ($http.get(this.REGISTER_ENDPOINT + "?VendorId=" + VendorId)
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

//gets the Product by description
	this.getProductByDescription = function(description) {
		return ($http.get(this.REGISTER_ENDPOINT + "?description=" + description)
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

//gets the Product by leadTime
	this.getProductByLeadTime = function(leadTime) {
		return ($http.get(this.REGISTER_ENDPOINT + "?leadTime=" + leadTime)
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

//gets the Product by sku
	this.getProductBySku = function(sku) {
		return ($http.get(this.REGISTER_ENDPOINT + "?sku=" + sku)
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

//gets the Product by title
	this.getProductByTitle = function(title) {
		return ($http.get(this.REGISTER_ENDPOINT + "?title=" + title)
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

//gets the Location by productId
	this.getLocationByProductId = function(productId) {
		return ($http.get(this.REGISTER_ENDPOINT + "?productId=" + productId)
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

//gets the UnitOfMeasure by productId
	this.getUnitOfMeasureByProductId = function(productId) {
		return ($http.get(this.REGISTER_ENDPOINT + "?productId=" + productId)
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

//gets the FinishedProduct by productId
	this.getFinishedProductByProductId = function(productId) {
		return ($http.get(this.REGISTER_ENDPOINT + "?productId=" + productId)
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

//gets the Notification by productId
	this.getNotificationByProductId = function(productId) {
		return ($http.get(this.REGISTER_ENDPOINT + "?productId=" + productId)
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

//gets the All Products
	this.getAllProducts = function() {
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


//post the Product
	this.addProduct = function(product) {
		return ($http.post(this.REGISTER_ENDPOINT, product)
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