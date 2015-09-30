
angular.module('dbClient')

.controller('client.root', function($scope, $rootScope, $mdUtil, $mdSidenav, Server, $http, $interpolate){
    $scope.view = {
        current : 'guest',
        form : ''
    };

    $scope.pick = {
        c : null
    };

    $scope.isForm = function(form) {
        return $scope.view.form == form;
    };

    $scope.openForm = function(form, loader) {
        if (loader) loader();
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

    $scope.selectCocktail = function(id){
        Server.loadCocktail(id, function(){
            $scope.openForm('cocktail-details');
        });
    };

    $scope.selectIngredient = function(id){
        Server.loadIngredient(id, function(){
            $scope.openForm('ingredient-details');
        });
    };

    $scope.selectBarkeeper = function(id){
        Server.loadBarkeeper(id, function(){
            $scope.openForm('barkeeper-details');
        });
    };

    $scope.selectSupplier =  function(id){
        Server.loadSupplier(id, function(){
            $scope.openForm('supplier-details');
        });
    };

    $scope.setEditMode= function(enabled){
        this.editmode = enabled;
    };
})

.controller('client.toolbar', ['$scope', function($scope){
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
        }]
    },{
        title : '{{strings.views.owner.cards.manage.title}}',
        list : [{
            title : '{{strings.views.owner.cards.manage.list.stock.title}}',
            form : 'stock-list'
        },{
            title : '{{strings.views.owner.cards.manage.list.barkeepers.title}}',
            form : 'barkeeper-list'
        },{
            title : '{{strings.views.owner.cards.manage.list.suppliers.title}}',
            form : 'supplier-list'
        }]
    }];

}])

.controller('client.views.guest', ['$scope', 'Server', function($scope, Server){

    $scope.cards = [{
        title : '{{strings.views.owner.cards.cocktails.title}}',
        list : [{
            title : '{{strings.views.owner.cards.cocktails.list.browse.title}}',
            form : 'browse-cocktails'
        }]
    },{
        title : '{{strings.views.guest.cards.top.title}}',
        list : []
    },{
        title : '{{strings.views.guest.cards.flop.title}}',
        list : []
    }];

    Server.loadTopTen(function(cocktails){
        $scope.cards[1].list = cocktails.map(function(item){
            return {
                title : item.name,
                form : 'cocktail-details',
                loader : function(){
                    Server.loadCocktail(item.id);
                }
            };
        });
    });

    Server.loadFlopTen(function(cocktails){
        $scope.cards[2].list = cocktails.map(function(item){
            return {
                title : item.name,
                form : 'cocktail-details',
                loader : function(){
                    Server.loadCocktail(item.id);
                }
            };
        });
    });

}])

.controller('client.views.forms.cocktails', ['$scope', '$http', 'Server', function($scope, $http, Server){
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
    
    $scope.selectItem = function(id){
        if (!$scope.pick.c) {
            $scope.selectCocktail(id);
        } else {
            $scope.pick.c(id);
        }
    };

}])

.controller('client.views.forms.ingredients', function($scope, Server){

    $scope.search = {
        text : '',
        results : [],
        fetchResults : function(){
            Server.getIngredientList(this.text, function(results){
                this.results = results;
            }.bind(this));
        }
    };

    $scope.search.fetchResults();

    $scope.selectItem = function(id){
        if (!$scope.pick.c) {
            $scope.selectIngredient(id);
        } else {
            $scope.pick.c(id);
        }
    };

})

.controller('client.views.forms.barkeeperList', function($scope, Server){

    $scope.search = {
        text : '',
        results : [],
        fetchResults : function(){
            Server.getBarkeeperList(this.text, function(results){
                this.results = results;
            }.bind(this));
        }
    };

    $scope.search.fetchResults();

    $scope.selectItem = $scope.selectBarkeeper;

})

.controller('client.views.forms.supplierList', function($scope, Server){

    $scope.search = {
        text : '',
        results : [],
        fetchResults : function(){
            Server.getSupplierList(this.text, function(results){
                this.results = results;
            }.bind(this));
        }
    };

    $scope.search.fetchResults();

    $scope.selectItem = $scope.selectSupplier;

})

.controller('client.views.forms.cocktail_details', function($scope, Server, Util){
    $scope.editmode = false;

    Server.onCocktail(function(cocktail){
        $scope.cocktail = cocktail;
    });

    $scope.removeRelation = function(relation){
        relation.removed = true;
    };

    $scope.save = function(){
        Server.saveEntity('Cocktail', $scope.cocktail, function(){
            $scope.selectCocktail($scope.cocktail.id);
        });
    };

    $scope.addRelation = function(){
        $scope.pick.c = function(id){
            Server.loadIngredient(id, function(item){
                $scope.cocktail.ingredientList.push(item);
                $scope.openForm('cocktail-details');
            });
        };

        $scope.openForm('stock-list');
    };
})

.controller('client.views.forms.ingredient_details', function($scope, Server){
    Server.onIngredient(function(ingredient){
        $scope.ingredient = ingredient;
    });
})

.controller('client.views.forms.barkeeper_details', function($scope, Server){
    Server.onBarkeeper(function(barkeeper){
        $scope.barkeeper = barkeeper;
    });

    $scope.addRelation = function(){
        $scope.pick.c = function(id){
            Server.loadCocktail(id, function(item){
                $scope.barkeeper.relationList.push(item);
                $scope.openForm('barkeeper-details');
            });
        };

        $scope.openForm('browse-cocktails');
    };

    $scope.save = function(){
        Server.saveEntity('Barkeeper', $scope.barkeeper, function(){
            $scope.selectBarkeeper($scope.barkeeper.id);
        });
    };
})

.controller('client.views.forms.supplier_details', function($scope, Server){
    Server.onSupplier(function(supplier){
        $scope.supplier = supplier;
    });
});
