<?php

namespace DbServer;

use Mysqli;
    
class SqlQuery {

    private $connection;

    function __construct()
    {
        $this->connection = new Mysqli("localhost", "httpuser", "http22", "cocktailbar");

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
    }

    function execute($query)
    {
        $record = array();

//        print $query;

        $result = $this->connection->query($query);

        if ($result && property_exists($result, 'num_rows')) {
            for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {

                $result->data_seek($row_no);
                $row = $result->fetch_assoc();

                $record[] = $row;

            }
        }

        return isset($result) ? array('status' => true, 'data' => $record) :
                                array('status' => false, 'error' => $this->connection->error, 'data' => false);
    }

}
