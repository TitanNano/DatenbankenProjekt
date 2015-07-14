<?php

namespace DbServer {
    
    class CocktailCollection {
        
        protected $table = 'cocktails';
        
        public function loadByQuery($query, $alc, $cal, $exclusions)
        {
            $sqlQuery = new SqlQuery();

            $sql = "SELECT has_ingredient.cocktail_id FROM has_ingredient

                        LEFT JOIN (

                            SELECT has_alternative.origin, ingredient.id, ingredient.name FROM has_alternative

                                RIGHT JOIN ingredient

                                ON has_alternative.target = ingredient.id

                                WHERE ingredient.id NOT IN (" . $exclusions . ")

                        ) AS ingredients

                        ON ingredients.id = has_ingredient.ingredient_id";
        }
    }
}
