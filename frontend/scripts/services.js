angular.module('dbClient')
.factory('Server', function($http){

    var url = '../backend/index.php?';
    var currentCocktail = null;
    var currentIngredient = null;
    var currentBarkeeper = null;
    var currentSupplier = null;
    var onCocktail = [];
    var onIngredient = [];
    var onBarkeeper = [];
    var onSupplier = [];

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
            $http.get(url + encodeURI("action=displayEntity&entityType=IngredientEntity&entityID="+ id))
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

        loadBarkeeper : function(id, callback){
            $http.get(url + encodeURI("action=displayEntity&entityType=BarkeeperEntity&entityID="+ id))
                .success(function(result){
                currentBarkeeper = result;

                onBarkeeper.forEach(function(f){
                    f(currentBarkeeper);
                });

                if (typeof callback == 'function') {
                    callback();
                }
            });
        },

        loadSupplier : function(id, callback){
            $http.get(url + encodeURI("action=displayEntity&entityType=SupplierEntity&entityID="+ id))
                .success(function(result){
                currentSupplier = result;

                onSupplier.forEach(function(f){
                    f(currentSupplier);
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

        onBarkeeper : function(f){
            onBarkeeper.push(f);
        },

        onSupplier : function(f){
            onSupplier.push(f);
        },

        loadTopTen : function(f){
            $http.get(url + encodeURI("action=getTopTen")).success(f);
        },

        loadFlopTen : function(f){
            $http.get(url + encodeURI("action=getFlopTen")).success(f);
        },

        getIngredientList : function(name, f){
            $http.get(url + encodeURI("action=getIngredientList&query="+ name)).success(f);
        },

        getBarkeeperList : function(name, f){
            $http.get(url + encodeURI('action=getBarkeeperList&query='+ name)).success(f);
        },

        getSupplierList : function(name, f){
            $http.get(url + encodeURI('action=getSupplierList&query='+ name)).success(f);
        },

        saveEntity : function(type, object, callback){
            $http.get(url + encodeURI('action=updateEntity&entityType='+ type +'Entity&entity='+ JSON.stringify(object)))
                .success(callback);
        }

    };

    return Server;

});
