<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 24.07.13
 * Time: 22:25
 * To change this template use File | Settings | File Templates.
 */
//$j='[{"currency":"2","existing":"","R":"13","W":"175","H":"70","I":null,"type":"0","manufacturer":"0","model":null,"Si":{"F":null,"B":"T"},"Sw":{"F":null,"B":"82"},"parameters":[{"parameter_id":8,"value":"175/70R13"},{"parameter_id":null,"value":null},{"parameter_id":16,"value":"54"},{"parameter_id":32,"value":null},{"parameter_id":32,"value":null},{"parameter_id":39,"value":null},{"parameter_id":21,"value":{"price":"310.00","currency":null}},{"parameter_id":25,"value":"8"}],"required":[{"parameter_id":4,"value":"Barum"},{"parameter_id":1,"value":{"id":"2288","model":"Brillantis","manufacturer_id":"12","manufacturer":"Barum","alias":null}}],"raw":"175/70R13 | Barum | | 175/70R13 Barum Brillantis 2 82T Bleck | 310 | 8"},{"currency":"2","existing":"","R":"13","W":"175","H":"70","I":null,"type":"0","manufacturer":"0","model":null,"Si":{"F":null,"B":"T"},"Sw":{"F":null,"B":"82"},"parameters":[{"parameter_id":8,"value":"175/70R13"},{"parameter_id":null,"value":null},{"parameter_id":16,"value":null},{"parameter_id":32,"value":null},{"parameter_id":32,"value":null},{"parameter_id":39,"value":null},{"parameter_id":21,"value":{"price":"390.00","currency":null}},{"parameter_id":25,"value":"25"}],"required":[{"parameter_id":4,"value":"BF Goodrich"},{"parameter_id":1,"value":{"id":"2233","model":"Touring","manufacturer_id":"13","manufacturer":"BF Goodrich","alias":[{"model_id":"2233","synonym":"Toureing","manufacturer_id":"13"}]}}],"raw":"175/70R13 | BFGoodrich | | 175/70R13 BFGoodrich Touring 82T | 390 | 25"},{"currency":"2","existing":"","R":"13","W":"175","H":"70","I":null,"type":"0","manufacturer":"0","model":null,"Si":{"F":null,"B":"T"},"Sw":{"F":null,"B":"82"},"parameters":[{"parameter_id":8,"value":"175/70R13"},{"parameter_id":null,"value":null},{"parameter_id":16,"value":null},{"parameter_id":32,"value":null},{"parameter_id":32,"value":null},{"parameter_id":39,"value":null},{"parameter_id":21,"value":{"price":"390.00","currency":null}},{"parameter_id":25,"value":"25"}],"required":[{"parameter_id":4,"value":"BF Goodrich"},{"parameter_id":1,"value":"Touring"}],"raw":"175/70R13 | BF Gudrich | | 175/70R13 BF Gudrich Toureing 82T | 390 | 25"},{"currency":"2","existing":"","R":"13","W":"175","H":"70","I":null,"type":"0","manufacturer":"0","model":null,"Si":{"F":null,"B":"S"},"Sw":{"F":null,"B":"82"},"parameters":[{"parameter_id":8,"value":"175/70R13"},{"parameter_id":null,"value":null},{"parameter_id":16,"value":null},{"parameter_id":32,"value":null},{"parameter_id":32,"value":null},{"parameter_id":39,"value":null},{"parameter_id":21,"value":{"price":"620.00","currency":null}},{"parameter_id":25,"value":"4"}],"required":[{"parameter_id":4,"value":"Bridgestone"},{"parameter_id":1,"value":{"id":"4198","model":"Blizzak Revo-GZ","manufacturer_id":"15","manufacturer":"Bridgestone","alias":null}}],"raw":"175/70R13 | Bridgestone | | 175/70R13 Bridgestone Blizzak Revo-GZ 82S | 620 | 4"},{"currency":"2","existing":"","R":"13","W":"175","H":"70","I":null,"type":"0","manufacturer":"0","model":null,"Si":{"F":null,"B":"T"},"Sw":{"F":null,"B":"82"},"parameters":[{"parameter_id":8,"value":"175/70R13"},{"parameter_id":null,"value":null},{"parameter_id":16,"value":null},{"parameter_id":32,"value":null},{"parameter_id":32,"value":null},{"parameter_id":39,"value":null},{"parameter_id":21,"value":{"price":"329.00","currency":null}},{"parameter_id":25,"value":"16"}],"required":[{"parameter_id":4,"value":"Debica"},{"parameter_id":1,"value":"Navigator"}],"raw":"175/70R13 | Debica | | 175/70R13 Debica Navigatar 2 82T | 329 | 16"},null]';
//print_r(json_decode($j,true));

/*
            'select'=>null, //0-9=>field
            'from'=>null, //:a-z=>table || L: I: R: O:a-z=>table
            'where'=>null, //:field=>value
*/

/*$items=array('0','1',':table','I:table','field');

$pattern='((\d)|(\:[a-zA-Z_]+)|([L|I|R|O]\:[a-zA-Z_]+))';
foreach($items as $value){
preg_match_all($pattern,$value,$out, PREG_SET_ORDER);

print_r($out);
    print "<br>";
}*/
$rawYear = '14од';
$intYear = filter_var($rawYear, FILTER_SANITIZE_NUMBER_INT);
print_r(array(strlen((string)$intYear), date('d-m-'.$intYear), strtotime(date($intYear.'-m-d'))));
if ( strlen((string)$intYear) == 2 ) {
    print_r(array('20'.$intYear, date('d-m-Y', strtotime(date($intYear.'-m-d')))));
} else {

}