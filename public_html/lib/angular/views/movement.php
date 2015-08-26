<!--  Movement Container  -->
<div class="container">
	<h3> Your <em>Movements</em></h3>

	<!--  Movement Buttons -->
	<div class="movement button row">
		<div class="col-md-4">
			<button type="button" class="btn btn-primary btn-lg center-block" data-toggle="modal" data-target="#AddMovementModal">
				Add <br> +
			</button>
		</div>
		<div class="col-md-4">
			<button type="button" class="btn btn-primary btn-lg center-block" data-toggle="modal" data-target="#EditMovementModal">
				Edit <br> E
			</button>
		</div>
		<div class="col-md-4">
			<button type="button" class="btn btn-primary btn-lg center-block" data-toggle="modal" data-target="#DeleteMovementModal">
				Delete <br> -
			</button>
		</div>
	</div>

	<!--  Movement Reports -->
	<div class="container movement reports row">
		<h4>Reports</h4>

		<div class="col-md-12">
			<table id="example" class="table table-striped table-bordered" width="100%" cellspacing="0">
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
					<tr ng-repeat="movement in movements">
						<td>{{ movement.fromLocationId }}</td>
						<td>{{ movement.toLocationId }}</td>
						<td>{{ movement.productId }}</td>
						<td>{{ movement.userId }}</td>
						<td>{{ movement.movementDate }}</td>
						<td>{{ movement.movementType }}</td>
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
							<label for="selectProduct" class="col-sm-4 control-label">Choose a product:</label>
							<div class="col-sm-8">
								<select id="selectProduct" class="col-sm-8 form-control">
									<!--"no-option" is a custom class to style the disabled option-->
									<option class="no-option" value="" disabled selected>Select a Product</option>
									<option value="PHP">PHP</option>
									<option value="JavaScript">JavaScript</option>
									<option value="HTML">HTML</option>
									<option value="CSS">CSS</option>
									<option value="Klingon">Klingon (Qapla'!)</option>
								</select>
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
					</form>
					<pre>form = {{ movement | json }}</pre>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Sign-Up</button>
				</div>
			</div>
		</div>
	</div>
</div>