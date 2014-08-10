<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 09.03.13
 * Time: 13:32
 * To change this template use File | Settings | File Templates.
 */
class module_manager extends MixinBridge{

    private $instance_class=null;

    public function getInstance(){
        $this->mixin(new $this->instance_class());
    }

    public function setInstance($instance_class){
        $this->instance_class=$instance_class;
    }
}