<?php

namespace DbServer {

    class actionsMap {

        public static function searchCocktails($session)
        {
            $cocktails = new CocktailCollection();

            list($alc, $cal) = explode(',', $session['filters']);

            $cocktails->loadByQuery($session['query'], $alc, $cal, $session['exclusions']);

            return $cocktails->export();
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
            $entity = new $session['entityTyp']();
            $entity->assign(json_decode($session['entity']));
            $entity->save();
        }

        public static function deleteEntity ($session)
        {
            $entity = new $session['entityTyp']();
            $entity->load($session['entityId']);
            $entity->delete();
        }

        public static function searchIngredient ($session)
        {
            $ingredient = new IngredientCollection();
            $ingredient->addFilte("name" .  $session['query']);
            $ingredient->load();
        }
    }

}
