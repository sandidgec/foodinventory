<!--  Location Container  -->
<div class="location-tab row">
	<h3> Your <em>Location</em></h3>

	<!--  Location Buttons -->
	<div class="location button row">
		<div class="col-md-3 text-center">
			<a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#LocationModal">
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

	<!--  Location Reports -->
	<div class="location reports">
		<h4>Reports</h4>

		<div ng-controller="LocationController">
			<table id="location-table" class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Storage Code</th>
						<th>description</th>
						<th class="center"><i class="fa fa-pencil fa-x"></i></th>
						<th class="center"><i class="fa fa-trash fa-x"></i></th>
					</tr>
				</thead>

				<tbody>
					<tr ng-repeat="location in locations">
						<td>{{ location.storageCode }}</td>
						<td>{{ location.decription }}</td>
						<td>
							<a href="#" class="btn btn-md btn-info" ng-click="setEditedLocation(location);" data-toggle="modal" data-target="#LocationModal">
								<i class="fa fa-pencil"></i>
							</a>
						</td>
						<td>
							<form ng-submit="deleteLocation(location.productId);">
								<button type="submit" class="btn btn-md btn-danger"><i class="fa fa-trash"></i></button>
							</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Add/Edit Product Modal -->
	<div class="modal fade" id="LocationModal">
		<div class="modal-dialog">
			<div class="modal-content" ng-controller="LocationController">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" ng-hide="isEditing">Create a Location</h3>
					<h3 class="modal-title" ng-show="isEditing">Edit a Location</h3>
				</div>

				<div class="modal-body">
					<form name="addLocationForm" id="addLocationForm" class="form-horizontal" ng-submit="addLocation(location);" ng-hide="isEditing" novalidate>
						<div class="form-group">
							<label for="location-description" class="col-sm-3 control-label">Description</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="location-description" name="location-description" placeholder="Enter Location Description" ng-model="location.description" required/>
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
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Edit Product Modal -->
	<div class="modal fade" id="EditProductModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Edit a Product</h3>
				</div>

				<div class="modal-body" ng-controller="ProductController">
					<form class="form-horizontal" ng-submit="addProduct(product);">
						<div class="form-group">
							<label for="product" class="col-sm-3 control-label">Product:</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" id="product" name="product" placeholder="Enter Product " ng-model="product.title"/>
							</div>
						</div>
						<div class="form-group">
							<label for="Description" class="col-sm-3 control-label">Description</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" id="description" name="description" placeholder="Enter Product Description" ng-model="product.description"/>
							</div>
						</div>
						<div class="form-group">
							<label for="vendor-search" class="col-sm-3 control-label">Vendor</label>

							<div class="col-sm-8">
								<input type="text" class="form-control" id="vendor-search" name="vendor-search" placeholder="Enter Vendor"
										 ng-model="product.vendorId" typeahead="vendor for vendorName in getVendorByVendorName($viewValue)"
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


<!--  Location Container  -->
<div class="list-group">
	<!--  Location Container  -->
	<div class="list-group-item">
		<h3> Your <em>Location</em></h3>

		<!--  Location Buttons -->
		<div class="location button row">
			<div class="col-md-4">
				<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#LocationModal">
					Add <br> +
				</button>
			</div>
			<div class="col-md-4">
				<button class="btn btn-default" ng-click="editLocation(location)" value="Edit"> E</button>
			</div>
			<div class="col-md-4">
				<button class="btn btn-default" ng-click="deleteLocation(location)" value="Delete"> -</button>
			</div>
		</div>

		<!--  Location Reports -->
		<div class="location reports row">
			<h4>Reports</h4>

			<div class="col-md-12">
				<table id="example" class="table table-striped table-bordered" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Product</th>
							<th>Storage Code</th>
							<th>description</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<th>Product</th>
							<th>Storage Code</th>
							<th>description</th>
						</tr>
					</tfoot>

					<tbody>
						<tr ng-repeat="location in locations">
							<td>{{ location.productId }}</td>
							<td>{{ location.stroageCode }}</td>
							<td>{{ location.decription }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<!--  Add Location Modal -->
		<div class="modal fade" id="LocationModal">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title">Add a Location</h3>
					</div>

					<div class="modal-body" ng-controller="LocationController">
						<form class="form-horizontal" method="post" ng-submit="addLocation(location);">
							<div class="form-group">
								<label for="storageCode" class="col-sm-3 control-label">Storage Code:</label>

								<div class="col-sm-9">
									<input type="text" class="form-control" id="storageCode" name="storageCode" placeholder="e.g. BR for (Back Room)" ng-model="location.storageCode"/>
								</div>
							</div>
							<div class="form-group">
								<label for="description" class="col-sm-3 control-label">Description:</label>

								<div class="col-sm-9">
									<input type="text" class="form-control" id="description" name="description" placeholder="e.g. Back room of linda's house" ng-model="location.description"/>
								</div>
							</div>
						</form>
						<pre>form = {{ location | json }}</pre>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Sign-Up</button>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>