<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 09.03.13
 * Time: 13:25
 * To change this template use File | Settings | File Templates.
 */
class MixinBridge{
    private $mixins = array();

    public function mixin($object){
        $this->mixins[] = $object;
    }

    public function doNothing(){
        echo "Zzz\n";
    }

    public function __call($method, $args){
        foreach ($this->mixins as $mixin){
            if (method_exists($mixin, $method)){
                return call_user_func_array(array($mixin, $method), $args);
            }
        }
        throw new Exception(__CLASS__ + " has no method " + $method);
    }

    public function __get($attr){
        foreach ($this->mixins as $mixin){
            if (property_exists($mixin, $attr)){
                return $mixin->$attr;
            }
        }
        throw new Exception(__CLASS__ + " has no property " + $attr);
    }

    public function __set($attr, $value){
        foreach ($this->mixins as $mixin){
            if (property_exists($mixin, $attr)){
                return $mixin->$attr = $value;
            }
        }
        throw new Exception(__CLASS__ + " has no property " + $attr);
    }
}