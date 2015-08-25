<!--  Movements Container  -->
<div class="list-group">
    <!--  Movement Container  -->
    <div class="list-group-item" ng-repeat="movement in movements">
        <h3> Movement <em>Number One</em></h3>

        <!--  Movement Buttons -->
        <div class="movement button row">
            <div class="col-md-4">
                <button class="btn btn-default" ng-click="addMovement(movement)" value="ADD">+</button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-default" ng-click="editMovement(movement)" value="Edit">E
                </button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-default" ng-click="deleteMovement(movement)" value="Delete">-
                </button>
            </div>
        </div>


        <ul>
            <h4>Reports</h4>
            <li ng-repeat="product in movement.products">
                <blockquote>
                    <strong>{{product.title}} </strong>
                    {{product.description}}
                    <cite class="clearfix">-{{product.sku}} on {{product.leadtime}}</cite>
                </blockquote>
            </li>
        </ul>

        <!--  Review Form -->
        <form name="MovementForm" class="container" ng-controller="MovementController as MovementCtrl"
              ng-submit="MovementForm.$valid && MovementCtrl.addMovement(movement)" novalidate>

            <!--  Live Preview -->
            <blockquote ng-show="review">
                <strong>{{reviewCtrl.review.stars}} Stars</strong>
                {{reviewCtrl.review.body}}
                <cite class="clearfix">-{{reviewCtrl.review.author}}</cite>
            </blockquote>

            <!--  Review Form -->
            <h4>Submit a Movement</h4>
            <fieldset class="form-group">
                <input ng-model="MovementCtrl.cost" type="text" class="form-control" placeholder="119.95" title="Cost" required/>
            </fieldset>
            <fieldset class="form-group">
                <input ng-model="MovementCtrl.movementDate" type="date" class="form-control" placeholder="08/24/2015" title="Movement Date" required/>
            </fieldset>
            <fieldset class="form-group">
                <input ng-model="MovementCtrl.movementType" type="text" class="form-control" placeholder="RM" title="Movement Type" required/>
            </fieldset>
            <fieldset class="form-group">
                <input ng-model="MovementCtrl.price" type="text" class="form-control" placeholder="139.95" title="Price" required/>
            </fieldset>
            <fieldset class="form-group">
                <div> MovementForm is {{movementForm.$valid}}</div>
                <input type="submit" class="btn btn-primary pull-right" value="Submit Movement"/>
            </fieldset>
        </form>
    </div>
</div>