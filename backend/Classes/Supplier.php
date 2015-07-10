<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 10.07.2015
 * Time: 09:34
 */

class SupplierEntity extends Entity {

    private $table = 'cocktails';

    private $index = 'id';

    public function load($id){
        $this->_load($id);
    }

    public function save(){
        $fields = [
            "`name`= " . $this->getName() . "'",
            "`id` = '" . $this->getId() . "'",
            "`url`" . $this->getUrl()."'",
            "`contact` = '" . $this->getContact() . "'",
            "`contact_num` = '" . $this->getContact_num() . "'",

        ];

        $this->_save($this->fields['id'], $fields);
    }

    public function getName(){
        return $this->fields['name'];
    }

    public function setName($value){
        $this->fields['name'] = $value;
    }

    public function getId(){
        return $this->fields['id'];
    }

    public function setId($value){
        $this->fields['id'] = $value;
    }

    public function getUrl(){
        return $this->fields['url'];
    }

    public function setUrl($value){
        $this->fields['url'] = $value;
    }

    public function getContact(){
        return $this->fields['contact'];
    }

    public function setContact($value){
        $this->fields['contact'] = $value;
    }

    public function getContact_num(){
        return $this->fields['contact_num'];
    }

    public function setContact_num($value){
        $this->fields['contact_num'] = $value;
    }
}