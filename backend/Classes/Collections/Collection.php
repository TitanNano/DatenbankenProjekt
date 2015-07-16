<?php

class Collection {
    
    protected $table = null;

    protected $index = 'id';

    protected $entityType = 'Entity';

    protected $items = [];

    private   $filters = [];

    public function load($indexList, $column)
    {
        $sqlQuery = new SqlQuery();
        $column   = isset($column) ? $column : $this->index;

        if (isset($indexList)) {
            $indexList = " WHERE " . $column . " IN (" . implode(',', $indexList) . ")" . implode(' AND ', $this->filters);
        } else {
            $indexList = '';
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
    }
    

    public function addFilter($filter)
    {
        $this->filters[] = $filter;
    }
}
