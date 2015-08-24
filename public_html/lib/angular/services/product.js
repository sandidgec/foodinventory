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
	 * method that promises to get products by location
	 *
	 * @returns accepts the promise when products are found, rejected otherwise
	 **/
	this.getProducts = function(location) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?location=" + location)
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
	 * method that promises to get products by UnitOfMeasure
	 *
	 * @returns accepts the promise when products are found, rejected otherwise
	 **/
	this.getProducts = function(unitOfMeasure) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?unitOfMeasure=" + unitOfMeasure)
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
	 * method that promises to get products by FinishedProduct
	 *
	 * @returns accepts the promise when products are found, rejected otherwise
	 **/
	this.getProducts = function(finishedProduct) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?finishedProduct=" + finishedProduct)
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
	this.getProducts = function(notification) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?notification=" + notification)
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
	this.getProducts = function(notification) {
		return($http.get(this.PRODUCTEDITOR_ENDPOINT + "?notification=" + notification)
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
	return ($http.put(this.REGISTER_ENDPOINT + product.productId, product)
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
	return ($http.delete(this.REGISTER_ENDPOINT + product.productId)
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