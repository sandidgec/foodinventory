<!--  Vendor Container  -->
<div class="vendor-tab row">
	<h3>Your <em>Vendors</em></h3>

	<!--  Vendor Buttons -->
	<div class="vendor button row">
		<div class="col-md-3 text-center">
			<a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#AddVendorModal">
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

	<!--  Vendor Reports -->
	<div class="vendor reports">
		<h4>Report</h4>

		<div ng-controller="VendorController">
			<table id="vendor-table" class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Vendor Name</th>
						<th>Contact Name</th>
						<th>Email</th>
						<th>Phone Number</th>
						<th class="center"><i class="fa fa-pencil fa-x"></i></th>
						<th class="center"><i class="fa fa-trash fa-x"></i></th>
					</tr>
				</thead>

				<tbody>
					<tr ng-repeat="vendor in vendors">
						<td>{{ vendor.vendorName }}</td>
						<td>{{ vendor.contactName }}</td>
						<td>{{ vendor.vendorEmail }}</td>
						<td>{{ vendor.vendorPhoneNumber }}</td>
						<td>
							<a href="#" class="btn btn-md btn-info" ng-click="setEditedVendor(vendor);" data-toggle="modal" data-target="#EditVendorModal">
								<i class="fa fa-pencil"></i>
							</a>
						</td>
						<td>
							<form ng-submit="deleteVendor(vendor.vendorId);">
								<button type="submit" class="btn btn-md btn-danger"><i class="fa fa-trash"></i></button>
							</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!--  Add Vendor Modal -->
	<div class="modal fade" id="AddVendorModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Add a Vendor</h3>
				</div>

				<div class="modal-body" ng-controller="VendorController">
					<form class="form-horizontal" method="post" ng-submit="addVendor(vendor);">
						<div class="form-group">
							<label for="vendorName" class="col-sm-3 control-label">Vendor Name</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="vendor-name" name="vendor-name" placeholder="Enter Vendor's Name" ng-model="vendor.vendorName"/>
							</div>
						</div>
						<div class="form-group">
							<label for="contactName" class="col-sm-3 control-label">Contact Name</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="contactName" name="contactName" placeholder="Enter Contact'a Name" ng-model="vendor.contactName"/>
							</div>
						</div>
						<div class="form-group">
							<label for="vendorEmail" class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="vendorEmail" name="vendorEmail" placeholder="Enter Vendor's Email" ng-model="vendor.vendorEmail"/>
							</div>
						</div>
						<div class="form-group">
							<label for="vendorPhoneNumber" class="col-sm-3 control-label">Phone Number</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="vendorPhoneNumber" name="vendorPhoneNumber" placeholder="Enter Vendor's Phone Number" ng-model="vendor.vendorPhoneNumber"/>
							</div>
						</div>
						<pre>form = {{ vendor | json }}</pre>
						<button type="submit" class="btn btn-info">Submit</button>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!--Edit Vendor Modal-->
	<div class="modal fade" id="EditVendorModal" ng-controller="VendorController" ng-show="isEditing">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Edit a Vendor</h3>
				</div>

				<div class="modal-body">
					<form class="form-horizontal" method="post" ng-submit="editVendor(vendor);">
						<div class="form-group">
							<label for="vendorName" class="col-sm-3 control-label">Vendor Name</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="vendor-name" name="vendor-name" placeholder="Enter Vendor's Name" ng-model="vendor.vendorName" required/>
							</div>
						</div>
						<div class="form-group">
							<label for="contactName" class="col-sm-3 control-label">Contact Name</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="contactName" name="contactName" placeholder="Enter Contact'a Name" ng-model="vendor.contactName"/>
							</div>
						</div>
						<div class="form-group">
							<label for="vendorEmail" class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="vendorEmail" name="vendorEmail" placeholder="Enter Vendor's Email" ng-model="vendor.vendorEmail"/>
							</div>
						</div>
						<div class="form-group">
							<label for="vendorPhoneNumber" class="col-sm-3 control-label">Phone Number</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="vendorPhoneNumber" name="vendorPhoneNumber" placeholder="Enter Vendor's Phone Number" ng-model="vendor.vendorPhoneNumber"/>
							</div>
						</div>
						<button type="submit" class="btn btn-info">Save</button>
						<button class="btn btn-warning" data-dismiss="modal" ng-click="cancelEditing()">Cancel</button>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" ng-click="cancelEditing();">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>