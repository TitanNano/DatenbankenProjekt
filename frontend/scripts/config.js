angular.module('dbClient', ['ngMaterial'])

.config(function(){
    window.addEventListener('keydown', function(e){
        if (e.target.localName == 'input' && e.target.value.length === 0 && e.key == 'Backspace') {
            e.preventDefault();
        }
    });
});
