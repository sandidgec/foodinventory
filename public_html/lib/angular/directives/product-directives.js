/**
 * creating app directives for products.html and product-edit.html
 * in the food inventory web application
 *
 *
 * file started by Marie on Sunday 8/23/15—
 * may need revisions based on
 * other team members' code
 */


function angularModule() {
// wrapping angular.module within a javaScript function

	var app = angular.module("", []);

	// create app directive with formElement function
	app.directive("formElement", function() {
		return {
			restrict: "E",
			transclude: true,
			scope: {
				label : "@",
				model : "="
			},
			// disabling attrs, requiring attrs, and set attrs pattern
			link: function(scope, element, attrs) {
				scope.disabled = attrs.hasOwnProperty("disabled");
				scope.required = attrs.hasOwnProperty("required");
				scope.pattern = attrs.pattern || ".*";
			},
			// return to template specific to form-group
			//QUESTION: phpStorm does not like the below template and is giving red error???
			template: "<div class="form-group"><label class="col-sm-3 control-label no-padding-right" >  {{label}}</label><div class="col-sm-7"><span class="block input-icon input-icon-right" ng-transclude></span></div></div>"
		};
	});
	// create app directive with onlyNumbers function using keyCode
	app.directive("onlyNumbers", function() {
		return function(scope, element, attrs) {
			//QUESTION: unsure about keyCode number varibles???
			var keyCode = [8,9,13,37,39,46,48,49,50,51,52,53,54,55,56,57,96,97,98,99,100,101,102,103,104,105,110,190];
			element.bind("keydown", function(event) {
				// create keyCode array and prevent default to event
				if($.inArray(event.which,keyCode) == -1) {
					scope.$apply(function(){
						scope.$eval(attrs.onlyNum);
						event.preventDefault();
					});
					event.preventDefault();
				}
			});
		};
	});

	// create app directive focus function with return
		app.directive("focus", function() {
			return function(scope, element) {
				element[0].focus();
			}
		});
	// create app animateOnChange using $animate function
	app.directive("animateOnChange", function($animate) {
		return function(scope, elem, attr) {
			scope.$watch(attr.animateOnChange, function(nv,ov) {
				if (nv!=ov) {
					var c = "change-up";
					$animate.addClass(elem,c, function() {
						$animate.removeClass(elem,c);
					});
				}
			});
		}
	});
}