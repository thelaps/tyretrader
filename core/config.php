<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 13.02.13
 * Time: 20:18
 * To change this template use File | Settings | File Templates.
 */
class jConfig{
    protected $_config;

    public function __construct(){
        $this->_config['PDO']=null;
        $this->_config['dieOnError']=false;
        $this->_config['baseLink']=(!App::isCLI()) ? 'http://'.$_SERVER['HTTP_HOST'] : null;
        $this->_config['updateExpire']=8;
        $this->_config['project']='wheels';
        $this->_config['theme']='wheels';
        $this->_config['activeUI']='Smarty';
        $this->_config['system']=array(
            'datamodels'=>array('controllers','datamodels'),
            'controllers'=>array('controllers'),
            'systema'=>array('controllers','systema'),
            'container'=>array('controllers','container'),
            'api'=>array('controllers','container','api'),
            'modules'=>array('modules'),
            'libs'=>array('libs'),
            'managers'=>array('core','managers'),
        );
        $this->_config['dba']=array(
            'host'=>'127.0.0.1',
            'user'=>'wheels_system',
            'pass'=>'nash_noya',
            'base'=>'wheels'
        );
    }

    public function getConfig($key){
        if(array_key_exists($key,$this->_config)){
            return $this->_config[$key];
        }
        return null;
    }

    public function setConfig($key,$val=null){
        $this->_config[$key]=$val;
    }
}