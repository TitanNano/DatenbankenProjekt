<?php
namespace DbServer {

    require_once 'Entity.php';
    
    class CocktailEntity extends Entity
    {

        protected $table = 'cocktail';

        protected $index = 'id';

        public function load($index)
        {
            $this->_load($index);
        }

        public function assign($fields)
        {
            $fields['id']      = intval($fields['id']);
            $fields['ranking'] = intval($fields['ranking']);

            parent::assign($fields);

            $this->fields['ingredientList'] = $this->getIngredientList();
            $this->fields['alcohol'] = $this->getAlcohol();
            $this->fields['calories'] = $this->getCalories();
            $this->fields['price'] = $this->getPrice();
        }

        public function save()
        {
            $fields = [
                "`name`= '" . $this->getName() . "'",
                "`id` = " . $this->getId(),
                "`description` = '" . $this->getDescription()."'",
                "`assessmentY` = " . $this->getAssessmentY(),
                "`preparation` = '" . $this->getPreparation() . "'",
                "`ranking` = " . $this->getRanking(),
            ];

            $this->_save($this->fields['id'], $fields);
        }

        public function getId()
        {
            return $this->fields['id'];
        }

        public function setId($value)
        {
            $this->fields['id'] = $value;
        }

        public function getName()
        {
            return $this->fields['name'];
        }

        public function setName($value)
        {
            $this->fields['name'] = $value;
        }

        public function getDescription()
        {
            return $this->fields['description'];
        }

        public function setDescription($value)
        {
            $this->fields['description'] = $value;
        }

        public function getAssessmentY()
        {
            return $this->fields['assessmentY'];
        }

        public function setAssessmentY($value)
        {
            $this->fields['assessmentY'] = $value;
        }

        public function getPreparation()
        {
            return $this->fields['preparation'];
        }

        public function setPreparation($value)
        {
            $this->fields['preparation'] = $value;
        }

        public function getRanking()
        {
            return $this->fields['preparation'];
        }

        public function setRanking($value)
        {
            $this->fields['ranking'] = $value;
        }

        private function getIngredientList()
        {
            $ingredientList = new IngredientCollection();

            $ingredientList->loadByCocktail($this->getId());

            return $ingredientList->getItemsRaw();
        }

        public function getAlcohol()
        {
            $amount = 0;
            $ingredientList = new IngredientCollection();

            $ingredientList->loadByCocktail($this->getId());

            $ingredientList = $ingredientList->getItems();

            foreach ($ingredientList as $item) {
                $amount += intval($item->getAlcohol());
            }

            if (count($ingredientList)) {
                return round($amount / count($ingredientList), 2);
            } else {
                return 0;
            }
        }

        public function getCalories()
        {
            $ingredientList = new IngredientCollection();

            $ingredientList->loadByCocktail($this->getId());

            $ingredientList = $ingredientList->getItems();

            return array_reduce($ingredientList, function($prev, $next){
                return $prev+= intval($next->getCalories());
            }, 0);
        }

        public function getPrice()
        {
            $ingredientList = new IngredientCollection();

            $ingredientList->loadByCocktail($this->getId());

            if ($this->isTopTen()) {
                $multiplier = 5;
            } else if ($this->isFlopTen()) {
                $multiplier = 3;
            } else {
                $multiplier = 1;
            }

            return $ingredientList->getPrice($multiplier);
        }

        public function isTopTen()
        {
            $sqlQuery = new SqlQuery();

            $sql = 'SELECT id FROM (SELECT id, ranking FROM cocktail ORDER BY ranking DESC LIMIT 10) AS j1 WHERE id = ' . $this->getId();

            $result = $sqlQuery->execute($sql);

            return count($result['data']) > 0;
        }

        public function isFlopTen()
        {
            $sqlQuery = new SqlQuery();

            $sql = 'SELECT id FROM (SELECT id, ranking FROM cocktail ORDER BY ranking ASC LIMIT 10) AS j1 WHERE id = ' . $this->getId();

            $result = $sqlQuery->execute($sql);

            return count($result['data']) > 0;
        }
    }
}
