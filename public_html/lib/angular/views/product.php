<!--  Product Container  -->
<div class="list-group">
	<!--  Product Container  -->
	<div class="list-group-item">
		<h3> Your <em>Products</em></h3>

		<!--  Product Buttons -->
		<div class="product button row">
			<div class="col-md-4">
				<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ProductModal">
					Add <br> +
				</button>
			</div>
			<div class="col-md-4">
				<button class="btn btn-default" ng-click="editProduct(product)" value="Edit"> E </button>
			</div>
			<div class="col-md-4">
				<button class="btn btn-default" ng-click="deleteProduct(product)" value="Delete"> - </button>
			</div>
		</div>

		<!--  Product Reports -->
		<div class="product reports row">
			<h4>Reports</h4>
			<div class="col-md-12">
				<table id="example" class="table table-striped table-bordered" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Title</th>
							<th>Desciption</th>
							<th>Vendor</th>
							<th>Lead Time</th>
							<th>SKU</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<th>Title</th>
							<th>Desciption</th>
							<th>Vendor</th>
							<th>Lead Time</th>
							<th>SKU</th>
						</tr>
					</tfoot>

					<tbody>
						<tr ng-repeat="product in products">
							<td>{{ product.title }}</td>
							<td>{{ product.description }}</td>
							<td>{{ product.vendorId }}</td>
							<td>{{ prpoduct.leadTime }}</td>
							<td>{{ product.sku }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<!--  Add Product Modal -->
		<div class="modal fade" id="ProductModal">
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
								<label for="title" class="col-sm-3 control-label">Product Title:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="title" name="title" placeholder="e.g. Green Beads 4in." ng-model="product.title"/>
								</div>
							</div>
							<div class="form-group">
								<label for="description" class="col-sm-3 control-label">Description:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="description" name="description" placeholder="e.g. Green beads w/ 4in length, 1in hole, sparkly" ng-model="product.description"/>
								</div>
							</div>
							<div class="form-group">
								<label for="vendor" class="col-sm-3 control-label">Vendor:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="vendor" name="vendor" placeholder="e.g. Beads-R-US" ng-model="product.vendorId"/>
								</div>
							</div>
							<div class="form-group">
								<label for="leadTime" class="col-sm-3 control-label">Lead Time:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="leadTime" name="leadTime" placeholder="e.g. 14(days) " ng-model="product.leadTime"/>
								</div>
							</div>
							<div class="form-group">
								<label for="sku" class="col-sm-3 control-label">SKU:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="sku" name="sku" placeholder="e.g. TGT345" ng-model="product.sku"/>
								</div>
							</div>
						</form>
						<pre>form = {{ product | json }}</pre>
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