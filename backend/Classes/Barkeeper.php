<?php
namespace DbServer {

    require_once 'Entity.php';

    class BarkeeperEntity extends Entity
    {

        protected $table = 'barkeeper';

        protected $index = 'id';

        public function load($index)
        {
            $this->_load($index);
        }

        public function assign($fields)
        {
            parent::assign($fields);

            $this->fields['relationList'] = $this->getRelations();
        }

        public function save()
        {
            $fields = [
                "`name`= " . $this->getName() . "'",
                "`id` = " . $this->getId()
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

        public function getRelations()
        {
            $sqlQuery = new SqlQuery();

            $sql = "SELECT id FROM can_do
                        RIGHT JOIN cocktail ON can_do.id_cocktail = cocktail.id
                        WHERE can_do.id_barkeeper = ". $this->getId();

            $result = $sqlQuery->execute($sql);

            $result = array_map(function($item){
                return intval($item['id']);
            }, $result['data']);

            $cocktails = new CocktailCollection();
            $cocktails->load($result);

            return $cocktails->getItemsRaw();
        }
    }

}
