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

        $get = $this->getRequest('get');
        if (isset($get['fnc'])) {
            $action = $get['fnc'];
            switch ($get['fnc']) {
                case 'buy':
                    if ( isset($get['sku']) ) {
                        $this->viewData['package'] = $this->getPackage($get['sku']);
                    }
                    break;
            }
        }
        return 'container/paymentCenter.tpl';
    }

    public function getPackage($sku)
    {
        return Package::find_by_sku($sku);
    }
}