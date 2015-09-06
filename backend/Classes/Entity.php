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

            $sql = "IF EXISTS (SELECT * FROM ". $this->table ." WHERE `". $this->index ."` = ". $key ." )
                        UPDATE Table1 SET (". join(',', $fields) .") WHERE `" .$this->§index. "` = ". $key ."
                    ELSE
                        INSERT INTO ".$this->table ." (". implode(',', $FieldNames) .") VALUES (". implode(',', $fieldValues) .")";

            $result = $sqlQuery->execute($sql);

            return $result['status'];
        }

        protected function _load($key)
        {
            $sqlQuery = new SqlQuery();

            $sql = "SELECT * ". $this->table ." WHERE `". $this->index ."` = ". $key;

            $result = $sqlQuery->execute($sql);

            if ($result['status'] === 1) {
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

        protected function _increase ($key)
        {
            $sqlQuery = new SqlQuery();

            $sql = "SELECT ranking *".$this->table."WHERE`". $this->index."`=".$key;

            $result = $sqlQuery->execute($sql);

            if ($result['ranking']++)
                $this->assign($result['ranking'][0]);
        }

        protected function _flopTen ($key)
        {
            $sqlQuery = new SqlQuery();

            $sql =  "SELECT MIN(ranking)". $this->table. "FROM cocktail`".$this->index."`WHERE ORDER BY desc 10".$key."

                        LEFT JOIN  (Select id_ingredient, price FROM has_supplier

                            LEFT JOIN (SELECT id_cocktail FROM has_ingredient WHERE id_ingredient=id_cocktail

                                IF (id_ingredient = id_cocktail){SUM (price*3)}";

            $result = $sqlQuery->execute($sql);

            return $result['price'];
        }


        protected function _topTen ($key)
        {
            $sqlQuery = new SqlQuery();

            $sql = "SELECT ranking". $this->table. "FROM cocktail`".$this->index."`WHERE ORDER BY desc 10".$key."

                        LEFT JOIN  (Select id_ingredient, price FROM has_supplier

                            LEFT JOIN (SELECT id_cocktail FROM has_ingredient WHERE id_ingredient=id_cocktail

                                IF (id_ingredient = id_cocktail){SUM (price*5)}";


            $result = $sqlQuery->execute($sql);

            return $result['price'];
        }

        protected function _price ($key)
        {
            $sqlQuery = new SqlQuery();

            $sql = "SELECT id_ingredient, price". $this->table. "FROM has_supplier`".$this->index."`WHERE ORDER BY desc 10".$key."

                            LEFT JOIN (SELECT id_cocktail FROM has_ingredient WHERE id_ingredient=id_cocktail

                                IF (id_ingredient = id_cocktail){SUM (price)}";


            $result = $sqlQuery->execute($sql);

            return $result['price'];
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
