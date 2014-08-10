<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class api extends controller{

    public function render(){

        $this->viewData = new stdClass();

        $panel=$this->initApiContainer();





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

    private function initApiContainer(){
        $get=$this->getRequest('get');
        $panel=(isset($get['load']))?$get['load']:'main';

        $oPanel=$this->getController($panel,false,'api');
        $oPanel->profiler = $this->getModel('profilerModel');
        $render=$oPanel->render();
        $this->viewData->pageContainer = $render;
        $this->viewData->container = $oPanel->viewData;

        return 'container/api/api.tpl';
    }
}