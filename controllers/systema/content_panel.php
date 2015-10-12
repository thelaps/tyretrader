<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class content_panel extends controller{

    public $sError=null;

    public function render(){
        $get=$this->getRequest('post');
        if(isset($get['fnc'])){
            $isComplete=false;
            switch ($get['fnc']){
                case 'add':
                    $isComplete=false;
                    break;
                case 'update':
                    $isComplete=false;
                    break;
                case 'delete':
                    $isComplete=false;
                    break;
            }
            App::ajax(json_encode(array('status'=>$isComplete)));
        }else{
            $this->viewData['content'] = Content::all();
            return 'content.tpl';
        }
        App::ajax($this->sError);
    }
}