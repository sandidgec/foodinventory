<button type="button" class="btn btn-sm signupbtn" data-toggle="modal" data-target="#SignUpModal">
	Sign-Up
</button>

<div class="modal fade" id="SignUpModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Sign-Up</h3>
			</div>

			<form class="form-horizontal" method="post" ng-submit="addUser(user);">
				<div class="modal-body" ng-controller="SignUpController">
					<div class="form-group">
						<label for="lastName" class="col-sm-3 control-label">Last Name</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="lastName" name="lastName"
									 placeholder=" (e.g. Smith)" ng-model="user.lastName"/>
						</div>
					</div>

					<div class="form-group">
						<label for="firstName" class="col-sm-3 control-label">First Name</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="firstName" name="firstName"
									 placeholder=" (e.g. John)" ng-model="user.firstName"/>
						</div>
					</div>

					<div class="form-group">
						<label for="email" class="col-sm-3 control-label">Email:</label>

						<div class="col-sm-9">
							<input type="email" class="form-control" id="email" name="email"
									 placeholder=" (e.g. john@smith.com)" ng-model="user.email"/>
						</div>
					</div>

					<div class="form-group">
						<label for="phoneNumber" class="col-sm-3 control-label">Phone Number</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="phoneNumber" name="phoneNumber"
									 placeholder=" (e.g. 5055551234)" ng-model="user.phoneNumber"/>
						</div>
					</div>

					<div class="form-group">
						<label for="attention" class="col-sm-3 control-label">Attention</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="attention" name="attention"
									 placeholder=" (e.g. Acme LLC.)" ng-model="user.attention"/>
						</div>
					</div>

					<div class="form-group">
						<label for="addressLineOne" class="col-sm-3 control-label">Address One</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="addressLineOne" name="addressLineOne"
									 placeholder=" (e.g. 1 Main St.)" ng-model="user.addressLineOne"/>
						</div>
					</div>

					<div class="form-group">
						<label for="addressLineTwo" class="col-sm-3 control-label">Address Two</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="addressLineTwo" name="addressLineTwo"
									 placeholder=" (e.g. Suite 200)" ng-model="user.addressLineTwo"/>
						</div>
					</div>

					<div class="form-group">
						<label for="city" class="col-sm-3 control-label">City</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="city" name="city" placeholder=" (e.g. New York)"
									 ng-model="user.city"/>
						</div>
					</div>

					<div class="form-group">
						<label for="state" class="col-sm-3 control-label">State</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="state" name="state" placeholder=" (e.g. NY)"
									 ng-model="user.state"/>
						</div>
					</div>

					<div class="form-group">
						<label for="zipCode" class="col-sm-3 control-label">Zip Code</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="zipCode" name="zipCode"
									 placeholder=" (e.g. 12345-1111)" ng-model="user.zipCode"/>
						</div>
					</div>

					<div class="form-group">
						<label for="password" class="col-sm-3 control-label">Password</label>

						<div class="col-sm-9">
							<input type="password" class="form-control" id="password" name="password"
									 placeholder=" (e.g. password1234)" ng-model="user.password"/>
						</div>
					</div>

					<div class="form-group">
						<label for="passwordConfirm" class="col-sm-3 control-label">Password Confirm</label>

						<div class="col-sm-9">
							<input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm"
									 placeholder=" (e.g. password1234)" ng-model="user.passwordConfirm"/>
						</div>
					</div>
				</div>

				<pre>form = {{ user | json }}</pre>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Sign-Up</button>
				</div>
			</form>
		</div>
	</div>
</div>







