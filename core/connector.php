<?php
require 'db_engine.php';
class connector extends db_engine{

    private $_getData=array();
    private $_postData=array();
    private $_defaults=array(
        'view'=>null
    );
    private $dbo_connection;

    public function __construct(){
        $this->dbo_connection=$this->openConnection();
        $this->dbo_connection->exec("set names utf8");

        $this->initRequestListener();
        require_once 'datamodel.php';
        //$this->cleanupNativeRequest();
    }

    public function getModel($class_name){
        return App::newJump($class_name,'datamodels');
    }

    public function getController($class_name,$isAdmin=false,$superFolder=null){
        $folder=($isAdmin)?'systema':(($superFolder!=null)?$superFolder:'controllers');
        return App::newJump($class_name,$folder);
    }

    public function getDBO(){
        return $this->dbo_connection;
    }

    public function getRequest($type){
        $requestData=array();
        switch($type){
            case 'get':
                $requestData=array_merge($this->addDefaults(),$this->_getData);
                break;
            case 'post':
                $requestData=array_merge($this->addDefaults(),$this->_postData);
                break;
            case 'mixed':
                $tmp=array_merge($this->_getData,$this->_postData);
                $requestData=array_merge($this->addDefaults(),$tmp);
                unset($tmp);
                break;
            case 'file':
                $requestData=$_FILES;
                break;
        }
        return $requestData;
    }

    private function addDefaults(){

        return $this->_defaults;
    }

    private function refactorRequest($type,$data){
        unset($this->_getData);
        $this->_getData=$data;
    }

    private function initRequestListener(){
        $this->_getData=(isset($_GET))?$_GET:array();
        $this->_postData=(isset($_POST))?$_POST:array();
    }

    private function cleanupNativeRequest(){
        unset($_GET);
        unset($_POST);
    }
}