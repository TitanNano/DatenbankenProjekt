<?php

namespace DbServer {

    require_once('Classes/ActionsMap.php');

    require_once('Classes/Address.php');
    require_once('Classes/Barkeeper.php');
    require_once('Classes/Cocktail.php');
    require_once('Classes/Entity.php');
    require_once('Classes/Ingredient.php');
    require_once('Classes/SqlQuery.php');
    require_once('Classes/Supplier.php');

    require_once('Classes/Collections/Collection.php');
    require_once('Classes/Collections/CocktailCollection.php');
    require_once('Classes/Collections/IngredientCollection.php');

    $session = array(
        'currentAction' => $_REQUEST['action'],
        'entityID'      => $_REQUEST['entityID'],
        'entity'        => $_REQUEST['entity'],
        'query'         => $_REQUEST['query'],
        'exclusions'    => $_REQUEST['exclude'],
        'filters'       => $_REQUEST['filters'],
        'entityType'     => $_REQUEST['entityType'],
        'entityRank'    => $_REQUEST['ranking']
    );

//    print json_encode($session);

    print ActionsMap::{$session['currentAction']}($session);

}
