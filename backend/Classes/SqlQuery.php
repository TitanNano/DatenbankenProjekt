<?php

namespace DbServer {
    
    class SqlQery {
    
        private $connection;
    
        function construct()
        {
            $this->connection = new mysqli("localhost", "httpuser", "http22", "cocktailbar");
        }

        function execute($query)
        {
            $record = array();

            $result = $this->connection->query($query);

            if (property_exists($res, 'num_rows')) {
                for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {

                    $res->data_seek($row_no);
                    $row = $result->fetch_assoc();

                    $record[] = $row;

                }
            }

            return isset($result) ? array('status' => true, 'data' => (count($record) > 0 ? $record : $result)) :
                                    array('status' => false,   'data' => false);
        }

    }

}
