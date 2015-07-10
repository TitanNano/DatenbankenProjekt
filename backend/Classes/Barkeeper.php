<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 10.07.2015
 * Time: 09:30
 */

namespace DbServer {

    require_once 'Entity.php';

    class BarkeeperEntity extends Entity
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
    }

}
