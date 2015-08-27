<button type="button" class="btn btn-sm loginbtn" data-toggle="modal" data-target="#LoginModal">
	Login
</button>
<div class="modal fade" id="LoginModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Login</h3>
			</div>

			<div class="modal-body" ng-controller="LoginController">
				<form class="form-horizontal" ng-submit="login(user);" novalidate="novalidate">

					<div class="form-group">
						<label for="email" class="col-sm-3 control-label">Email:</label>

						<div class="col-sm-9">
							<input type="email" class="form-control" id="email" name="email"
									 placeholder=" (e.g. john@smith.com)" ng-model="user.email"/>
						</div>
					</div>

					<div class="form-group">
						<label for="password" class="col-sm-3 control-label">Password:</label>

						<div class="col-sm-9">
							<input type="password" class="form-control" id="password" name="password"
									 placeholder=" (e.g. password1234)" ng-model="user.password"/>
						</div>
					</div>

					<pre> form = {{ user | json }} </pre>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Sign-Up</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

