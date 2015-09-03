var globalProduct = null;

/**
 * controller for the product service
 **/
app.controller("ProductController", function($http, $modal, $scope, ProductService, VendorService) {
	$scope.products = null;
	$scope.vendors = [];
	$scope.editedProduct = null;
	$scope.isEditing = false;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 * method that controls the action table and will fill the table or display errors
	 */
	$scope.addProduct = function(product) {
		ProductService.addProduct(product)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.statusClass = "alert-success";
					$scope.statusMessage = reply.message;
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
	$scope.deleteProduct = function(productId) {
		var message = "Do you really want to delete this product?";
		var modalHtml = '<div class="modal-body">' + message + '</div>' +
			'<div class="modal-footer"><button class="btn btn-primary" ng-click="yes()">Yes</button><button class="btn btn-warning" ng-click="no()">No</button></div>';

		$scope.modalInstance = $modal.open({
			template: modalHtml,
			controller: ModalInstanceCtrl
		});

		$scope.modalInstance.result.then(function() {
			ProductService.deleteProduct(productId)
				.then(function(reply) {
					if(reply.status === 200) {
						$scope.actions = reply.data;
					} else {
						$scope.statusClass = "alert-danger";
						$scope.statusMessage = reply.message;
					}
				});
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
					reply.data.forEach(function(product, index){
						VendorService.getVendorByVendorId(reply.data[index].vendorId)
							.then(function(vendor){
								if(reply.status === 200){
									reply.data[index].vendor = vendor.data;
								}
							});
				});
					$scope.products = reply.data;
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
	};

	$scope.getVendorByVendorName = function(vendorName) {
		var vendors = VendorService.getVendorByVendorName(vendorName)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.vendors = reply.data;
					return($scope.vendors);
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
		return($scope.vendors);
	};

	$scope.setEditedProduct = function(product) {
		$scope.editedProduct = angular.copy(product);
		$scope.isEditing = true;
		globalProduct = product;
	};

	$scope.cancelEditing = function() {
		$scope.editedProduct = null;
		$scope.isEditing = false;
	};

	$("#EditProductModal").on("shown.bs.modal", function() {
		var angularRoot = angular.element(document.querySelector("#EditProductModal"));
		var scope = angularRoot.scope();
		scope.$apply(function() {
			$scope.isEditing = true;
			$scope.editedProduct = globalProduct;
		});
	});

	$scope.products = $scope.getAllProducts(0);
});