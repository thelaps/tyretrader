<?php
class test extends connector{

    public function getModel($class_name){

        //$this->setInstance('connector');
        //$this->getInstance();
        print_r(get_class_methods($this));
        return App::newJump('user','controllers');
    }
}