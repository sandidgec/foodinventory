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
	</div>

	<!--  Vendor Reports -->
	<div class="vendor reports">
		<h4>Reports</h4>

		<div ng-controller="VendorController">
			<table id="vendor-table" class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Vendor Name</th>
						<th>Contact Name</th>
						<th>Email</th>
						<th>Phone Number</th>
					</tr>
				</thead>

				<tbody>
					<tr ng-repeat="vendor in vendors">
						<td>{{ vendor.vendorName }}</td>
						<td>{{ vendor.contactName }}</td>
						<td>{{ vendor.vendorEmail }}</td>
						<td>{{ vendor.vendorPhoneNumber }}</td>
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
								<input type="text" class="form-control" id="vendorName" name="vendorName" placeholder="e.g. Topher Sucks" ng-model="VendorCtrl.vendorName"/>
							</div>
						</div>
						<div class="form-group">
							<label for="contactName" class="col-sm-3 control-label">Contact Name</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="contactName" name="contactName" placeholder="e.g. Topher Sucks" ng-model="VendorCtrl.contactName"/>
							</div>
						</div>
						<div class="form-group">
							<label for="vendorEmail" class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="vendorEmail" name="vendorEmail" placeholder="e.g. Topher Sucks" ng-model="VendorCtrl.vendorEmail"/>
							</div>
						</div>
						<div class="form-group">
							<label for="vendorPhoneNumber" class="col-sm-3 control-label">Phone Number</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="vendorPhoneNumber" name="vendorPhoneNumber" placeholder="e.g. Topher Sucks" ng-model="VendorCtrl.vendorPhoneNumber"/>
							</div>
						</div>

						<pre>form = {{ vendor | json }}</pre>

						<button type="submit" class="btn btn-primary">Add A Vendor</button>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>