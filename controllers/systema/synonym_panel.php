<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class synonym_panel extends controller{

    public $sError=null;

    public function render(){
        $get=$this->getRequest('get');
        if(isset($get['fnc'])){
            $isComplete=false;
            switch ($get['fnc']){
                case 'add':
                    $isComplete=$this->addSynonym();
                    break;
                /*case 'prepare':
                    $isComplete=$this->preparePrice();
                    break;
                case 'process':
                    //--
                    break;*/
            }
            print json_encode(array('status'=>$isComplete));
        }else{
            //$this->viewData['oSearchTemplates']=$this->attachSearchTemplates();;
            //return 'price.tpl';
        }
        print $this->sError;
    }

    public function addSynonym(){
        $post=$this->getRequest('post');
        $field=$post['synonym'];
        if($field['manufacturer_id']!=null && $field['synonym']!=null){
            $dbo=App::DBO();
            $query='INSERT INTO wheel_synonym2manufacturers
                    (manufacturer_id,synonym)
                    VALUES
                    ('.$field['manufacturer_id'].',\''.$field['synonym'].'\')';
            $stmt = $dbo->prepare($query);
            $stmt->execute();
            return true;
        }

        return false;
    }
}