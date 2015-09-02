<!--  Product Container  -->
<div class="product-tab row">
	<h3>Your <em>Products</em></h3>

	<!--  Product Buttons -->
	<div class="product button row">
		<div class="col-md-3 text-center">
			<a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#ProductModal">
				<i class="fa fa-plus fa-2x"></i>
			</a>
		</div>
		<div class="col-md-5 col-md-offset-4">
			<label for="search" class="col-sm-2 control-label">Search: </label>
			<div class="col-sm-8 col-sm-offset-2">
				<input type="text" class="form-control" id="search" name="search" placeholder="Search Stuff Here" />
			</div>
		</div>
	</div>

	<!--  Product Reports -->
	<div class="product reports">
		<h4>Reports</h4>

		<div ng-controller="ProductController">
			<table id="productTable" class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Title</th>
						<th>Description</th>
						<th>Vendor</th>
						<th>SKU</th>
						<th>Lead Time</th>
						<th class="center"><i class="fa fa-pencil fa-x"></i></th>
						<th class="center"><i class="fa fa-trash fa-x"></i></th>
					</tr>
				</thead>

				<tbody>
					<tr ng-repeat="product in products">
						<td>{{ product.title }}</td>
						<td>{{ product.description }}</td>
						<td>{{ product.vendor.vendorName }}</td>
						<td>{{ product.sku }}</td>
						<td>{{ product.leadTime }}</td>
						<td>
							<a href="#" class="btn btn-md btn-info" ng-click="setEditedProduct(product);" data-toggle="modal" data-target="#ProductModal">
								<i class="fa fa-pencil"></i>
							</a>
						</td>
						<td>
							<form ng-submit="deleteProduct(product.productId);">
								<button type="submit" class="btn btn-md btn-danger"><i class="fa fa-trash"></i></button>
							</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Add Product Modal -->
<!--	<div class="modal fade" id="AddProductModal">-->
<!--		<div class="modal-dialog">-->
<!--			<div class="modal-content">-->
<!---->
<!--				<div class="modal-header">-->
<!--					<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--						<span aria-hidden="true">&times;</span></button>-->
<!--					<h3 class="modal-title">Add a Product</h3>-->
<!--				</div>-->
<!---->
<!--				<div class="modal-body" ng-controller="ProductController">-->
<!--					<form class="form-horizontal" method="post" ng-submit="addProduct(product);">-->
<!--						<div class="form-group">-->
<!--							<label for="product-title" class="col-sm-3 control-label">Title:</label>-->
<!--							<div class="col-sm-9">-->
<!--								<input type="text" class="form-control" id="product-title" name="product-title" placeholder="Enter Product Title" ng-model="product.title"/>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="form-group">-->
<!--							<label for="Description" class="col-sm-3 control-label">Description</label>-->
<!--							<div class="col-sm-9">-->
<!--								<input type="text" class="form-control" id="description" name="description" placeholder="Enter Product Description" ng-model="product.description"/>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="form-group">-->
<!--							<label for="vendor-search" class="col-sm-3 control-label">Vendor</label>-->
<!--							<div class="col-sm-8">-->
<!--								<input type="text" class="form-control" id="vendor-search" name="vendor-search" placeholder="Enter Vendor"-->
<!--										 ng-model="product.vendorId" typeahead="vendor.vendorId as vendor.vendorName for vendor in getVendorByVendorName($viewValue)"-->
<!--										 typeahead-loading="loadingVendors" typeahead-no-results="noResults"/>-->
<!--								<i ng-show="loadingVendors" class="glyphicon glyphicon-refresh"></i>-->
<!--								<div ng-show="noResults">-->
<!--									<i class="glyphicon glyphicon-remove"></i>No Results Found-->
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="form-group">-->
<!--							<label for="sku" class="col-sm-3 control-label">SKU:</label>-->
<!--							<div class="col-sm-9">-->
<!--								<input type="text" class="form-control" id="sku" name="sku" placeholder="Enter SKU " ng-model="product.sku"/>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="form-group">-->
<!--							<label for="leadTime" class="col-sm-3 control-label">Lead Time:</label>-->
<!--							<div class="col-sm-9">-->
<!--								<input type="text" class="form-control" id="leadTime" name="leadTime" placeholder="Enter Order Lead Time" ng-model="product.leadTime"/>-->
<!--							</div>-->
<!--						</div>-->
<!--						<pre>form = {{ product | json }}</pre>-->
<!--						<button type="submit" class="btn btn-primary">Submit</button>-->
<!--					</form>-->
<!--				</div>-->
<!---->
<!--				<div class="modal-footer">-->
<!--					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->

	<!-- Add/Edit Product Modal -->
	<div class="modal fade" id="ProductModal">
		<div class="modal-dialog">
			<div class="modal-content" ng-controller="ProductController">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" ng-hide="isEditing">Create a Product</h3>
					<h3 class="modal-title" ng-show="isEditing">Edit a Product</h3>
				</div>

				<div class="modal-body">
					<form name="addProductForm" id="addProductForm" class="form-horizontal" ng-submit="addProduct(product);" ng-hide="isEditing" novalidate>
						<div class="form-group">
							<label for="product-title" class="col-sm-3 control-label">Title:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="product-title" name="product-title" placeholder="Enter Product Title" ng-model="product.title" required/>
							</div>
						</div>
						<div class="form-group">
							<label for="description" class="col-sm-3 control-label">Description</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="description" name="description" placeholder="Enter Product Description" ng-model="product.description"/>
							</div>
						</div>
						<div class="form-group">
							<label for="vendor-search" class="col-sm-3 control-label">Vendor</label>
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
							<label for="leadTime" class="col-sm-3 control-label">Lead Time:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="leadTime" name="leadTime" placeholder="Enter Order Lead Time" ng-model="product.leadTime"/>
							</div>
						</div>
						<pre>form = {{ product | json }}</pre>
						<button type="submit" class="btn btn-info">Create</button>
					</form>
					<form id="editProductForm" class="form-horizontal" ng-submit="updateProduct(editedProduct);" ng-show="isEditing">
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
							<label for="edit-sku" class="col-sm-3 control-label">SKU:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="edit-sku" name="edit-sku" placeholder="Enter SKU " ng-model="editedProduct.sku"/>
							</div>
						</div>
						<div class="form-group">
							<label for="edit-leadTime" class="col-sm-3 control-label">Lead Time:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="edit-leadTime" name="edit-leadTime" placeholder="Enter Order Lead Time" ng-model="editedProduct.leadTime"/>
							</div>
						</div>
						<pre>form = {{ editedProduct | json }}</pre>
						<button type="submit" class="btn btn-info">Save</button>
						<button class="btn btn-warning" ng-click="cancelEditing();">Cancel</button>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>