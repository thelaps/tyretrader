<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class admin_panel extends controller{

    public function render(){
        App::setConfig('theme','admin_panel');

        $panel=$this->initStartPanel();

        return $panel;
    }

    private function initStartPanel(){
        $get=$this->getRequest('get');
        $panel=(isset($get['load']))?$get['load']:'main_panel';

        $oPanel=$this->getController($panel,true);
        $render=$oPanel->render();
        $this->viewData=$oPanel->viewData;

        return $render;
    }

    private function getRootNavigation(){

    }
}