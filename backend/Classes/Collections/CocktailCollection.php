<?php

namespace DbServer {
    
    class CocktailCollection extends Collection{
        
        protected $table = 'cocktails';
        
        public function loadByQuery($query, $alc, $cal, $exclusions)
        {
            $sqlQuery  = new SqlQuery();
            $cocktails = null;

            $sql = "SELECT has_ingredient.cocktail_id, ingredients.id as ingredient_id, ingredients.alc, ingredients.cal FROM has_ingredient

                        LEFT JOIN (

                            SELECT has_alternative.origin_id, ingredient.id, ingredient.alc, ingredient.cal FROM has_alternative

                                RIGHT JOIN ingredient

                                ON has_alternative.target = ingredient.id

                                WHERE ingredient.id NOT IN (" . $exclusions . ")

                        ) AS ingredients

                        ON ingredients.origin_id = has_ingredient.ingredient_id OR ingredients.id = has_ingredient.ingredient_id";

            $result = $sqlQuery->execute($sql);

            if ($result['success']) {

                $cocktails = $this->filterIncomplete($result['data']);

                $cocktails = $this->filterByAlcCal($cocktails, $alc, $cal);


                $sql = "SELECT id, name FROM cocktails WHERE id IN (". implode(',', array_keys($cocktails)) .")";

                $result = $sqlQuery->execute($sql);

                if ($result['success']) {
                    foreach ($result['data'] as $item) {
                        if (strpos($item['name'], $query) !== false) {

                        }
                    }
                }
            }
        }

        private function filterIncomplete($list)
        {
            $newList = [];

            foreach ($list as $item) {
                if (!isset($newList[$item['cocktail_id']])) {
                    $newList[$item['cocktail_id']] = [];
                }

                $newList[$item['cocktail_id']][] = isset($item['ingredient_id']) ? [
                    'id'  => $item['ingredient_id'],
                    'alc' => $item['alc'],
                    'cal' => $item['cal']
                ] : false;
            }

            return $newList;
        }

        private function filterByAlcCal($list, $alc, $cal)
        {
            $newList = [];

            foreach ($list as $key => $list) {
                if (!in_array(false, $list)) {
                    $list = array_reduce($list, function($last, $next){

                        $last['alc'] += $next['alc'];
                        $last['cal'] += $next['cal'];

                        return $last;

                    }, ['name' => '', 'alc' => 0, 'cal' => 0]);

                    if ($list['alc'] <= $alc && $list['cal'] <= $cal) {
                        $newList[$key] = $list;
                    }
                }
            }
        }
    }
}
