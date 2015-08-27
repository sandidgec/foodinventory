/**
 * controller for the product service
 **/
app.controller("ProductController", function($http, $scope, ProductService, VendorService) {
	$scope.products = null;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 * method that controls the action table and will fill the table or display errors
	 */
	$scope.addProduct = function(product) {
		ProductService.addProduct(product)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};
	/**
	 * method that controls the action table and will fill the table or display errors
	 */
	$scope.editProduct = function(product) {
		ProductService.editProduct(product)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};
	/**
	 * method that controls the action table and will fill the table or display errors
	 */
	$scope.deleteProduct = function(product) {
		ProductService.deleteProduct(product)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getProductByProductId = function(productId) {
		ProductService.getProductByProductId(productId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.products = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getProductByVendorId = function(vendorId) {
		ProductService.getProductByVendorId(vendorId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.products = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getProductByDescription = function(description) {
		ProductService.getProductByDescription(description)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.products = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getProductByLeadTime = function(leadTime) {
		ProductService.getProductByLeadTime(leadTime)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.products = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getProductBySku = function(sku) {
		ProductService.getProductBySku(sku)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.products = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getProductByTitle = function(title) {
		ProductService.getProductByTitle(title)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.products = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getLocationByProductId = function(productId) {
		ProductService.getLocationByProductId(productId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getUnitOfMeasureByProductId = function(productId) {
		ProductService.getUnitOfMeasureByProductId(productId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};
	$scope.getFinishedProductByProductId = function(productId) {
		ProductService.getFinishedProductByProductId(productId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};
	$scope.getNotificationByProductId = function(productId) {
		ProductService.getNotificationByProductId(productId)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.actions = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getAllProducts = function(page) {
		ProductService.getAllProducts(page)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.products = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};
});