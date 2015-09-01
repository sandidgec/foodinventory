<!--  Notification Container  -->
<div class="notification-tab row">
	<h3> Your <em>Notifications</em></h3>

	<!--  Product Buttons -->
	<div class="notification button row">
		<div class="col-md-3 text-center">
			<a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#AddNotificationModal">
				<i class="fa fa-plus fa-2x"></i>
			</a>
		</div>
	</div>

	<!--  Product Reports -->
	<div class="notification reports">
		<h4>Reports</h4>

		<div ng-controller="NotificationController">
			<table id="notificationTable" class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Title</th>
						<th>Description</th>
						<th>Vendor</th>
						<th>SKU</th>
						<th>Lead Time</th>
					</tr>
				</thead>

				<tbody>
					<tr ng-repeat="notification in notifications">
						<td>{{ product.title }}</td>
						<td>{{ product.description }}</td>
						<td>{{ product.vendor.vendorName }}</td>
						<td>{{ product.sku }}</td>
						<td>{{ product.leadTime }}</td>
						<td>
							<div class="col-sm-6">
								<a href="#" class="btn btn-md btn-info" data-toggle="modal" data-target="#EditNotificationModal">
									<i class="fa fa-pencil"></i>
								</a>
							</div>
							<div class="col-sm-6">
								<form ng-submit="deleteNotification(notification.notificationId);">
									<button type="submit" class="btn btn-md btn-danger"><i class="fa fa-trash"></i></button>
								</form>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Add Product Modal -->
	<div class="modal fade" id="AddNotificationModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Add a Notification</h3>
				</div>

				<div class="modal-body" ng-controller="NotificationController">
					<form class="form-horizontal" method="post" ng-submit="addNotification(notification);">
						<div class="form-group">
							<label for="notification-content" class="col-sm-3 control-label">Notification Content:</label>
							<div class="col-sm-9">
								<textarea class="form-control" id="notification-content" name="notification-content" placeholder="Enter Notification" ng-model="notification.notificationContent"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="notification-datetime" class="col-sm-3 control-label">Notification DateTime: </label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="notification-datetime" name="notification-datetime" placeholder="Enter Notification DateTime" ng-model="notification.notificationDateTime"/>
							</div>
						</div>
						<div class="form-group">
							<label for="vendor-search" class="col-sm-3 control-label">Notification Handle:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="notification-datetime" name="notification-datetime" placeholder="Enter Notification DateTime" ng-model="notification.notificationDateTime"/>
							</div>
						</div>
						<pre>form = {{ notification | json }}</pre>
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
					<h3 class="modal-title">Edit a Notification</h3>
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