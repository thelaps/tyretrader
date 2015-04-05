<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class paymentcenter extends controller{

    public $errors = array();

    public $profiler = null;
    public function render(){
        $this->viewData = '';
        return 'container/paymentCenter.tpl';
    }
}