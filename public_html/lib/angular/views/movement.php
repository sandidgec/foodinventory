<!--  Movement Container  -->
<div class="movement-tab row">
	<h3>Your <em>Movements</em></h3>

	<!--  Movement Buttons -->
	<div class="movement button row">
		<div class="col-md-3 text-center">
			<a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#AddMovementModal">
				<i class="fa fa-plus fa-2x"></i>
			</a>
		</div>
		<div class="col-md-5 col-md-offset-4">
			<label for="search" class="col-sm-2 control-label">Search: </label>
			<div class="col-sm-8 col-sm-offset-2">
				<input type="text" class="form-control" id="search" name="search" placeholder="Search Stuff Here"/>
			</div>
		</div>
	</div>

	<!--  Movement Reports -->
	<div class="movement reports">
		<h4>Reports</h4>

		<div ng-controller="MovementController">
			<table id="movement-table" class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Product</th>
						<th>From</th>
						<th>To</th>
						<th>User</th>
						<th>Cost</th>
						<th>Movement Date</th>
						<th>Movement Type</th>
						<th>Price</th>
					</tr>
				</thead>

				<tbody>
					<tr ng-repeat="movement in movements">
						<td>{{ movement.product.title }}</td>
						<td>{{ movement.fromLocation.description }}</td>
						<td>{{ movement.toLocation.description }}</td>
						<td>{{ movement.user.firstName }}</td>
						<td>{{ movement.cost | currency}}</td>
						<td>{{ movement.movementDate | date }}</td>
						<td>{{ movement.movementType }}</td>
						<td>{{ movement.price | currency }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!--  Add Movement Modal -->
	<div class="modal fade" id="AddMovementModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Add a Movement</h3>
				</div>

				<div class="modal-body" ng-controller="MovementController">
					<form class="form-horizontal" method="post" ng-submit="addMovement(movement);">
						<div class="form-group">
							<label for="product-search" class="col-sm-4 control-label">Product:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="product-search" name="product-search" placeholder="Enter Product"
										 ng-model="movement.productId" typeahead="product.productId as product.title for product in getProductByTitle($viewValue)"
										 typeahead-loading="loadingProducts" typeahead-no-results="noResults">
								<i ng-show="loadingProducts" class="glyphicon glyphicon-refresh"></i>
								<div ng-show="noResults">
									<i class="glyphicon glyphicon-remove"></i> No Results Found
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="fromLocation-search" class="col-sm-4 control-label">From:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="fromLocation-search" name="fromLocation-search" placeholder="Enter Location"
										 ng-model="movement.fromLocationId" typeahead="location.locationId as location.storageCode for location in getLocationByStorageCode($viewValue)"
										 typeahead-loading="loadingFromLocations" typeahead-no-results="noResults">
								<i ng-show="loadingFromLocations" class="glyphicon glyphicon-refresh"></i>
								<div ng-show="noResults">
									<i class="glyphicon glyphicon-remove"></i> No Results Found
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="toLocation-search" class="col-sm-4 control-label">To:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="toLocation-search" name="toLocation-search" placeholder="Enter Location"
										 ng-model="movement.toLocationId" typeahead="location.locationId as location.description for location in getLocationByStorageCode($viewValue)"
										 typeahead-loading="loadingToLocations" typeahead-no-results="noResults">
								<i ng-show="loadingToLocations" class="glyphicon glyphicon-refresh"></i>
								<div ng-show="noResults">
									<i class="glyphicon glyphicon-remove"></i> No Results Found
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="user-search" class="col-sm-4 control-label">User:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="user-search" name="user-search" placeholder="Enter A User"
										 ng-model="movement.userId" typeahead="user.userId as user.email for user in getUserByEmail($viewValue)"
										 typeahead-loading="loadingUsers" typeahead-no-results="noResults">
								<i ng-show="loadingUsers" class="glyphicon glyphicon-refresh"></i>
								<div ng-show="noResults">
									<i class="glyphicon glyphicon-remove"></i> No Results Found
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="cost" class="col-sm-4 control-label">Cost:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="cost" name="cost" placeholder=" (Purchase Price) e.g. $15.00 " ng-model="movement.cost"/>
							</div>
						</div>
						<div class="form-group">
							<label for="movementType" class="col-sm-4 control-label">Movement Type:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="movementType" name="movementType" placeholder="e.g. RM for (Removed)" ng-model="movement.movementType"/>
							</div>
						</div>
						<div class="form-group">
							<label for="price" class="col-sm-4 control-label">Price:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="price" name="price" placeholder=" (Selling Price) e.g. $19.99 " ng-model="movement.price"/>
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
</div>