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
							<label for="storage-code" class="col-sm-3 control-label">Storage Code</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="storage-code" name="storage Code" placeholder="Enter Storage Code" ng-model="location.storageCode" required/>
							</div>
						</div>
						<div class="form-group">
							<label for="location-description" class="col-sm-3 control-label">Description</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="location-description" name="location-description" placeholder="Enter Location Description" ng-model="location.description" required/>
							</div>
						</div>
						<pre>form = {{ location | json }}</pre>
						<button type="submit" class="btn btn-info">Create</button>
					</form>
					<form name="editLocationForm" id="editLocationForm" class="form-horizontal" ng-submit="updateLocation(location);" ng-hide="isEditing">
						<div class="form-group">
							<label for="edit-storage-code" class="col-sm-3 control-label">Storage Code</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="edit-storage-code" name="edit-storage Code" placeholder="Enter Storage Code" ng-model="editedLocation.storageCode" required/>
							</div>
						</div>
						<div class="form-group">
							<label for="edit-location-description" class="col-sm-3 control-label">Description</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="edit-location-description" name="edit-location-description" placeholder="Enter Location Description" ng-model="editedLocation.description" required/>
							</div>
						</div>
						<pre>form = {{ location | json }}</pre>
						<button type="submit" class="btn btn-info">save</button>
						<button class="btn btn-info" ng-click="cancelEditing();">Cancel</button>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>