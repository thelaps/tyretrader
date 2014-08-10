<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class product extends controller{

    public $errors = array();

    public $profiler = null;

    public function render(){
        $tpl = 'product';
        $get = $this->getRequest('get');

        if (isset($get['model_id']) && isset($get['company_id']) && isset($get['price_id'])) {
            $this->viewData = $this->getModelFromPrice($get['model_id'],$get['company_id'],$get['price_id']);
        }
        if (isset($get['type'])){
            switch ($get['type']){
                case 'raw':
                    $tpl = 'product_raw';
                    break;
                default:
                    $tpl = 'product';
            }
        }
        return 'container/api/'.$tpl.'.tpl';
    }

    private function getModelFromPrice($model,$company,$price)
    {
        return Price::getModelFromPrice($model,$company,$price);
    }
}