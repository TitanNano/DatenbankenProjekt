<?php

class actionsMap {
    
    public static function searchCocktail($session)
    {
        $cocktails = new CocktailCollection();
        $filters   = explode(',', $session['filters']);
        
        $cocktails->addFilter("acl=" . $filters[0]);
        $cocktails->addFilter("cal=" . $filters[1]);

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