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
