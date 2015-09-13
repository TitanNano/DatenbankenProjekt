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
            $supplier = new SupplierCollection();
            $supplier->addFilter("name = " .  $session['query']);
        }

        public static function displayEntity ($session)
        {
            $class = "DbServer\\" . $session['entityType'];

            $entity = new $class();
            $entity->load($session['entityID']);

            return $entity->export();
        }

        public static function updateEntity ($session)
        {
            $class = "DbServer\\" . $session['entityType'];

            $entity = new $class();
            $entity->assign(json_decode($session['entity']));

            return $entity->save();
        }

        public static function deleteEntity ($session)
        {
            $class = "DbServer\\" . $session['entityType'];

            $entity = new $class();
            $entity->load($session['entityId']);

            return $entity->delete();
        }

        public static function searchIngredient ($session)
        {
            $ingredient = new IngredientCollection();
            $ingredient->addFilte("name = '" .  $session['query'] . "'");
            $ingredient->load();
        }

        public static function getTopTen()
        {
            $cocktails = new CocktailCollection();
            $cocktails->loadTopTen();

            return $cocktails->export();
        }

        public static function getFlopTen()
        {
            $cocktails = new CocktailCollection();

            $cocktails->loadFlopTen();
        }
    }

}
