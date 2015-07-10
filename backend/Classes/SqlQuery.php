<?php

namespace DbServer {
    
    private $db;
    
    function construct()
    {
        $db = new mysqli("localhost", "httpuser", "http22", "cocktailbar");
    }
    
    function execute($query)
    {
        $request = $db->query($query);   
        
        return ($request) ? array('status' => 'success', 'result' => $request) : 
                            array('status' => 'error', 'result' => $request);    
    }
}
