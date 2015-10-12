<?php
class App{
    private static $_oConfig=null;

    public $error=null;

    private static $_sys_controller;
    private static $_sys_loader;

    public static function setSysArguments($_controller = null, $_loader = null){
        if ( !empty($_controller) ) {
            self::$_sys_controller = $_controller;
        }
        if ( !empty($_loader) ) {
            self::$_sys_loader = $_loader;
        }
    }

    public static function _sys(){
        $_sys = new stdClass();
        $_sys->controller = self::$_sys_controller;
        $_sys->loader = self::$_sys_loader;
        return $_sys;
    }

    public static function start(){
        define('CORE_DIR',dirname(__FILE__).DIRECTORY_SEPARATOR);
        define('ROOT_DIR',CORE_DIR.'../');
        define('CONTROLLERS',CORE_DIR.'../controllers/');
        define('UTILS',CORE_DIR.'utils/');

        require_once UTILS.'MixinBridge.php';
        require_once CORE_DIR.'config.php';
        require_once CORE_DIR.'managers/db_manager.php';
        require_once CORE_DIR.'managers/view_manager.php';
        require_once CORE_DIR.'connector.php';

        App::$_oConfig=new jConfig();
        $connector=new connector(); //Has PDO object of DB and request Procesor
        App::setConfig('PDO',$connector->getDBO());
        App::newJump('controller_manager','managers',$connector);
    }

    public static function DBO(){
        return App::getConfig('PDO');
    }

    public static function getConfig($key){
        $oConfig=App::$_oConfig;
        return  $oConfig->getConfig($key);
    }

    public static function setConfig($key,$val=null){
        $oConfig=App::$_oConfig;
        return  $oConfig->setConfig($key,$val);
    }

    public static function newJump($class_name,$systemKey=null,$arguments=null){

        $blDie=App::getConfig('dieOnError');
        $system=App::getConfig('system');

        $isLibs=($systemKey=='libs')?true:false;

        if(is_string($class_name) && array_key_exists($systemKey,$system)){
            try{
                try{
                    $systemPath=implode('/',$system[$systemKey]);
                    $sPath=ROOT_DIR.$systemPath.'/';
                    if($isLibs){
                        $sPath=$sPath.$class_name.'/';
                    }
                    if(file_exists($sPath.$class_name.'.php')){
                        include_once($sPath.$class_name.'.php');
                    }else{
                        if($blDie){
                            throw new Exception;
                        }else{
                            return false;
                        }
                    }
                }catch(Exception $e){
                    echo 'Connection failed [controller|not found]: ' . $e->getMessage();
                    return false;
                }
                return ($arguments!=null)?new $class_name($arguments):new $class_name;
            }catch(Exception $e){
                return false;
            }
        }else{
            return false;
        }
        //return new $class_name;
    }

    public static function ajax($string){
        if(!empty($string)){
            $template = '<ajax>'.$string.'</ajax>';
            print $template;
        }
    }

    public static function setVal(&$taker = null, $giver = null){
        if ( App::isActive($giver) ) {
            $taker = $giver;
            return true;
        }
        return false;
    }

    public static function isActive($value, $allowNull = false){
        $value = (is_string($value)) ? trim($value) : $value;
        if ( ($value != false && $value != null && !empty($value)) || ($allowNull == true && $value != 0) ) {
            return true;
        }
        return false;
    }

    public static function getField($from, $needle){
        return (isset($from[$needle])) ? $from[$needle] : null;
    }

    public static function helper(){
        return self::newJump('helper', 'modules');
    }
}
/*define('CORE_DIR',dirname(__FILE__).DIRECTORY_SEPARATOR);
require CORE_DIR.'config.php';
require CORE_DIR.'../libs/Smarty.class.php';
require CORE_DIR.'connector.php';
//require CORE_DIR.'connector_utils.php';
require CORE_DIR.'mixin.php';
require CORE_DIR.'lView.php';
require CORE_DIR.'controller_mgr.php';

$connector=new connector(); //Has PDO object of DB and request Procesor

$controller=new controller_mgr($connector);*/