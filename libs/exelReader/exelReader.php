<?php
class exelReader{

    protected $filename=null;

    public function __construct(){

        date_default_timezone_set('UTC');

    }

    public function setFilename($sName){
        $this->filename=$sName;
    }

    public function process($isRaw=true){
        require('SpreadsheetReader_adapter.php');
        require('SpreadsheetReader.php');
        $spreadsheet = new SpreadsheetReader($this->filename);
        if($isRaw){
            return $spreadsheet;
        }else{
            $collection=array();
            foreach ($spreadsheet as $key => $row){
                if ($row){
                    print_r($row);
                }else{
                    var_dump($row);
                }
            }
        }
    }
}
