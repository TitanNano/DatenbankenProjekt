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

        protected function _save($key, $fields)
        {
            $sqlQuery     = new SqlQuery();
            $FieldNames   = [];
            $fieldValues  = [];

            foreach ($fields as $field) {
                $field = explode('=', $field);

                $FieldNames[]  = trim($field[0]);
                $fieldValues[] = trim($field[1]);
            }

            $sql = "SELECT id FROM ". $this->table ." WHERE `". $this->index ."` = ". $key;

            $result = $sqlQuery->execute($sql);

            if(count($result['data']) > 0) {
                $sql = "UPDATE ". $this->table ." SET ". join(',', $fields) ." WHERE `" .$this->index. "` = ". $key;
            } else {
                $sql = "INSERT INTO ".$this->table ." (". implode(',', $FieldNames) .") VALUES (". implode(',', $fieldValues) .")";
            }

            print $sql;

            $result = $sqlQuery->execute($sql);

            return $result['status'];
        }

        protected function _load($key)
        {
            $sqlQuery = new SqlQuery();

            $sql = "SELECT * FROM ". $this->table ." WHERE `". $this->index ."` = ". $key;

            $result = $sqlQuery->execute($sql);

            if ($result['status']) {
                $this->assign($result['data'][0]);
            }
        }

        protected function _delete($key)
        {
            $sqlQuery = new SqlQuery();

            $sql = "DELETE FROM ". $this->table ." WHERE `". $this->index ."` = ".$key;

            $result = $sqlQuery->execute($sql);

            return $result['status'];
        }

        protected function _supplierCollection($key)
        {
            $sqlQuery = new SqlQuery();

            $sql = "SELECT id, name". $this->table. "FROM supplier`".$this->index."`WHERE".$key."

                        LEFT JOIN ( SELECT id_ingredient, id_supplier, MIN(price) FROM has_supplier

                            IF (id=id_supplier){min(price)}";


            $result = $sqlQuery->execute($sql);

            return $result['supplier'];

        }

        public function assign($fields)
        {
            $this->fields = $fields;
        }

        public function export()
        {
            return json_encode($this->fields);
        }

        public function getFields()
        {
            return $this->fields;
        }
    }
}
