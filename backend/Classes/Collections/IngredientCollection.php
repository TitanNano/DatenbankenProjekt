<?php

namespace DbServer;


class IngredientCollection extends Collection {

    protected $table = 'ingredient';

    protected $entityType = '\DbServer\IngredientEntity';

    public function loadByCocktail($cocktailId)
    {
        $sqlQuery  = new SqlQuery();

        $sql = "SELECT id_ingredient as id FROM has_ingredient WHERE id_cocktail=" . $cocktailId;

        $result = $sqlQuery->execute($sql);

        if ($result['status']) {

            $ingredientList = array_map(function($item){
                return $item['id'];
            }, $result['data']);

            $this->load($ingredientList);
        }
    }

    public function getPrice($multiplier=1)
    {
        $basic_price = array_reduce($this->items, function($prev, $next){
            return $prev + $next->getPrice();
        }, 0);

        return $basic_price * $multiplier;
    }
}
