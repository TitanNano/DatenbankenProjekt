<?php
namespace DbServer {

    require_once 'Entity.php';
    
    class CocktailEntity extends Entity
    {

        protected $table = 'cocktails';

        protected $index = 'id';

        public function load($index)
        {
            $this->_load($index);
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

        public function getIngredients()
        {
            $sqlQuery = new SqlQuery();
            $sql = "SELECT ingredient_id FROM has_ingredient WHERE id= ". $this->getId();

            $result = $sqlQuery->execute($sql);

            if ($result['status'] == 'success') {
                $result = $result['result'];
            } else {
                $result = [];
            }


        }
    }
}
