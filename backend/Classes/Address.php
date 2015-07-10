<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 10.07.2015
 * Time: 09:33
 */

class AddressEntity extends Entity {

    private $table = 'cocktails';

    private $index = 'id';

    public function load($id){
        $this->_load($id);
    }

    public function save(){
        $fields = [
            "`city`= " . $this->getCity() . "'",
            "`id` = '" . $this->getId() . "'",
            "`plz`" . $this->getPlz()."'",
            "`house_num` = '" . $this->getHouse_num() . "'",
            "`street` = '" . $this->getStreet() . "'",
            "`address_line` = '" . $this->getAddress_line() . "'",
        ];

        $this->_save($this->fields['id'], $fields);
    }

    public function getCity(){
        return $this->fields['city'];
    }

    public function setCity($value){
        $this->fields['city'] = $value;
    }

    public function getId(){
        return $this->fields['id'];
    }

    public function setId($value){
        $this->fields['id'] = $value;
    }

    public function getPlz(){
        return $this->fields['plz'];
    }

    public function setPlz($value){
        $this->fields['plz'] = $value;
    }

    public function getStreet(){
        return $this->fields['street'];
    }

    public function setStreet($value){
        $this->fields['street'] = $value;
    }

    public function getHouse_num(){
        return $this->fields['house_num'];
    }

    public function setHouse_num($value){
        $this->fields['house_num'] = $value;
    }

    public function getAddress_line(){
        return $this->fields['address_line'];
    }

    public function setAddress_line($value){
        $this->fields['address_line'] = $value;
    }
}