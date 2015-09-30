angular.module('dbClient')
.factory('Server', function($http, Util){

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
                    callback(currentCocktail);
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
                    callback(currentIngredient);
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
                    callback(currentBarkeeper);
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
                    callback(currentSupplier);
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
            var relationList = Util.extractRelations(object, (type == 'Cocktail' ? 'ingredientList' : null));
            var relationAction = ({
                Cocktail : 'CocktailIngredient',
                Barkeeper : 'BarkeeperCocktail',
                ingredient : 'IngredientSupplier'
            })[type];

            $http({
                method : 'POST',
                url : url,
                data : encodeURI('action=updateEntity&entityType='+ type +'Entity&entity='+ JSON.stringify(object)),
                headers : {
                    'Content-Type' : 'application/x-www-form-urlencoded'
                }
            }).success(function(){
                if (relationAction) {
                    $http({
                        method : 'POST',
                        url : url,
                        data : encodeURI('action=create'+ relationAction +'Relation&entityID='+ relationList.id +'&entity='+ JSON.stringify(relationList.keep)),
                        headers : {
                            'Content-Type' : 'application/x-www-form-urlencoded'
                        }
                    }).success(function(){
                        $http({
                            method : 'POST',
                            url : url,
                            data : encodeURI('action=remove'+ relationAction +'Relation&entityID='+ relationList.id +'&entity='+ JSON.stringify(relationList.remove)),
                            headers : {
                                'Content-Type' : 'application/x-www-form-urlencoded'
                            }
                        }).success(callback);
                    });
                }
            });
        }

    };

    return Server;

})

.factory('Util', function(){
    return {
        extractRelations : function(object, key) {
            var result = { id : object.id, keep : [], remove : [] };

            var list = object[key] || object.relationList;

            list.forEach(function(item){
                if (!item.removed) {
                    result.keep.push(item.id);
                } else {
                    result.remove.push(item.id);
                }
            });

            return result;
        }
    };
});
