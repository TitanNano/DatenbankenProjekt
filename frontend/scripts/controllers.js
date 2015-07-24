
angular.module('dbClient')

.controller('client.root', ['$scope', '$rootScope', '$mdUtil', '$mdSidenav', '$log', '$http', '$interpolate',
                            function($scope, $rootScope, $mdUtil, $mdSidenav, $log, $http, $interpolate){
    $scope.view = {
        current : 'guest',
        form : 'browse-cocktails'
    };

    $scope.isForm = function(form) {
        return $scope.view.form == form;
    };

    $scope.openForm = function(form) {
        $scope.view.form = form;
    };

    $scope.openNav = $mdUtil.debounce(function(){
        $mdSidenav('nav').toggle();
    }, 300);

    $scope.isView = function(view) {
        return $scope.view.current == view;
    };
     
    $http.get('./lang/en.json').success(function(data){
        $rootScope.strings = angular.fromJson(data);
    });

    $scope.parse = function(expression) {
        return $interpolate(expression)($scope);
    };
}])

.controller('client.toolbar', ['$scope', function($scope){
    console.log($scope);
}])

.controller('client.nav', ['$scope', '$compile', function($scope, $compile){
    
    $scope.items = [{
        title : '{{strings.nav.owner}}',
        view : 'owner',
    },{
        title : '{{strings.nav.barkeeper}}',
        view : 'barkeeper'
    },{
        title : '{{strings.nav.guest}}',
        view : 'guest'
    }];

    $scope.setView = function(view) {
        if($scope.view.current != view) $scope.view.current = view;
    };

}])

.controller('client.views', ['$scope', function($scope){
}])

.controller('client.views.owner', ['$scope', function($scope){

    $scope.cards = [{
        title : '{{strings.views.owner.cards.cocktails.title}}',
        list : [{
            title : '{{strings.views.owner.cards.cocktails.list.browse.title}}',
            form : 'browse-cocktails'
        },{
            title : '{{strings.views.owner.cards.cocktails.list.ranking.title}}',
            from : 'ranking'
        }]
    },{
        title : '{{strings.views.owner.cards.manage.title}}',
        list : [{
            title : '{{strings.views.owner.cards.manage.list.stock.title}}',
            from : 'stock-list'
        },{
            title : '{{strings.views.owner.cards.manage.list.barkeepers.title}}',
            from : 'barkeeper-list'
        },{
            title : '{{strings.views.owner.cards.manage.list.suppliers.title}}',
            from : 'supplier-list'
        }]
    }];

}])

.controller('client.views.guest', ['$scope', function($scope){

    $scope.cards = [{
        title : '{{strings.views.owner.cards.cocktails.title}}',
        list : [{
            title : '{{strings.views.owner.cards.cocktails.list.browse.title}}',
            form : 'browse-cocktails'
        },{
            title : '{{strings.views.owner.cards.cocktails.list.ranking.title}}',
            from : 'ranking'
        }]
    },{
        title : '{{strings.views.guest.cards.flop.title}}'
    },{
        title : '{{strings.views.guest.cards.top.title}}'
    }];

}])

.controller('client.views.forms.cocktails', ['$scope', '$http', function($scope, $http){
    var ingrediences = [{name : 'coca cola'}, {name : 'sprite'}, {name : 'wodka' }, {name : 'gin'}, {name : 'wine'}];
    var filteredIngrediences = null;
    
    $scope.search = {
        exclude : [],
        text : '',
        results : [],
        alc : 100,
        cal : 100,
        fetchResults : function(){
            var exclude = this.exclude.map(function(item){ return item.id; }).join(',');

            exclude = exclude.length > 0 ? exclude : "''";

            $http.get("../backend/index.php?" + encodeURI("action=searchCocktails&query="+ this.text +"&filters="+ this.alc +","+ this.cal +"&exclude=" + exclude))
                .success(function(results){
                    if(results.toString() != $scope.search.results.toString()){
                        $scope.search.results = results;
                    }
                });
        }
    };

    $scope.ingrediences = {
        searchText : '',
        selectedItem : null,
        getItems : function(searchText){
            var newFiltered = ingrediences.filter(function(item){
                return item.name.indexOf(searchText) > -1;
            });

            if (newFiltered != filteredIngrediences) {
                filteredIngrediences = newFiltered;
            }

            return filteredIngrediences;
        }
    };
    
}])
.controller('client.views.forms.cocktail_details', ['$scope', function($scope){

}]);
