angular.module('dbClient')
.factory('Server', function($http){

    var url = '../backend/index.php?';
    var currentCocktail = null;
    var currentIngredient = null;
    var currentBarkeeper = null;
    var onCocktail = [];
    var onIngredient = [];

    var Server = {

        loadCocktail : function(id, callback){
            $http.get(url + encodeURI("action=displayEntity&entityType=CocktailEntity&entityID="+ id))
                .success(function(result){
                currentCocktail = result;

                onCocktail.forEach(function(f){
                    f(currentCocktail);
                });

                if (typeof callback == 'function') {
                    callback();
                }
            });
        },

        loadIngredient : function(id, callback){
            $http.get(url + encodeURIComponent("action=displayEntity&entityType=IngredientEntity&entityID="+ id))
                .success(function(result){
                currentIngredient = result;

                onIngredient.forEach(function(f){
                    f(currentIngredient);
                });

                if (typeof callback == 'function') {
                    callback();
                }
            });
        },

        onCocktail : function(f){
            onCocktail.push(f);
        },

        onIngredient : function(f){
            onIngredient.push(f);
        },

        loadTopTen : function(f){
            $http.get(url + encodeURIComponent("action=getTopTen")).success(f);
        },

        loadFlopTen : function(f){
            $http.get(url + encodeURIComponent("action=getFlopTen")).success(f);
        },

        getIngredientList : function(name, f){
            $http.get(url + encodeURIComponent("action=getIngredientList&query="+ name)).success(f);
        },

        getBarkeeperList : function(name, f){
            $http.get(url + encodeURIComponent('action=getBarkeeperList&query='+ name)).success(f);
        },

        getSupplierList : function(name, f){
            $http.get(url + encodeURIComponent('acount=getSupplierList&query='+ name)).success(f);
        }

    };

    return Server;

});
