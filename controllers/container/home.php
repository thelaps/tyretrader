<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class home extends controller{

    public function render(){
        $PayOnline=App::newJump('PayOnline','libs');

        //$this->viewData['paymentData'] = $PayOnline->

        $this->viewData['city'] = City::getWithRegions();
        $this->viewData['packages'] = Package::all();
        $this->viewData['expiration'] = Invoice::getExpirationIntervals();
        return 'container/home.tpl';
    }
}