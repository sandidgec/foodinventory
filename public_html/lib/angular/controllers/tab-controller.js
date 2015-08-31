app.controller("TabController", function($scope) {
	this.tab = 1;

	$scope.tabs = {
		singleSelect: null,
		availableOptions: [
			{id: '1', name: 'Product'},
			{id: '2', name: 'Movement'},
			{id: '3', name: 'Vendor'},
			{id: '4', name: 'Location'},
			{id: '4', name: 'Notification'}
		]
	};

	this.setTab = function(tab){
		this.tab = tab;
	};

	this.isSet = function(tab){
		return (this.tab === tab);
	};
});