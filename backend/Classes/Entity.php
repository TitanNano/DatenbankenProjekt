<?php

namespace DbServer {

    class Entity
    {

        protected $table;

        protected $index;

        protected $fields = [];

        public function constructor()
        {
        }

        protected function save($key, $fields)
        {
         " IF EXISTS (SELECT * FROM". $this->table ."WHERE". $this->index ."` = `" .$key)
            "UPDATE Table1 SET(...)WHERE".$this->§index. "` = `". $key

        ELSE
            "INSERT INTO".$this->table ." VALUES (...)";
        }

        protected function load($key)
        {
            $sql = "SELECT * ". $this->table ." WHERE `". $this->index ."` = ". $key;

        }

        protected function delete($key)
        {
            $sql = "DELETE FROM ". $this->table ." WHERE `". $this->index ."` = ".$key;
        }

        protected function assing($fields)
        {
            $this->fields = $fields;
        }
    }
}
