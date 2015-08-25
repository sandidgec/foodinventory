<!--  Vendors Container  -->
<div class="list-group">
	<!--  Vendor Container  -->
	<div class="list-group-item" ng-repeat="vendor in vendors">
		<h3> Vendor <em>Number One</em></h3>

		<!--  Vendor Buttons -->
		<div class="vendor button row">
			<div class="col-md-4">
				<button class="btn btn-default" ng-click="addVendor(vendor)" value="ADD">+</button>
			</div>
			<div class="col-md-4">
				<button class="btn btn-default" ng-click="editVendor(vendor)" value="Edit">E</button>
			</div>
			<div class="col-md-4">
				<button class="btn btn-default" ng-click="deleteVendor(vendor)" value="Delete">-</button>
			</div>
		</div>


		<ul>
			<h4>Reports</h4>
			<li ng-repeat="product in vendor.products">
				<blockquote>
					<strong>{{product.title}} </strong>
					{{product.description}}
					<cite class="clearfix">-{{product.sku}} on {{product.leadtime}}</cite>
				</blockquote>
			</li>
		</ul>

		<!--  Review Form -->
		<form name="VendorForm" class="container" ng-controller="VendorController as VendorCtrl"
				ng-submit="VendorForm.$valid && VendorCtrl.addVendor(movement)" novalidate>

			<!--  Live Preview -->
			<blockquote ng-show="review">
				<strong>{{reviewCtrl.review.stars}} Stars</strong>
				{{reviewCtrl.review.body}}
				<cite class="clearfix">-{{reviewCtrl.review.author}}</cite>
			</blockquote>

			<!--  Review Form -->
			<h4>Submit a Vendor</h4>
			<fieldset class="form-group">
				<input ng-model="VendorCtrl.contactName" type="text" class="form-control" placeholder="Topher Sucks" title="Contact Name" required />
			</fieldset>
			<fieldset class="form-group">
				<input ng-model="VendorCtrl.vendorEmail" type="email" class="form-control" placeholder="topersucks@myunit.test" title="Vendor Email" required />
			</fieldset>
			<fieldset class="form-group">
				<input ng-model="VendorCtrl.vendorName" type="text" class="form-control" placeholder="Angular Company" title="Vendor Name" required />
			</fieldset>
			<fieldset class="form-group">
				<input ng-model="VendorCtrl.vendorPhoneNumber" type="number" class="form-control" placeholder="5555555" title="Phone Number" required />
			</fieldset>
			<fieldset class="form-group">
				<div> VendorForm is {{vendorForm.$valid}}</div>
				<input type="submit" class="btn btn-primary pull-right" value="Submit Vendor" />
			</fieldset>
		</form>
	</div>
</div>
