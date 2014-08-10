<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class model_panel extends controller{

    public $sError=null;

    public function render(){
        $get=$this->getRequest('get');
        if(isset($get['fnc'])){
            $isComplete=false;
            switch ($get['fnc']){
                case 'add':
                    $isComplete=$this->addModel();
                    break;
                /*case 'prepare':
                    $isComplete=$this->preparePrice();
                    break;
                case 'process':
                    //--
                    break;*/
            }
            App::ajax(json_encode(array('status'=>$isComplete,'post'=>$this->getRequest('post'))));
        }else{
            //$this->viewData['oSearchTemplates']=$this->attachSearchTemplates();;
            //return 'price.tpl';
        }
        App::ajax($this->sError);
    }

    public function addModel(){
        $post=$this->getRequest('post');
        $field=$post['model'];
        if($field['manufacturer_id']!=null && $field['name']!=null){
            $dbo=App::DBO();
            $query='INSERT INTO wheel_models
                    (manufacturer_id,name,description)
                    VALUES
                    ('.$field['manufacturer_id'].',\''.$field['name'].'\',NULL)';
            $stmt = $dbo->prepare($query);
            $stmt->execute();
            return $query;
        }

        return false;
    }
}