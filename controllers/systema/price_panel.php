<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class price_panel extends controller{

    public $sError=null;
    private $_data=null;

    public function render(){
        $get=$this->getRequest('get');
        if(isset($get['fnc'])){
            $isComplete=false;
            switch ($get['fnc']){
                case 'upload':
                    $isComplete=$this->uploadPrice();
                    break;
                case 'prepare':
                    $isComplete=$this->preparePrice();
                    break;
                case 'process':
                    //--
                    break;
                case 'updates';
                    $this->viewData['oSearchTemplates']=$this->attachSearchTemplates();
                    $this->viewData['parameters']=$this->attachParameters();
                    $this->viewData['manufacturers']=$this->attachManufacturers();
                    $this->viewData['raw_manufacturers']=$this->attachRawManufacturers();
                    $this->viewData['raw_companies']=$this->attachRawCompanies();
                    $this->viewData['semantic']=$this->attachSemanticData();
                    $this->viewData['extras']=$this->attachExtrasData();
                    $this->viewData['city']=$this->attachLocations();
                    $this->viewData['currencyRate']=$this->attachCurrencyRate();
                    App::ajax(json_encode($this->viewData));
                    return false;
                    break;
            }
            App::ajax(json_encode(array('status'=>$isComplete, 'data' => $this->_data)));
        }else{
            $this->viewData['oSearchTemplates']=$this->attachSearchTemplates();
            $this->viewData['parameters']=$this->attachParameters();
            $this->viewData['manufacturers']=$this->attachManufacturers();
            $this->viewData['raw_manufacturers']=$this->attachRawManufacturers();
            $this->viewData['raw_companies']=$this->attachRawCompanies();
            $this->viewData['semantic']=$this->attachSemanticData();
            $this->viewData['extras']=$this->attachExtrasData();
            $this->viewData['city']=$this->attachLocations();
            $this->viewData['currencyRate']=$this->attachCurrencyRate();
            $this->viewData['exelData']='exel_1.json';//$aContent->sheets;
            return 'price.tpl';
        }
        App::ajax($this->sError);
    }

    private function preparePrice(){
        $oExelProcessor=$this->openPrice();

        //$sheet = $oExelProcessor->Handle->getContents();
        //print_r($sheet);

        $oFileWriter=App::newJump('fileWriter','libs');
        try{
            $oFileWriter->write('exel_1.json',ROOT_DIR.'tmp',$oExelProcessor);
            return 'exel_1.json?version='.rand(0,999);
        }catch (Exception $e){
            $this->sError=$e->getMessage();
        }
    }

    private function openPrice(){
        $get=$this->getRequest('get');
        if(isset($get['xls'])){
            $oExelReader=App::newJump('phpexel','libs');

            $oExelReader->setFilename(ROOT_DIR.'/files/'.$get['xls']);

            try{
                return $oExelReader->process();
            }catch(Exception $e){
                $this->sError='Connection failed: ' . $e->getMessage();
                return null;
            }
        }
    }

    /*private function preparePrice(){
        $oExelProcessor=$this->openPrice();
        $aContent=$oExelProcessor->Handle->getContents();

        //$sheet = $oExelProcessor->Handle->getContents();
        //print_r($sheet);

        $oFileWriter=App::newJump('fileWriter','libs');
        try{
            $oFileWriter->write('exel_1.json',ROOT_DIR.'tmp',json_encode($aContent->sheets));
            return 'exel_1.json';
        }catch (Exception $e){
            $this->sError=$e->getMessage();
        }
    }

    private function openPrice(){
        $get=$this->getRequest('get');
        if(isset($get['xls'])){
            $oExelReader=App::newJump('exelReader','libs');

            $oExelReader->setFilename(ROOT_DIR.'/files/'.$get['xls']);

            try{
                return $oExelReader->process();
            }catch(Exception $e){
                $this->sError='Connection failed: ' . $e->getMessage();
                return null;
            }
        }
    }*/

    private function uploadPrice(){
        $demo_mode = false;
        $upload_dir = 'files/';
        $allowed_ext = array('xlsx','xls');

        if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
            $this->sError='Error! Wrong HTTP method!';
            return false;
        }

        if(array_key_exists('source',$_FILES) && $_FILES['source']['error'] == 0 ){
            $source = $_FILES['source'];
            if(!in_array($this->get_extension($source['name']),$allowed_ext)){
                $this->sError='Only '.implode(',',$allowed_ext).' files are allowed!';
            }
            if($demo_mode){
                $line = implode('		', array( date('r'), $_SERVER['REMOTE_ADDR'], $source['size'], $source['name']));
                file_put_contents('log.txt', $line.PHP_EOL, FILE_APPEND);
                $this->sError='Uploads are ignored in demo mode.';
            }
            $_newName = md5($source['name']) . '.' . $this->get_extension($source['name']);
            $this->_data = $_newName;
            if(move_uploaded_file($source['tmp_name'], $upload_dir.$_newName)){
                return true;
            }

        }else{
            $this->sError='Some error';
            return false;
        }
    }

    private function get_extension($file_name){
        $ext = explode('.', $file_name);
        $ext = array_pop($ext);
        return strtolower($ext);
    }

    private function processPrice(){

    }

    public function attachLocations(){
        $params=$this->getModel('wheel_locations'); //Getter for datamodel classes -> we have an object of class
        $params->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    public function attachCurrencyRate(){
        $params=$this->getModel('wheel_currencyRate'); //Getter for datamodel classes -> we have an object of class
        $params->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    public function attachParameters(){
        $params=$this->getModel('wheel_parameters'); //Getter for datamodel classes -> we have an object of class
        $params->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    public function attachManufacturers(){
        $params=$this->getModel('wheel_manufacturers'); //Getter for datamodel classes -> we have an object of class
        $params->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    public function attachRawManufacturers(){
        $params=$this->getModel('wheel_manufacturers'); //Getter for datamodel classes -> we have an object of class
        $params->commit(true); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    public function attachRawCompanies(){
        $params=$this->getModel('wheel_companies'); //Getter for datamodel classes -> we have an object of class
        $params->commit(true); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    public function attachSemanticData(){
        $params=$this->getModel('wheel_semantic'); //Getter for datamodel classes -> we have an object of class
        $params->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    public function attachSearchTemplates(){
        $params=$this->getModel('wheel_templates'); //Getter for datamodel classes -> we have an object of class
        $params->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    public function attachExtrasData(){
        $params=$this->getModel('wheel_extras'); //Getter for datamodel classes -> we have an object of class
        $params->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $params->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }
}