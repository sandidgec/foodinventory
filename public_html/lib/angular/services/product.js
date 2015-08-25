app.service("ProductEditorService", function($http, $q) {
	this.PRODUCTEDITOR_ENDPOINT = "../../backend/php/api/product/";

	/**
	 * method that promises to get products
	 *
	 * @returns accepts the promise when products are found, rejected otherwise
	 **/
	this.getProducts = function() {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT)
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
	 * method that promises to get products by productId
	 *
	 * @returns accepts the promise when products are found, rejected otherwise
	 **/
	this.getProducts = function(productId) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + productId)
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
	 * method that promises to get products by vendorId
	 *
	 * @returns accepts the promise when products are found, rejected otherwise
	 **/
	this.getProducts = function(vendorId) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?vendorId=" + vendorId)
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
	 * method that promises to get products by description
	 *
	 * @returns accepts the promise when products are found, rejected otherwise
	 **/
	this.getProducts = function(description) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?description=" + description)
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
	 * method that promises to get products by leadTime
	 *
	 * @returns accepts the promise when products are found, rejected otherwise
	 **/
	this.getProducts = function(leadTime) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?leadTime=" + leadTime)
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
	 * method that promises to get products by sku
	 *
	 * @returns accepts the promise when movements are found, rejected otherwise
	 **/
	this.getProducts = function(sku) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?sku=" + sku)
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
	 * method that promises to get products by title
	 *
	 * @returns accepts the promise when products are found, rejected otherwise
	 **/
	this.getProducts = function(title) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?title=" + title)
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
	 * method that promises to get location by productId
	 *
	 * @returns accepts the promise when locations are found, rejected otherwise
	 **/
	this.getLocation = function(productId) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?productId=" + productId)
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
	 * method that promises to get0 UnitOfMeasure by productId
	 *
	 * @returns accepts the promise when unit of measure are found, rejected otherwise
	 **/
	this.getUnitOfMeasure = function(productId) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?productId=" + productId)
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
	 * method that promises to get FinishedProduct by productId
	 *
	 * @returns accepts the promise when finishedProduct are found, rejected otherwise
	 **/
	this.getFinishedProduct = function(productId) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?productId=" + productId)
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
	 * method that promises to get products by Notification
	 *
	 * @returns accepts the promise when products are found, rejected otherwise
	 **/
	this.getNotification = function(productId) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?productId=" + productId)
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
	 * method that promises to get all products
	 *
	 * @return accepts the promise when products are found, rejected otherwise
	 **/
	this.getAllProducts = function() {
		return ($http.get(this.SIGNUP_ENDPOINT)
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
	 * method that promises to add a product
	 *
	 * @returns accepts the promise when the product is added, rejected otherwise
	 **/
	this.addProduct = function(product) {
		return($http.post(this.ProductEDITOR_ENDPOINT + product)
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
 * method that promises to edit a product
 *
 * @returns accepts the promise when the product is edited, rejected otherwise
 **/
this.editProduct = function(product) {
	return ($http.put(this.SIGNUP_ENDPOINT + product.productId, product)
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

this.deleteProduct = function(user) {
	return ($http.delete(this.SIGNUP_ENDPOINT + product.productId)
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