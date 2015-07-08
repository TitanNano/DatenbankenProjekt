<?php

class CocktailEntity extends Entity {

    private $table = 'cocktails';
    
    private $index = 'id';
        
    public function load($id){
        $this->_load($id);
    }
    
    public function save(){
        $fields = [
            "`name`= " . $this->getName() . "'",
            "`id` = '" . $this->getId() . "'"
        ];
        
        $this->_save($this->fields['id'], $fields);
    }
    
    public function getId(){
        return $this->fields['id'];
    }
    
    public function setId($value){
        $this->fields['id'] = $value;
    }
    
    public function getName(){
        return $this->fields['name'];
    }
    
    public function setName($value){
        $this->fields['name'] = $value;
    }
}