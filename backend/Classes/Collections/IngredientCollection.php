<?php

namespace DbServer;


class CocktailCollection extends Collection {

    protected $table = 'ingredient';

    protected $entityType = '\DbServer\CocktailEntity';

    public function loadByQuery($query, $alc, $cal, $exclusions)
    {
        $sqlQuery  = new SqlQuery();
        $cocktails = null;

        $sql = "SELECT id, `name` FROM ingredient

                        LEFT JOIN (

                            SELECT has_ingredient.id_cocktail FROM has_ingredient

                                LEFT JOIN (

                                    SELECT has_alternative.id_origin, ingredient.id, ingredient.alcohol, ingredient.calories FROM has_alternative

                                        ON has_alternative.id_target = ingredient.id

                                        WHERE ingredient.id NOT IN (". $exclusions .")

                                ) AS ingredients

                                ON ingredients.id_origin = has_ingredient.id_ingredient OR ingredients.id = has_ingredient.id_ingredient
                                GROUP BY id_cocktail
                                HAVING COUNT(ingredients.id) = COUNT(id_cocktail)

                        ) as cocktails

                    ON cocktail.id = id_cocktail
                    WHERE cocktails.alcohol <= ". $alc ." AND cocktails.calories <= ". $cal ." AND cocktail.name LIKE '". $query ."%'";

        $result = $sqlQuery->execute($sql);

        if ($result['status']) {

            $cocktails = array_map(function($item){
                return $item['id'];
            }, $result['data']);

            $this->load($cocktails);
        }
    }
}
