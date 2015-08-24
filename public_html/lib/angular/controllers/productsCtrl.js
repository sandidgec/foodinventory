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

	//create app.controller for productsCtrl
	app.controller("ProductsCtrl", function ($scope, $modal, $filter, Data) {
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



	//create app.controller for product-editCtrl
	app.controller("Product-editCtrl", function ($scope, $modalInstance, item, Data) {
		//create $modalInstance for product items by copying and editing to update and save revised product
		$scope.product = angular.copy(item);

		$scope.cancel = function () {
			$modalInstance.dismiss("Close");
		};
		$scope.title = (item.id > 0) ? "Edit Product" : "Add Product";
		$scope.buttonText = (item.id > 0) ? "Update Product" : "Add New Product";

		var original = item;
		$scope.isClean = function() {
			return angular.equals(original, $scope.product);
		}
		//saveProduct $scope by updating data to put and inserting data to post
		$scope.saveProduct = function (product) {
			product.uid = $scope.uid;
			if(product.id > 0){
				Data.put("products/"+product.id, product).then(function (result) {
					if(result.status != "error"){
						var x = angular.copy(product);
						x.save = "update";
						$modalInstance.close(x);
					}else{
						//create results on console—QUESTION is this secure on console as a PUT or does it need to be sanitized???
						console.log(result);
					}
				});
			}else{
				product.status = "Active";
				Data.post("products", product).then(function (result) {
					if(result.status != "error"){
						var x = angular.copy(product);
						x.save = "insert";
						x.id = result.data;
						$modalInstance.close(x);
					}else{
						//create results on console—QUESTION is this secure on console as a POST or does it need to be sanitized???
						console.log(result);
					}
				});
			}
		};
	});
	}