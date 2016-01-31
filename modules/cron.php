<?php
/**
 * Created by PhpStorm.
 * User: geleverya
 * Date: 26.08.14
 * Time: 22:49
 */
class cron extends connector{

    public function __construct()
    {
        $opts = getopt('f:');
        if ( isset($opts['f']) ) {
            $_action = 'crond'.ucfirst(strtolower($opts['f']));
            if ( method_exists($this, $_action) ) {
                call_user_func(array($this, $_action));
            }
        }
    }

    private function crondMailPrice(){
        Company::sendExpirePriceMail();
    }
}