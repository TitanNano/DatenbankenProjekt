<?php

class actionsMap {
    
    public static function searchCocktail($session)
    {
        $cocktails = new CocktailCollection();
        $filters   = explode(',', $session['filters']);
        
        $cocktails->addFilter("acl=" . $filters[0]);
        $cocktails->addFilter("cal=" . $filters[1]);
        
    }
    
}