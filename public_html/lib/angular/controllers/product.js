var globalProduct = null;

/**
 * controller for the product service
 **/
app.controller("ProductController", function($http, $modal, $scope, ProductService, VendorService, MovementService) {
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
		var newProduct = {
			productId: null,
			vendorId: product.vendorId,
			description: product.description,
			leadTime: 5,
			sku: product.sku,
			title: product.title
		};
		ProductService.addProduct(newProduct)
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.statusClass = "alert-success";
					$scope.statusMessage = reply.message;

					console.log(reply);

					var movement = {
						fromLocationId: 1,
						toLocationId: 2,
						productId: reply.productId,
						unitId: 1,
						userId: 1,
						cost: product.cost,
						quantity: product.quantity,
						movementDate: null,
						movementType: "IN",
						price: product.price
					};

					MovementService.addMovement(movement)
						.then(function(reply) {
							$scope.products = $scope.getAllProducts(0);
						});
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
					$scope.products = $scope.getAllProducts(0);
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
						$scope.products = $scope.getAllProducts(0);
					} else {
						$scope.statusClass = "alert-danger";
						$scope.statusMessage = reply.message;
					}
				});
		});

		$scope.movements = $scope.getAllMovements(0);
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
		// first, call the getAllProducts() - the parent service
		ProductService.getAllProducts(page)
			// wait for the first promise (Product)
			.then(function(reply) {
				if(reply.status === 200) {
					// foreach() through the array from the first promise
					reply.data.forEach(function(product, index) {
						// call the getVendorByVendorId() - the child service
						VendorService.getVendorByVendorId(reply.data[index].vendorId)
							.then(function(vendor) {
								if(reply.status === 200) {
									reply.data[index].vendor = vendor.data;
								}
							});
						// call the getMovementByProductId() - the child service
						MovementService.getMovementByProductId(reply.data[index].productId)
							.then(function(movement) {
								if(reply.status === 200) {
									reply.data[index].movement = movement.data;
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
					return ($scope.vendors);
				} else {
					$scope.statusClass = "alert-danger";
					$scope.statusMessage = reply.message;
				}
			});
		return ($scope.vendors);
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

	$scope.closeAddModal = function() {
		var angularRoot = angular.element(document.querySelector("#AddProductModal"));
		angularRoot.modal("hide");
	};

	$scope.closeEditModal = function() {
		var angularRoot = angular.element(document.querySelector("#EditProductModal"));
		angularRoot.modal("hide");
	};

	$scope.products = $scope.getAllProducts(0);
});