<?php
namespace DbServer {

    class SupplierCollection extends Collection {

        protected $table = 'supplier';

        protected $entityType = '\DbServer\SupplierEntity';
    }
}
