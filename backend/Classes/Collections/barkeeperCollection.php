<?php
namespace DbServer {

    class barkeeperCollection extends Collection {

        protected $table = 'barkeeper';

        protected $entityType = '\DbServer\BarkeeperEntity';

        public function loadByQuery($id,$name)
        {
            $sqlQuery  = new SqlQuery();
            $barkeeper = null;

            $sql = "INSERT INTO barkebeer (id, name )

              LEFT JOIN ( INSERT INTO (id_barkeeper, id_cocktail) SELECT * FROM can_do

                LEFT JOIN ( SELECT `name`,`ìd` FROM cocktail WHERE id_cocktail = id";

            $result = $sqlQuery->execute($sql);

            if ($result['status']) {

                $barkeeper = array_map(function($item){
                    return $item['name'].['id'];
                }, $result['data']);

                $this->load($barkeeper);
            }
        }
    }
}

?>