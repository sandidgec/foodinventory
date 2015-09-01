var ModalInstanceCtrl = function($scope, $modalInstance) {
	$scope.yes = function() {
		$modalInstance.close();
	};

	$scope.no = function() {
		$modalInstance.dismiss('cancel');
	}
};