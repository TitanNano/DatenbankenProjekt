<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 10.07.2015
 * Time: 09:33
 */

namespace DbServer {

    require_once 'Entity.php';

    class IngredientEntity extends Entity
    {

        protected $table = 'ingredient';

        protected $index = 'id';

        public function assign($fields)
        {
            parent::assign($fields);

            $this->fields['price'] = $this->getPrice();
            $this->fields['relationList'] = $this->getRelations();
        }

        public function load($index)
        {
            $this->_load($index);
        }

        public function save()
        {
            $fields = [
                "`name`= " . $this->getName() . "'",
                "`id` = " . $this->getId(),
                "`calories` = " . $this->getCalories(),
                "`alcohol` = " . $this->getAlcohol(),
                "`description` = '" . $this->getDescription() . "'",
                "`stock` = " . $this->getStock(),
            ];

            $this->_save($this->fields['id'], $fields);
        }

        public function getName()
        {
            return $this->fields['name'];
        }

        public function setName($value)
        {
            $this->fields['name'] = $value;
        }

        public function getId()
        {
            return $this->fields['id'];
        }

        public function setId($value)
        {
            $this->fields['id'] = $value;
        }

        public function getCalories()
        {
            return $this->fields['calories'];
        }

        public function setCalories($value)
        {
            $this->fields['calories'] = $value;
        }

        public function getAlcohol()
        {
            return $this->fields['alcohol'];
        }

        public function setAlcohol($value)
        {
            $this->fields['alcohol'] = $value;
        }

        public function getDescription()
        {
            return $this->fields['description'];
        }

        public function setDescription($value)
        {
            $this->fields['description'] = $value;
        }

        public function getStock()
        {
            return $this->fields['stock'];
        }

        public function setStock($value)
        {
            $this->fields['stock'] = $value;
        }

        public function getPrice()
        {
            $sqlQuery = new SqlQuery();

            $sql = "SELECT price FROM cocktailbar.has_supplier WHERE id_ingredient = " . $this->getId() . " ORDER BY price ASC LIMIT 1";

            $result = $sqlQuery->execute($sql);

            return intval($result['data'][0]['price']);
        }

        public function getRelations()
        {
            $sqlQuery = new SqlQuery();

            $sql = "SELECT id, name, price FROM has_supplier
                        RIGHT JOIN supplier ON has_supplier.id_supplier = supplier.id
                        WHERE has_supplier.id_ingredient = ". $this->getId();

            $result = $sqlQuery->execute($sql);

            return $result['data'];
        }
    }
}
