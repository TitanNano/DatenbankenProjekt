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

        }

        protected function load($key)
        {
            $sql = "SELECT * ". $this->table ." WHERE `". $this->index ."` = ". $key;

        }

        protected function delete($key, $fields)
        {

        }

        protected function assing($fields)
        {
            $this->fields = $fields;
        }
    }
}
