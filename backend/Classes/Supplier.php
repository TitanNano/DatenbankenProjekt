<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 10.07.2015
 * Time: 09:34
 */

namespace DbServer {

    require_once 'Entity.php';

    class SupplierEntity extends Entity
    {

        protected $table = 'supplier';

        protected $index = 'id';

        public function load($index)
        {
            $this->_load($index);
        }

        public function assign($fields)
        {
            parent::assign($fields);

            $this->fields['address'] = $this->getAddress();
        }

        public function save()
        {
            $fields = [
                "`name`= " . $this->getName() . "'",
                "`id` = " . $this->getId(),
                "`url`" . $this->getUrl()."'",
                "`contact` = '" . $this->getContact() . "'",
                "`contact_num` = '" . $this->getContactNum() . "'",
                "`address_id` = " . $this->fields['address_id']
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

        public function getUrl()
        {
            return $this->fields['url'];
        }

        public function setUrl($value)
        {
            $this->fields['url'] = $value;
        }

        public function getContact()
        {
            return $this->fields['contact'];
        }

        public function setContact($value)
        {
            $this->fields['contact'] = $value;
        }

        public function getContactNum()
        {
            return $this->fields['contact_num'];
        }

        public function setContactNum($value)
        {
            $this->fields['contact_num'] = $value;
        }

        public function getAddress()
        {
            $address = new AddressEntity();
            $address->load($this->fields['address_id']);

            return $address->getFields();
        }
    }
}
