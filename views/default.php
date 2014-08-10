<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 09.10.12
 * Time: 2:35
 * To change this template use File | Settings | File Templates.
 */
class default_view extends jViews{
    public function render(){
        parent::render();
        $viewData=array();
        $this->setViewData($viewData);
        return 'index.tpl';
    }
}