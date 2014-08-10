<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class export extends controller{

    public function render(){
        /*$profiler = $this->getModel('profilerModel');
        $profiler->user();*/
        //$this->viewData['sold'] = Price::getSoldItems();
        return 'container/export.tpl';
    }
}