angular.module('UmfragetoolLive')

    .controller("PieCtrl", function($scope, $interval, ResourceService) {

        $scope.dataSet = [];

        $scope.chart = {
	        color: '#FF8800'
        };

        $scope.update = function() {
            ResourceService
                .get()
                .then(function(dataSet) {
                    $scope.dataSet = dataSet;
                });
        };

        $scope.updateOnce = function() {
            ResourceService
                .getResult()
                .then(function(dataSet) {
                    $scope.dataSet = dataSet;
                });
        };

        if(doNotUpdate) {
            $scope.updateOnce();
        } else {
            $scope.update();

            $interval(function() {
                $scope.update();
            }, 5000);
        }
    });