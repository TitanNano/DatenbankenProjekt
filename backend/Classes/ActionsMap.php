<?php

class actionsMap {
    
    public static function searchCocktail($session)
    {
        $cocktails = new CocktailCollection();
        
        $cocktails->loadByQuery($session['query'], $session['alc'], $session['cal'], $session['exclusions']);
    }
    
    public static function getSupplier ($session)
    {
        $supplier = new SupplierCollection ();

        $supplier->addFilter ("name=" .  $session['query']);
    }

    public static function displayEntity ($session)
    {
        $entity = new $session['entityTyp']();
        $entity->load($session['entityID']);
    }
}
