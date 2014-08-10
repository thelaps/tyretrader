<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 31.07.12
 * Time: 22:00
 * To change this template use File | Settings | File Templates.
 */
class controller_manager extends view_manager{

    protected $get;
    protected $post;

    public function __construct($connector){

        $this->get=$connector->getRequest('get');
        $this->post=$connector->getRequest('post');

        require CORE_DIR.'controller.php';

        $this->newController($this->get['view'],'index');

        if($this->controllers!=null){
            $this->run();
        }
    }

    private function newController($getter=null,$default=null){
        $class_name=($getter)?$getter:(($default)?$default:'error');
        $blDie=App::getConfig('dieOnError');
        if(is_string($class_name)){
            try{
                try{
                    if(file_exists(CONTROLLERS.$class_name.'.php')){
                        include_once(CONTROLLERS.$class_name.'.php');
                    }else{
                        if($blDie){
                            throw new Exception;
                        }else{
                            $this->newController();
                            return false;
                        }
                    }
                }catch(Exception $e){
                    echo 'Connection failed [controller|not found]: ' . $e->getMessage();
                    return false;
                }

                $this->controllers=new $class_name();
                $this->current_view=$class_name;
                return true;
            }catch(Exception $e){
                return false;
            }
        }else{
            return false;
        }
    }

    /*public function display($tpl){
        parent::display($tpl);
    }*/
}