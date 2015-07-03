
angular.module('dbClient')

.controller('client.root', ['$scope', '$mdUtil', '$mdSidenav', '$log', '$http', function($scope, $mdUtil, $mdSidenav, $log, $http){
    $scope.openNav = $mdUtil.debounce(function(){
        $mdSidenav('nav').toggle();
    }, 300);
     
    $http.get('./lang/en.json').success(function(data){
        $scope.strings = angular.fromJson(data);
    });
}])

.controller('client.toolbar', ['$scope', function($scope){
    console.log($scope);
}])

.controller('client.nav', ['$scope', '$http', function($scope){
    
    $scope.items = [{
        title : '{{strings.nav.owner}}',
        id : 'owner'
    }];
    
    $scope.navigate = function(id) {
        
    };
    
}]);