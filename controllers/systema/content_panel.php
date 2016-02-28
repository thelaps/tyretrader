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
        $post=$this->getRequest('post');
        $get=$this->getRequest('get');
        if(isset($post['fnc'])){
            $isComplete=false;
            switch ($post['fnc']){
                case 'add':
                    $isComplete=false;
                    if ( isset($post['content']) ) {
                        $this->addRecord($post['content'], ucfirst($post['type']));
                        $isComplete=true;
                    }
                    break;
                case 'update':
                    $isComplete=false;
                    if ( isset($post['content']) ) {
                        $this->updateRecord($post['content'], ucfirst($post['type']));
                        $isComplete=true;
                    }
                    break;
                case 'delete':
                    $isComplete=false;
                    break;
            }
            $this->viewData['content'] = Content::all();
            $this->viewData['packages'] = Package::all();
            return 'content.tpl';
            //App::ajax(json_encode(array('status'=>$isComplete)));
        }elseif(isset($get['fnc'])){
            switch ($get['fnc']) {
                case 'edit':
                    $_class = 'Content';
                    if ( isset($get['id']) && isset($get['type']) ) {
                        $_class = ucfirst($get['type']);
                        $this->viewData['content'] = $_class::find($get['id']);
                    } else {
                        if ( isset($get['type']) ) {
                            $_class = ucfirst($get['type']);
                        }
                        $this->viewData['content'] = new $_class();
                    }
                    $this->viewData['_type'] = strtolower($_class);
                    return 'primitiveForms/content_edit.tpl';
                    break;
            }
        }else{
            $this->viewData['content'] = Content::all();
            $this->viewData['packages'] = Package::all();
            return 'content.tpl';
        }
        App::ajax($this->sError);
    }

    private function addRecord($attributes, $_class){
        $content = new $_class($attributes);
        $content->save();
    }

    private function updateRecord($attributes, $_class){
        $content = $_class::find($attributes['id']);
        return $content->update_attributes($attributes);
    }
}