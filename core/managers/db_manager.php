<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 09.03.13
 * Time: 13:32
 * To change this template use File | Settings | File Templates.
 */
class db_manager extends MixinBridge{

    //private $cActive=null;
    //protected $controllers;
    //protected $current_view;

    public $config_db;

    public function setActiveUI($class,$args=null){
        //require CORE_DIR . '../libs/Smarty.class.php';
        //$this->mixin(new $class($args));
        //$this->cActive=strtolower($class);
    }

    public function openConnection(){
        $aConfig=App::getConfig('dba');
        $pdo=App::getConfig('PDO');
        $host=$aConfig['host'];
        $user=$aConfig['user'];
        $pass=$aConfig['pass'];
        $base=$aConfig['base'];
        try {
            if($pdo!=null){
                $this->config_db=$pdo;
            }else{
                $this->config_db = new PDO(
                    'mysql:dbname='.$base.';host='.$host,
                    $user,
                    $pass
                );
                App::setConfig('PDO',$this->config_db);
                $this->useAr();
            }
            //print_r('is ok');
        } catch (PDOException $ex) {
            echo 'Connection failed: ' . $ex->getMessage();
            return;
        }

        return $this->config_db;
    }

    private function useAr(){
        $aConfig=App::getConfig('dba');
        $host=$aConfig['host'];
        $user=$aConfig['user'];
        $pass=$aConfig['pass'];
        $base=$aConfig['base'];
        $arModelPath = CONTROLLERS . 'datamodels' . DIRECTORY_SEPARATOR . 'activerecord';
        $ar = App::newJump('ActiveRecord','libs');
        $this->mixin($ar->init($host, $user, $pass, $base, $arModelPath));
    }
}