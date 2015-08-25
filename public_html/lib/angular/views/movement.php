<!--  Movements Container  -->
<div class="list-group">
    <!--  Movement Container  -->
    <div class="list-group-item">
        <h3> Your <em>Movements</em></h3>

        <!--  Movement Buttons -->
        <div class="movement button row">
            <div class="col-md-4">
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#MovementModal">
                    Add <br> +
                </button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-default" ng-click="editMovement(movement)" value="Edit"> E </button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-default" ng-click="deleteMovement(movement)" value="Delete"> - </button>
            </div>
        </div>

        <div class="movement reports row">
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

                    <tfoot>
                        <tr>
                            <th>From</th>
                            <th>To</th>
                            <th>Product</th>
                            <th>User</th>
                            <th>Movement Date</th>
                            <th>Movement Type</th>
                        </tr>
                    </tfoot>

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

        <!--  Movement Modal -->
        <div class="modal fade" id="MovementModal">
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
                                <label for="movementType" class="col-sm-3 control-label">Movement Type:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="movementType" name="movementType" placeholder="e.g. RM for (Removed)" ng-model="movement.movementType"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cost" class="col-sm-3 control-label">Cost (Purchase Price):</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="cost" name="cost" placeholder="e.g. $15.00" ng-model="movement.cost"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-sm-3 control-label">Price (Selling Price):</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="price" name="price" placeholder="e.g. $19.99" ng-model="movement.price"/>
                                </div>
                            </div>
                        </form>
                        <pre>form = {{user | json}}</pre>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Sign-Up</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>