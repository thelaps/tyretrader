<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 0:11
 * To change this template use File | Settings | File Templates.
 */
class request_validator{

    protected $getReq;

    public function __construct($get_req){
        $this->getReq=$this->_validate($get_req);
    }

    private function _validate($get_req){
        $valid=array();
        if($get_req!=null){
            $valid=$this->_checkAndClearR($get_req);
        }
        return $valid;
    }

    private function _checkAndClearR($array){
        $checked=array();
        foreach($array as $key=>$value){
            if(is_array($value)){
                $checked[$key]=$this->_checkAndClearR($value);
            }else{
                $checked[$key]=$this->_pasteIsAlloved($value);
            }
        }
        return $checked;
    }

    private function _pasteIsAlloved($str){
        if(preg_match("/^[A-Za-z0-9 \%\+]+$/i", $str)){
            return $str;
        }
        return null;
    }

    public function __destruct(){
        print_r('CU is off');
    }
}