<?php

class Entity {

    protected $table = null;

    protected $index = null;

    protected $fields = [];

    public function constructor(){
    }

    protected function _save($key, $fields){

    }

    protected function _load($key){

    }

    protected function _delete($key, $fields){

    }

    protected function assing($fields){
        $this->fields = $fields;
    }

}
