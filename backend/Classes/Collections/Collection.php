<?php

namespace DbServer {
    
    require_once('Classes/Cocktail.php');


    class Collection {

        protected $table = null;

        protected $index = 'id';

        protected $entityType = '\DbServer\Entity';

        protected $items = [];

        private   $filters = [];

        public function load($indexList, $column = false)
        {
            $sqlQuery = new SqlQuery();
            $column   = $column ? $column : $this->index;

            if (isset($indexList)) {
                $indexList = " WHERE " . $column . " IN (" . implode(',', $indexList) . ")" . implode(' AND ', $this->filters);
            } else {
                $indexList = array_reduce($this->filters, function($prev, $next){
                    return ($prev == "") ? ("WHERE ". $next) : ($prev . " AND " . $next);
                }, "");
            }

            $sql = "SELECT * FROM ". $this->table . $indexList;

            $result = $sqlQuery->execute($sql);

            if ($result['status']) {
                foreach ($result['data'] as $item) {
                    $this->processItem($item);
                }
            }
        }

        protected function processItem($item)
        {
            $entity = new $this->entityType();

            $entity->assign($item);

            $this->items[] = $entity;
        }


        public function addFilter($filter)
        {
            $this->filters[] = $filter;
        }

        public function getItems()
        {
            return $this->items;
        }

        public function export()
        {
            return json_encode(array_map(function($item){
                return $item->getFields();
            }, $this->items));
        }
    }

}
