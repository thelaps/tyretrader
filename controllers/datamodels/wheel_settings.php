<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class wheel_settings extends datamodel{

    private $priceName=null;
    private $companyId=null;

    public function commit(){
        $this->datamodel=$this->getSettings();
    }

    public function setCompanyId($companyId){
        $this->companyId=$companyId;
    }

    public function setPriceName($priceName){
        $this->priceName=$priceName;
    }

    public function getSettings(){
        $viewData=null;
        if($this->priceName!=null && $this->companyId!=null){
            $dbo=App::DBO();
            $query='SELECT
                    wheel_settings2company.company_id,
                    wheel_settings2company.price_name,
                    wheel_settings2company.settings
                    FROM wheel_settings2company
                    WHERE wheel_settings2company.company_id='.$this->companyId.'';
                    //AND wheel_settings2company.price_name=\''.$this->priceName.'\'';
            $stmt = $dbo->prepare($query);
            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_OBJ)){
                $viewData=$row->settings;
            }
        }

        return $viewData;
    }
}