<?php

namespace DbServer {
    
    class BarkeeperCollection {
        
        protected $table = 'barkeeper';
        
        function load($list)
        {
            $this->_load();
        }
    }
}