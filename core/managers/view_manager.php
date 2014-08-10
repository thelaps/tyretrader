<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 09.03.13
 * Time: 13:32
 * To change this template use File | Settings | File Templates.
 */
class view_manager extends MixinBridge{

    private $cActive=null;
    protected $controllers;
    protected $current_view;

    public function setActiveUI($class,$args=null){
        require CORE_DIR . '../libs/smarty/Smarty.class.php';
        $this->mixin(new $class($args));
        $this->cActive=strtolower($class);
    }

    public function run(){

        $this->setActiveUI(App::getConfig('activeUI'));

        $baseLink=App::getConfig('baseLink');

        $view=$this->controllers->render();

        if(!empty($view)){
            $this->assign('viewData',$this->controllers->viewData);
            $this->assign('view',$this->current_view);

            $themedPath=$this->getThemedPath();

            $this->compile_check = true;
            $this->force_compile = false;
            $this->debugging = false;
            $this->template_dir = $themedPath;
            $this->compile_dir = $themedPath.'/cache';

            $srcUrl=$themedPath.'/src';
            $this->assign('src',$srcUrl);
            $this->assign('baseLink',$baseLink);

            $this->display($view);
        }
    }

    public function getThemedPath(){
        $theme=App::getConfig('theme');
        //print_r($theme);
        $template='themes';
        $path=($theme!='')?$template.'/'.$theme:$template.'/basic';
        return $path;
    }
}