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
        $supplier->addFilter("name" .  $session['query']);
    }

    public static function displayEntity ($session)
    {
        $entity = new $session['entityTyp']();
        $entity->load($session['entityID']);
        return $entity->export();
    }

    public static function newEntity ($session)
    {
        $entity = new session['entityTyp']();
        $entity->assign($session['entity']);
        $entity->save();
    }

    public static function deleteEntity ($session)
    {
        $entity = new session['entityTyp']();
        $entity->load($session['entity']);
        $entity->delete();
    }

    public static function searchIngredient ($session)
    {
        $ingredient = new IngredientCollection ();
        $ingredient->addFilte("name" .  $session['query']);
        $ingredient->load();
    }
}