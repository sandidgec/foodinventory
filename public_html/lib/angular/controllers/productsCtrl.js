/**
 * creating app.controller function for products.php and product-edit.php
 * in the food inventory web application
 *
 *
 * file started by Marie on Sunday 8/23/15—
 * may need revisions based on
 * other team members' code
 */


function angularModule() {
// wrapping angular.module within a javaScript function

	var app = angular.module("", []);

	app.controller("productsCtrl", function ($scope, $modal, $filter, Data) {
		//get data for product
		$scope.product = {};
		Data.get("products").then(function(data){
			$scope.products = data.data;
		});
		//change product status using product status and data put
		$scope.changeProductStatus = function(product){
			product.status = (product.status=="Active" ? "Inactive" : "Active");
			Data.put("products/"+product.id,{status:product.status});
		};
		//delete product but confirm with message first
		$scope.deleteProduct = function(product){
			if(confirm("Are you sure you want to remove the product?")){
				Data.delete("products/"+product.id).then(function(result){
					$scope.products = _.without($scope.products, _.findWhere($scope.products, {id:product.id}));
				});
			}
		};













	});




	app.controller("product-editCtrl", function ($scope, $modalInstance, item, Data) {











	});
















	}