<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class index extends controller{

    private $profilerModel;

    public function render(){

        $this->getProfiler();

        $this->viewData = new stdClass();

        $this->viewData->profile = $this->profilerModel;

        $this->viewData->x_entry = (isset($_COOKIE['x-entry']));

        $panel=$this->initStartContainer();

        $this->viewData->_content = Content::pageContent();
        $this->viewData->_banner = Content::pageBanner();
        $this->viewData->_contentmodel = new Content();



        /*-------method for calling classes that can help for solution-----
        $jump=App::newJump('class_name','namespace');
        ---------END-----------------------------------------------------*/

        //$this->viewData['profile']=$this->getModel('profilerModel');

        /*-------EXAMPLE OF CAALLING OTHER CONTROLLER--------
        $posts=$this->getController('posts');
        $posts->render();

        $this->viewData['checkWork']=$posts->viewData['posts'];
        ---------END----------------------------------------*/

        //Here we make a ~ amount of request to database with randomization, so we have a small test=)
        /*$dbo=$this->getDBO(); // getDBO() - getter for database object
        for($i=0; $i<1000; $i++){
            $query='SELECT oxid, oxtitle, oxprice FROM oxarticles WHERE oxactive=\'1\' ORDER BY rand() LIMIT 6';
            $stmt = $dbo->prepare($query);

            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $this->viewData['articles'.$i][]=$row;
            }
        }*/

        return $panel;
    }

    private function initStartContainer(){
        $get=$this->getRequest('get');
        $panel=(isset($get['load']))?$get['load']:'main';
        App::setSysArguments(null, $panel);

        $oPanel=$this->getController($panel,false,'container');
        $allowedToLoad = $this->profilerModel->isAllowedToLoad($panel);

        if ( $oPanel && $allowedToLoad ) {
            $render=$oPanel->render();
            $this->viewData->pageContainer = $render;
            $this->viewData->container = $oPanel->viewData;
            $this->viewData->resetHandler = User::NORESET;

            if ( isset($get['reset']) ) {
                if ( User::resetPassByKey($get['reset']) ) {
                    $this->viewData->resetHandler = User::RESETTED;
                } else {
                    $this->viewData->resetHandler = User::RESETFAIL;
                }
            }

            return 'index.tpl';
        } else {
            if ( !$oPanel ) {
                $this->viewData->error->code = 404;
                $this->viewData->error->message = 'Страница не найдена';
            }
            if ( !$allowedToLoad ) {
                $this->viewData->error->code = 302;
                $this->viewData->error->message = 'Доступно только зарегистрированным пользователям';
            }
        }
        return 'error.tpl';
    }

    private function getProfiler(){
        $this->profilerModel = $this->getModel('profilerModel');
    }

    private function getPosts(){
        $posts=$this->getModel('posts_widget'); //Getter for datamodel classes -> we have an object of class
        $posts->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $posts->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }
}