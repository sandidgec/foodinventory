<!--  Location Container  -->
<div class="location-tab row">
	<h3> Your <em>Location</em></h3>

	<!--  Location Buttons -->
	<div class="location button row">
		<div class="col-md-3 text-center">
			<a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#AddLocationModal">
				<i class="fa fa-plus fa-2x"></i>
			</a>
		</div>
		<div class="col-md-5 col-md-offset-4">
			<label for="search" class="col-sm-2 control-label">Search: </label>

			<div class="col-sm-8 col-sm-offset-2" ng-controller="LocationController">
				<input type="text" class="form-control" id="location-search" name="location-search" placeholder="Search"
						 ng-model="location.description" typeahead="location.description for location in getLocationByDescription($viewValue)"
						 typeahead-loading="loadingLocations" typeahead-no-results="noResults"/>
				<span class="input-group-addon"> <i class="fa fa-search"></i></span>
				<i ng-show="loadingLocations" class="glyphicon glyphicon-refresh"></i>

				<div ng-show="noResults">
					<i class="glyphicon glyphicon-remove"></i>No Results Found
				</div>
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
						<th>Location</th>
						<th>Storage Code</th>
						<th class="center"><i class="fa fa-pencil fa-x"></i></th>
						<th class="center"><i class="fa fa-trash fa-x"></i></th>
					</tr>
				</thead>

				<tbody>
					<tr ng-repeat="location in locations">
						<td>{{ location.description }}</td>
						<td>{{ location.storageCode }}</td>
						<td>
							<a href="#" class="btn btn-xs btn-info" ng-click="setEditedLocation(location);" data-toggle="modal" data-target="#EditLocationModal">
								<i class="fa fa-pencil tableicons"></i>
							</a>
						</td>
						<td>
							<form ng-submit="deleteLocation(location.locationId);">
								<button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash tableicons"></i></button>
							</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Add Location Modal -->
	<div class="modal fade" id="AddLocationModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" ng-hide="isEditing">Add a Location</h3>
				</div>
				<div class="modal-body" ng-controller="LocationController">
					<form class="form-horizontal" method="post" ng-submit="addLocation(location);">
						<div class="form-group">
							<label for="location-description" class="col-sm-3 control-label">Location</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" id="location-description" name="location-description" placeholder="Enter Location" ng-model="location.description"/>
							</div>
						</div>
						<div class="form-group">
							<label for="storage-code" class="col-sm-3 control-label">Storage Code</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" id="storage-code" name="storage Code" placeholder="Enter Storage Code" ng-model="location.storageCode"/>
							</div>
						</div>
						<button type="submit" class="btn btn-info">Submit</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!--Edit Location Modal-->
	<div class="modal fade" id="EditLocationModal" ng-controller="LocationController" ng-show="isEditing">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Edit a Location</h3>
				</div>

				<div class="modal-body">
					<form class="form-horizontal" ng-submit="updateLocation(location);">
						<div class="form-group">
							<label for="edit-storage-code" class="col-sm-3 control-label">Storage Code</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" id="edit-storage-code" name="edit-storage Code" placeholder="Enter Storage Code" ng-model="editedLocation.storageCode" required/>
							</div>
						</div>
						<div class="form-group">
							<label for="edit-location-description" class="col-sm-3 control-label">Description</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" id="edit-location-description" name="edit-location-description" placeholder="Enter Location Description"
										 ng-model="editedLocation.description" required/>
							</div>
						</div>
						<button type="submit" class="btn btn-info">Save</button>
						<button class="btn btn-warning" data-dismiss="modal" ng-click="cancelEditing();">Cancel</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>