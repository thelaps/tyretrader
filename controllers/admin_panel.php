<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class admin_panel extends controller{

    private $profilerModel;

    public function render(){

        $this->getProfiler();
        $this->viewData->profile = $this->profilerModel;

        App::setConfig('theme','admin_panel');

        $panel=$this->initStartPanel();

        return $panel;
    }

    private function initStartPanel(){
        $get=$this->getRequest('get');
        $panel=(isset($get['load']))?$get['load']:'main_panel';


        $oPanel=$this->getController($panel,true);
        $allowedToLoad = $this->profilerModel->isAllowedToLoad($panel, true);

        if ( $oPanel && $allowedToLoad ) {
            $render=$oPanel->render();
            $this->viewData = $oPanel->viewData;
            return $render;
        } else {
            if ( !$oPanel ) {
                $this->viewData->error->code = 404;
                $this->viewData->error->message = 'Страница не найдена';
            }
            if ( !$allowedToLoad ) {
                $this->viewData->error->code = 302;
                $this->viewData->error->message = 'Авторизуйтесь для доступа в панель управления';
            }
        }
        return 'error.tpl';





        /*$oPanel=$this->getController($panel,true);
        $render=$oPanel->render();
        $this->viewData=$oPanel->viewData;

        return $render;*/
    }

    private function getRootNavigation(){

    }

    private function getProfiler(){
        $this->profilerModel = $this->getModel('profilerModel');
    }
}