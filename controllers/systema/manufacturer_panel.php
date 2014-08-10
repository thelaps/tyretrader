<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class manufacturer_panel extends controller{

    public $sError=null;

    public function render(){
        $get=$this->getRequest('get');
        if(isset($get['fnc'])){
            $isComplete=false;
            switch ($get['fnc']){
                case 'add':
                    $isComplete=$this->addManufacturer();
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
            //return 'price.tpl';
        }
        print $this->sError;
    }

    public function addManufacturer(){
        $post=$this->getRequest('post');
        $field=$post['manufacturer'];
        if($field['name']!=null && $field['type']!=null){
            $dbo=App::DBO();
            $query='INSERT INTO wheel_manufacturers
                    (name)
                    VALUES
                    (\''.$field['name'].'\')';
            $stmt = $dbo->prepare($query);
            $stmt->execute();

            $id=$dbo->lastInsertId();

            $dbo=App::DBO();
            $query='INSERT INTO wheel_manufacturers2type
                    (manufacturer_id,type)
                    VALUES
                    ('.$id.','.$field['type'].')';
            $stmt = $dbo->prepare($query);
            $stmt->execute();
            return true;
        }

        return false;
    }
}