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
            $entity->assign((array) json_decode($session['entity']));

            return $entity->save();
        }

        public static function deleteEntity ($session)
        {
            $class = "DbServer\\" . $session['entityType'];

            $entity = new $class();
            $entity->load($session['entityId']);

            return $entity->delete();
        }

        public static function getIngredientList ($session)
        {
            $ingredient = new IngredientCollection();
            $ingredient->addFilter("name LIKE '%" .  $session['query'] . "%'");
            $ingredient->load();

            return $ingredient->export();
        }

        public static function getBarkeeperList ($session)
        {
            $barkeeperList = new BarkeeperCollection();
            $barkeeperList->addFilter("name LIKE '%" .  $session['query'] . "%'");
            $barkeeperList->load();

            return $barkeeperList->export();
        }

        public static function getSupplierList ($session)
        {
            $supplierList = new SupplierCollection();
            $supplierList->addFilter("name LIKE '%". $session['query'] . "%'");
            $supplierList->load();

            return $supplierList->export();
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

            return $cocktails->export();
        }

        public static function createBarkeeperCocktailRelation()
        {

        }

        public static function removeBarkeeperCocktailRelation()
        {

        }

        public static function createCocktailIngredientRelation()
        {

        }

        public static function createIngredientSupplierRelation()
        {

        }

        public static function removeIngredientSupplierRelation()
        {

        }
    }

}
