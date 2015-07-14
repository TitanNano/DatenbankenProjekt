<?php

require_once('Classes/Address.php');
require_once('Classes/Barkeeper.php');
require_once('Classes/Cocktail.php');
require_once('Classes/Entity.php');
require_once('Classes/Ingredient.php');
require_once('Classes/SqlQuery.php');
require_once('Classes/Supplier.php');

require_once('Classes/Collections/Collection.php');
require_once('Classes/Collections/CocktailCollection.php');

$session = [
    'currentAction' => $_REQUEST['action'],
    'entityID'      => $_REQUEST['entityID'],
    'entity'        => $_REQUEST['entity'],
    'query'         => $_REQUEST['query'],
    'exclusions'    => $_REQUEST['exclude'],
    'filters'       => $_REQUEST['filters'],
    'entityTyp'     => $_REQUEST['entityTyp'],
];




