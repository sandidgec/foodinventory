<!--  Product Container  -->
<div class="product-tab row">
	<h3>Your <em>Products</em></h3>

	<!--  Product Buttons -->
	<div class="product button row">
		<div class="col-md-3 text-center">
			<a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#AddProductModal">
				<i class="fa fa-plus fa-2x"></i>
			</a>
		</div>
		<div class="col-md-5 col-md-offset-4">
			<label for="search" class="col-sm-2 control-label"></label>
			<div class="col-sm-8 col-sm-offset-2" ng-controller="ProductController">
				<div class="input-group">
				<input type="text" class="form-control" id="product-search" name="product-search" placeholder="Search"
						 ng-model="product.title" typeahead="product.title for product in getProductByTitle($viewValue)"
						 typeahead-loading="loadingProducts" typeahead-no-results="noResults"/>
					<span class="input-group-addon"> <i class="fa fa-search"></i></span>
					</div>
				<i ng-show="loadingProducts" class="glyphicon glyphicon-refresh"></i>
				<div ng-show="noResults">
					<i class="glyphicon glyphicon-remove"></i>No Results Found
				</div>
			</div>
		</div>
	</div>

	<!--  Product Reports -->
	<div class="product reports">
		<h4>Report</h4>

		<div ng-controller="ProductController">
			<table id="productTable" class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Title</th>
						<th>Description</th>
						<th>Quantity</th>
						<th>Vendor</th>
						<th>SKU</th>
						<th>Sell Price</th>
						<th>Purchase Cost</th>
						<th class="center"><i class="fa fa-pencil fa-x"></i></th>
						<th class="center"><i class="fa fa-trash fa-x"></i></th>
					</tr>
				</thead>

				<tbody>
					<tr ng-repeat="product in products">
						<td>{{ product.title }}</td>
						<td>{{ product.description }}</td>
						<td>{{ product.quantityOnHand }}</td>
						<td>{{ product.vendor.vendorName }}</td>
						<td>{{ product.sku }}</td>
						<td>{{ product.movement[0].price | currency }}</td>
						<td>{{ product.movement[0].cost | currency }}</td>
						<td>
							<button class="btn btn-xs btn-info" ng-click="setEditedProduct(product);" data-toggle="modal" data-target="#EditProductModal">
								<i class="fa fa-pencil tableicons"></i>
							</button>
						</td>
						<td>
							<form ng-submit="deleteProduct(product.productId);">
								<button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash tableicons"></i></button>
							</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Add Product Modal -->
	<div class="modal fade" id="AddProductModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Add a Product</h3>
				</div>

				<div class="modal-body" ng-controller="ProductController">
					<form class="form-horizontal" method="post" ng-submit="addProduct(product);">
						<div class="form-group">
							<label for="product-title" class="col-sm-3 control-label">Title:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="product-title" name="product-title" placeholder="Enter Product Title" ng-model="product.title"/>
							</div>
						</div>
						<div class="form-group">
							<label for="Description" class="col-sm-3 control-label">Description:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="description" name="description" placeholder="Enter Product Description" ng-model="product.description"/>
							</div>
						</div>
						<div class="form-group">
							<label for="vendor-search" class="col-sm-3 control-label">Vendor:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="vendor-search" name="vendor-search" placeholder="Enter Vendor"
										 ng-model="product.vendorId" typeahead="vendor.vendorId as vendor.vendorName for vendor in getVendorByVendorName($viewValue)"
										 typeahead-loading="loadingVendors" typeahead-no-results="noResults"/>
								<i ng-show="loadingVendors" class="glyphicon glyphicon-refresh"></i>
								<div ng-show="noResults">
									<i class="glyphicon glyphicon-remove"></i>No Results Found
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="sku" class="col-sm-3 control-label">SKU:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="sku" name="sku" placeholder="Enter SKU " ng-model="product.sku"/>
							</div>
						</div>
						<div class="form-group">
							<label for="cost" class="col-sm-3 control-label">Cost:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="cost" name="cost" placeholder="(Purchase Price) - e.g. $15.00 " ng-model="product.cost"/>
							</div>
						</div>
						<div class="form-group">
							<label for="quantity" class="col-sm-3 control-label">Quantity:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" ng-model="product.quantity"/>
							</div>
						</div>
						<div class="form-group">
							<label for="price" class="col-sm-3 control-label">Price:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="price" name="price" placeholder="(Selling Price) - e.g. $19.99 " ng-model="product.price"/>
							</div>
						</div>
<!--						<pre>form = {{ product | json }}</pre>-->
						<button type="submit" ng-click="closeAddModal()" class="btn btn-primary">Submit</button>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Edit Product Modal -->
	<div class="modal fade" id="EditProductModal" ng-controller="ProductController" ng-show="isEditing">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Edit a Product</h3>
				</div>

				<div class="modal-body">
					<form class="form-horizontal" method="post" ng-submit="editProduct(editedProduct);">
						<div class="form-group">
							<label for="edit-product-title" class="col-sm-3 control-label">Title:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="edit-product-title" name="edit-product-title" placeholder="Enter Product Title" ng-model="editedProduct.title" required/>
							</div>
						</div>
						<div class="form-group">
							<label for="edit-description" class="col-sm-3 control-label">Description</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="edit-description" name="edit-description" placeholder="Enter Product Description" ng-model="editedProduct.description"/>
							</div>
						</div>
						<div class="form-group">
							<label for="vendor-search" class="col-sm-3 control-label">Vendor</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="vendor-search" name="vendor-search" placeholder="Enter Vendor"
										 ng-model="editedProduct.vendorId" typeahead="vendor.vendorId as vendor.vendorName for vendor in getVendorByVendorName($viewValue)"
										 typeahead-loading="loadingVendors" typeahead-no-results="noResults"/>
								<i ng-show="loadingVendors" class="glyphicon glyphicon-refresh"></i>
								<div ng-show="noResults">
									<i class="glyphicon glyphicon-remove"></i>No Results Found
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="edit-sku" class="col-sm-3 control-label">SKU:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="edit-sku" name="edit-sku" placeholder="Enter SKU " ng-model="editedProduct.sku"/>
							</div>
						</div>
<!--						<pre>form = {{ product | json }}</pre>-->
						<button type="submit" ng-click="closeEditModal()" class="btn btn-info">Save</button>
						<button class="btn btn-warning" data-dismiss="modal" ng-click="cancelEditing();">Cancel</button>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" ng-click="cancelEditing();">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>