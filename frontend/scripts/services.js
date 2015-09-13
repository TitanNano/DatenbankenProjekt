angular.module('dbClient')
.factory('Server', function($http){

    var url = '../backend/index.php?';
    var currentCocktail = null;
    var onCocktail = [];


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

        onCocktail : function(f){
            onCocktail.push(f);
        }

    };

    return Server;

});
