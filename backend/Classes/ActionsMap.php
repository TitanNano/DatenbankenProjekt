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

        public static function createBarkeeperCocktailRelation($session)
        {
            $sqlQuery = new SqlQuery();
            $list = json_decode($session['entity']);
            $positive = 0;

            foreach ($list as $item) {
                $sql = "SELECT id_cocktail FROM can_do WHERE id_cocktail = ". $item ." AND id_barkeeper = ". $session['entityID'] ." LIMIT 1";

                $doesExist = $sqlQuery->execute($sql);

                $doesExist = count($doesExist['data']);

                if (!$doesExist) {
                    $sql = "INSERT INTO can_do (id_barkeeper, id_cocktail) VALUES (". $session['entityID'] .", ". $item .")";

                    $result = $sqlQuery->execute($sql);

                    $positive += $result['status'];
                }
            }

            return $positive == count($list);
        }

        public static function removeBarkeeperCocktailRelation($session)
        {
            $sqlQuery = new SqlQuery();
            $list = json_decode($session['entity']);
            $positive = 0;

            foreach ($list as $item) {
                $sql = "SELECT id_cocktail FROM can_do WHERE id_cocktail = ". $item ." AND id_barkeeper = ". $session['entityID'] ." LIMIT 1";

                $doesExist = $sqlQuery->execute($sql);

                $doesExist = count($doesExist['data']);

                if ($doesExist) {
                    $sql = "DELETE FROM can_do WHERE id_barkeeper = ". $session['entityID'] ." AND id_cocktail = ". $item;

                    $result = $sqlQuery->execute($sql);

                    $positive += $result['status'];
                }
            }

            return $positive == count($list);
        }

        public static function createCocktailIngredientRelation($session)
        {
            $sqlQuery = new SqlQuery();
            $list = json_decode($session['entity']);
            $positive = 0;

            foreach ($list as $item) {
                $sql = "SELECT id_ingredient FROM has_ingredient WHERE id_ingredient = ". $item ." AND id_cocktail = ". $session['entityID'] ." LIMIT 1";

                $doesExist = $sqlQuery->execute($sql);

                $doesExist = count($doesExist['data']);

                if (!$doesExist) {
                    $sql = "INSERT INTO has_ingredient (id_cocktail, id_ingredient) VALUES (". $session['entityID'] .", ". $item .")";

                    $result = $sqlQuery->execute($sql);

                    $positive += $result['status'];
                }
            }

            return $positive == count($list);
        }

        public static function removeCocktailIngredientRelation($session)
        {
            $sqlQuery = new SqlQuery();
            $list = json_decode($session['entity']);
            $positive = 0;

            foreach ($list as $item) {
                $sql = "SELECT id_ingredient FROM has_ingredient WHERE id_ingredient = ". $item ." AND id_cocktail = ". $session['entityID'] ." LIMIT 1";

                $doesExist = $sqlQuery->execute($sql);

                $doesExist = count($doesExist['data']);

                if ($doesExist) {
                    $sql = "DELETE FROM has_ingredient WHERE id_cocktail = ". $session['entityID'] ." AND id_ingredient = ". $item;

                    $result = $sqlQuery->execute($sql);

                    $positive += $result['status'];
                }
            }

            return $positive == count($list);
        }

        public static function createIngredientSupplierRelation($session)
        {
            $sqlQuery = new SqlQuery();
            $list = json_decode($session['entity']);
            $positive = 0;

            foreach ($list as $item) {
                $sql = "SELECT id_supplier FROM has_supplier WHERE id_supplier = ". $item ." AND id_ingredient = ". $session['entityID'] ." LIMIT 1";

                $doesExist = $sqlQuery->execute($sql);

                $doesExist = count($doesExist['data']);

                if (!$doesExist) {
                    $sql = "INSERT INTO has_supplier (id_ingredient, id_supplier) VALUES (". $session['entityID'] .", ". $item .")";

                    $result = $sqlQuery->execute($sql);

                    $positive += $result['status'];
                } else {
                    $sql = "UPDATE has_supplier SET price = ". $item->price ." WHERE id_supplier = ". $item->id ." AND id_ingredient = ". $session['entityID'];
                }
            }

            return $positive == count($list);
        }

        public static function removeIngredientSupplierRelation($session)
        {
            $sqlQuery = new SqlQuery();
            $list = json_decode($session['entity']);
            $positive = 0;

            foreach ($list as $item) {
                $sql = "SELECT id_supplier FROM has_supplier WHERE id_supplier = ". $item ." AND id_ingredient = ". $session['entityID'] ." LIMIT 1";

                $doesExist = $sqlQuery->execute($sql);

                $doesExist = count($doesExist['data']);

                if ($doesExist) {
                    $sql = "DELETE FROM has_supplier WHERE id_ingredient = ". $session['entityID'] ." AND id_supplier = ". $item;

                    $result = $sqlQuery->execute($sql);

                    $positive += $result['status'];
                }
            }

            return $positive == count($list);
        }
    }

}
