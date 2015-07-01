<?php

class Entity {

    private $table = null;

    private $index = null;

    private $fields = [];

    public function constructor(){
    }

    private function _save($key, $fields){

    }

    private function _load($key){

    }

    private function _delete($key, $fields){

    }

    public function assing($fields){
        $this->fields = $fields;
    }

}
