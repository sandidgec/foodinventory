<!--  Movement Container  -->
<div class="container">
	<h3> Your <em>Movements</em></h3>

	<!--  Movement Buttons -->
	<div class="movement button row">
		<div class="col-md-12 text-center">
			<a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#AddMovementModal">
				<i class="fa fa-plus-square fa-5x"></i>
			</a>
		</div>
	</div>

	<!--  Movement Reports -->
	<div class="container movement reports row">
		<h4>Reports</h4>

		<div class="col-md-12" ng-controller="MovementController">
			<table id="movementTable" class="table table-bordered table-hover table-responsive table-striped" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>From</th>
						<th>To</th>
						<th>Product</th>
						<th>User</th>
						<th>Movement Date</th>
						<th>Movement Type</th>
					</tr>
				</thead>

				<tbody>
					<tr ng-repeat="">
						<td>{{ movements.fromLocationId }}</td>
						<td>{{ movements.toLocationId }}</td>
						<td>{{ movements.productId }}</td>
						<td>{{ movements.userId }}</td>
						<td>{{ movements.movementDate }}</td>
						<td>{{ movements.movementType }}</td>
						<td>
<!--							<button class="btn btn-info" ng-click="setEditedMovement(movement);"><i class="fa fa-pencil"></i></button>-->
<!--							<form ng-submit="deleteMovement(movement.movementId);">-->
<!--								<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>-->
<!--							</form>-->
						</td>
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
					<form class="form-horizontal" ng-submit="addMovement(movement);">
						<div class="form-group">
							<label for="product-search" class="col-sm-4 control-label">Product:</label>

							<div class="col-sm-8">
								<input type="text" class="form-control" id="product-search" name="product-search" placeholder="Product Search"
										 ng-model="movement.productId" typeahead="title for title in getProductByTitle($viewValue)"
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
								<input type="text" class="form-control" id="fromLocation-search" name="fromLocation-search" placeholder="Location Search"
										 ng-model="movement.locationId" typeahead="storageCode for storageCode in getLocationByStorageCode($viewValue)"
										 typeahead-loading="loadingFromLocations" typeahead-no-results="noResults">
								<i ng-show="loadingFromLocations" class="glyphicon glyphicon-refresh"></i>
								<div ng-show="noResults">
									<i class="glyphicon glyphicon-remove"></i> No Results Found
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="movementType" class="col-sm-4 control-label">Movement Type:</label>

							<div class="col-sm-8">
								<input type="text" class="form-control" id="movementType" name="movementType" placeholder="e.g. RM for (Removed)" ng-model="movement.movementType"/>
							</div>
						</div>
						<div class="form-group">
							<label for="cost" class="col-sm-4 control-label">Cost (Purchase Price):</label>

							<div class="col-sm-8">
								<input type="text" class="form-control" id="cost" name="cost" placeholder="e.g. $15.00" ng-model="movement.cost"/>
							</div>
						</div>
						<div class="form-group">
							<label for="price" class="col-sm-4 control-label">Price (Selling Price):</label>

							<div class="col-sm-8">
								<input type="text" class="form-control" id="price" name="price" placeholder="e.g. $19.99" ng-model="movement.price"/>
							</div>
						</div>
						<pre>form = {{ movement | json }}</pre>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Sign-Up</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>