/**
 * creating app.config $routeProvider angular function
 * this angular.module acts as a Router to other angular modules
 * in the food inventory web application
 *
 * Note that each separate function of web app will need to connect here
 *
 * file started by Marie on Sunday 8/23/15
 */



function angularModule() {
// wrapping angular.module within a javaScript function
//creating var app angular module for FoodInventory with angular.js defined functions used within web app
var app = angular.module("FoodInventory", ["ui.bootstrap", "ngRoute", "ngMessage", "ngMessages", "ngAnimate",
	"ngShow", "ngHide", "ngRepeat", "ngView", "ngModel", "ngForm", "ngInclude", "ngSwitch", "ngClass", ]);
	app.config(["$routeProvider",
	function($routeProvider){
		$routeProvider.
			when("/",{
				//creating $routeProvider definition to match using ng-template reference
				title:"Products",
				templateUrl: "partials/products.php",
				controller:"productsCtrl"
			})
			//set route definition that will be used on route change when no other route definition matches
			.otherwise({
				redirectTo:"/"
			})
	}])
}