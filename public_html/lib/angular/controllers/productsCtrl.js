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
		//create a modalInstance that allows editing of product
		$scope.open = function (p,size) {
			var modalInstance = $modal.open({
				templateUrl: "partials/product-edit.php",
				controller: "product-editCtrl",
				//object size
				size: size,
				resolve: {
					item: function () {
						//return if or else if results below to insert and update
						return p;
					}
				}
			});
			modalInstance.result.then(function(selectedObject) {
				//insert product
				if(selectedObject.save == "insert"){
					$scope.products.push(selectedObject);
					$scope.products = $filter("orderBy")($scope.products, "id", "reverse");
					//update and save product
				}else if(selectedObject.save == "update"){
					p.productId = selectedObject.productId;
					p.title = selectedObject.title;
					p.description = selectedObject.description;
					p.vendorId = selectedObject.vendorId;
					p.sku = selectedObject.sku;
					p.locationId = selectedObject.locationId;
					p.quantity = selectedObject.quantity;
					p.leadTime = selectedObject.leadTime;
					p.alertId = selectedObject.alertId;
					p.finishedProductId = selectedObject.finishedProductId;
				}
			});
		};

		//create $scope columns
		$scope.columns = [
			{image:"image",predicate:"img",sortable:true},
			{text:"productId",predicate:"productId",sortable:true,dataType:"number"},
			{text:"title",predicate:"title",sortable:true},
			{text:"description",predicate:"description",sortable:true},
			{text:"vendorId",predicate:"vendorId",sortable:true,dataType:"number"},
			{text:"sku",predicate:"sku",sortable:true,dataType:"number"},
			{text:"locationId",predicate:"locationId",sortable:true,dataType:"number"},
			{text:"quantity",predicate:"quantity",sortable:true,dataType:"number"},
			{text:"leadTime",predicate:"leadTime",sortable:true,dataType:"number"},
			{text:"alertId",predicate:"alertId",sortable:true,dataType:"number"},
			{text:"finishedProductId",predicate:"finishedProductId",sortable:true,dataType:"number"},
		];












	});




	app.controller("product-editCtrl", function ($scope, $modalInstance, item, Data) {











	});
















	}