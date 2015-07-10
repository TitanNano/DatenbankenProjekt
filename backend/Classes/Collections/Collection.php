<?php

class Collection {
    
    function load()
    {
        $sql = "SELECT * FROM ". $this->table;
    }
    
}