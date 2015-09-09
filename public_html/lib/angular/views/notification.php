<!--  Notification Container  -->
<div class="notification-tab row">
	<h3> Your <em>Notifications</em></h3>

	<!--  Product Buttons -->
	<div class="notification button row">
		<div class="col-md-3 text-center">
			<a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#AddAlertLevelModal">
				<i class="fa fa-plus fa-2x"></i>
			</a>
		</div>
		<div class="col-md-5 col-md-offset-4">
			<label for="search" class="col-sm-2 control-label">Search: </label>
			<div class="col-sm-8 col-sm-offset-2" ng-controller="NotificationController">
				<input type="text" class="form-control" id="notification-search" name="notification-search" placeholder="Enter Date"
						 ng-model="notification.notificationDateTime" typeahead="notification.notificationDateTime for notification in getNotificationByNotificationDateTime($viewValue)"
						 typeahead-loading="loadingNotifications" typeahead-no-results="noResults"/>
				<span class="input-group-addon"><i class=" fa fa-search"></i></span>
				</div>
			<i ng-show="loadingNotifications" class="glyphicon glyphicon-refresh"></i>
				<div ng-show="noResults">
					<i class="glyphicon glyphicon-remove"></i>No Results Found
				</div>
		</div>
	</div>

	<!--  Product Reports -->
	<div class="notification reports">
		<h4>Report History</h4>

		<div ng-controller="NotificationController">
			<table id="notificationTable" class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Date Time</th>
						<th>Email Status</th>
					</tr>
				</thead>

				<tbody>
					<tr ng-repeat="notification in notifications">
						<td>{{ notification.notificationDateTime | date }}</td>
						<td>{{ notification.emailStatus }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Add Alert Modal -->
	<div class="modal fade" id="AddAlertLevelModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Add an Alert</h3>
				</div>

				<div class="modal-body" ng-controller="AlertLevelController">
					<form class="form-horizontal" method="post" ng-submit="addAlertLevel(alertLevel);">
						<div class="form-group">
							<label for="product-search" class="col-sm-3 control-label">Product:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="product-search" name="product-search" placeholder="Enter Product"
										 ng-model="product.productId" typeahead="product.productId as product.title for product in getProductByTitle($viewValue)"
										 typeahead-loading="loadingProducts" typeahead-no-results="noResults"/>
								<i ng-show="loadingproducts" class="glyphicon glyphicon-refresh"></i>
								<div ng-show="noResults">
									<i class="glyphicon glyphicon-remove"></i>No Results Found
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="alertPoint" class="col-sm-3 control-label">Alert Level: </label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="alertPoint" name="alertPoint" placeholder="Enter Alert Level" ng-model="alert.alertPoint"/>
							</div>
						</div>
						<div class="form-group">
							<label for="alert operator" class="col-sm-3 control-label">Alert Operator</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="alertOperator" name="alertOperator" placeholder="Enter Alert Operator" ng-model="alert.alertOperator"/>
							</div>
						</div>
						<pre>form = {{ alert | json }}</pre>
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
	<div class="modal fade" id="EditAlertLevelModal" ng-controller="AlertLevelController" ng-show="isEditing" >
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Edit an Alert</h3>
				</div>

				<div class="modal-body" ng-controller="AlertLevelController">
					<form class="form-horizontal" ng-submit="editAlert(editedalert);">
						<div class="form-group">
							<label for="product-search" class="col-sm-3 control-label">Product:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="product-search" name="product-search" placeholder="Enter Product"
										 ng-model="product.alertId" typeahead="product.alertId as product.alertId for alert in getProductByAlertId($viewValue)"
										 typeahead-loading="loadingProducts" typeahead-no-results="noResults"/>
								<i ng-show="loadingProducts" class="glyphicon glyphicon-refresh"></i>
								<div ng-show="noResults">
									<i class="glyphicon glyphicon-remove"></i>No Results Found
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="alertPoint" class="col-sm-3 control-label">Alert Level: </label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="alertPoint" name="alertPoint" placeholder="Enter Alert Level" ng-model="alert.alertPoint"/>
							</div>
						</div>
						<div class="form-group">
							<label for="alert operator" class="col-sm-3 control-label">Alert Operator</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="alertOperator" name="alertOperator" placeholder="Enter Alert Operator" ng-model="alert.alertOperator"/>
							</div>
						</div>
						<button type="submit" ng-click="closeEditModal()" class="btn btn-info">Save</button>
						<button class="btn btn-warning" data-dismiss="modal" ng-click="cancelEditing();">Cancel</button>
						<pre>form = {{ alert | json }}</pre>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" ng-click="cancelEditing();">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>