<!--  Product Container  -->
<div class="list-group">
	<h3> Your <em>Products</em></h3>

	<!--  Product Buttons -->
	<div class="product button row">
		<div class="col-md-12 text-center">
			<a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#AddProductModal">
				<i class="fa fa-plus-square fa 5x"></i>
			</a>
		</div>
	</div>

	<!--  Product Reports -->
	<div class="product reports row">
		<h4>Reports</h4>

		<div class="col-md-12" ng-controller="ProductController">
			<table id="productTable" class="table table-bordered table-responsive table-striped" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Title</th>
						<th>Desciption</th>
						<th>Vendor</th>
						<th>Lead Time</th>
						<th>SKU</th>
					</tr>
				</thead>

				<tbody>
					<tr ng-repeat="">
						<td>{{ product.title }}</td>
						<td>{{ product.description }}</td>
						<td>{{ product.vendorId }}</td>
						<td>{{ prpoduct.leadTime }}</td>
						<td>{{ product.sku }}</td>
						<td>
							<button class="btn btn-info" ng-click="setEditedProduct(product);"><i class="fa fa-pencil"></i></button>
							<form ng-submit="deleteProduct(product.productId);">
								<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
							</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!--  Add Product Modal -->
	<div class="modal fade" id="AddProductModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Add a Product</h3>
				</div>

				<div class="modal-body" ng-controller="ProductController">
					<form class="form-horizontal" ng-submit="addProduct(product);">
						<div class="form-group">
							<label for="product-search" class="col-sm-4 control-label">Product</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="product-search" name="product-search" placeholder="Enter Product"
										 ng-model="product.title" typeahead="title for title in getProductByTitle($viewValue)"
										typeahead-loading="loadingProducts" typeahead-no-results="noResults"/>
								<i ng-show="loadingProducts" class="glyphicon glyphicon-refresh"></i>
								<div ng-show="noResults">
									<i class="glyphicon glyphicon-remove"></i>No Results Found
								</div>
							</div>
							<label for="description-search" class="col-sm-4 control-label">Description</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="description-search" name="description-search" placeholder="Enter Description"
										 ng-model="product.description" typeahead="description for description in getProductByDescription($viewValue)"
										 typeahead-loading="loadingDescription" typeahead-no-results="noResults"/>
								<i ng-show="loadingDesciption" class="glyphicon glyphicon-refresh"></i>
								<div ng-show="noResults">
									<i class="glyphicon glyphicon-remove"></i>No Results Found
								</div>
							</div>
							<label for="vendor-search" class="col-sm-4 control-label">Vendor</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="vendor-search" name="vendor-search" placeholder="Enter Vendor"
										 ng-model="product.vendorId" typeahead="vendorId for vendorname in getVendorByVendorName($viewValue)"
										 typeahead-loading="loadingVendors" typeahead-no-results="noResults"/>
								<i ng-show="loadingVendors" class="glyphicon glyphicon-refresh"></i>
								<div ng-show="noResults">
									<i class="glyphicon glyphicon-remove"></i>No Results Found
								</div>
							</div>
							<label for="sku-search" class="col-sm-4 control-label">SKU</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="sku-search" name="sku-search" placeholder="Enter SKU"
										 ng-model="product.sku" typeahead="sku for sku in getProductBySku($viewValue)"
										 typeahead-loading="loadingSKUs" typeahead-no-results="noResults"/>
								<i ng-show="loadingSKUs" class="glyphicon glyphicon-refresh"></i>
								<div ng-show="noResults">
									<i class="glyphicon glyphicon-remove"></i>No Results Found
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="leadTime" class="col-sm-3 control-label">Lead Time:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="leadTime" name="leadTime" placeholder="e.g. 14(days) " ng-model="product.leadTime"/>
							</div>
						</div>
						<pre>form = {{ product | json }}</pre>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>