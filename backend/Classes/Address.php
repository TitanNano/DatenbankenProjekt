<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 10.07.2015
 * Time: 09:33
 */

namespace DbServer {

    require_once 'Entity.php';

    class AddressEntity extends Entity
    {

        protected $table = 'address';

        protected $index = 'id';

        public function load($index)
        {
            $this->_load($index);
        }

        public function save()
        {
            $fields = [
                "`city`= '" . $this->getCity() . "'",
                "`id` = " . $this->getId(),
                "`plz` = " . $this->getPlz(),
                "`house_num` = " . $this->getHouseNum(),
                "`street` = '" . $this->getStreet() . "'",
                "`address_line` = '" . $this->getAddressLine() . "'",
            ];

            $this->_save($this->fields['id'], $fields);
        }

        public function getCity()
        {
            return $this->fields['city'];
        }

        public function setCity($value)
        {
            $this->fields['city'] = $value;
        }

        public function getId()
        {
            return $this->fields['id'];
        }

        public function setId($value)
        {
            $this->fields['id'] = $value;
        }

        public function getPlz()
        {
            return $this->fields['plz'];
        }

        public function setPlz($value)
        {
            $this->fields['plz'] = $value;
        }

        public function getStreet()
        {
            return $this->fields['street'];
        }

        public function setStreet($value)
        {
            $this->fields['street'] = $value;
        }

        public function getHouseNum()
        {
            return $this->fields['house_num'];
        }

        public function setHouseNum($value)
        {
            $this->fields['house_num'] = $value;
        }

        public function getAddressLine()
        {
            return $this->fields['address_line'];
        }

        public function setAddressLine($value)
        {
            $this->fields['address_line'] = $value;
        }
    }
}
