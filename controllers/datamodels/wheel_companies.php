<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class wheel_companies extends datamodel{

    private $companyId = null;

    public function commit($isRaw=false){
        $this->datamodel=$this->getCompanies($isRaw);
    }

    public function setId($id){
        $this->companyId = $id;
    }

    public function getCompanies($isRaw=false){
        $viewData=array();
        $dbo=App::DBO();
        if($this->companyId!=null){
            $query='SELECT * FROM wheel_companies
                WHERE wheel_companies.id='.$this->companyId.'
                ORDER BY wheel_companies.name ASC';
        }else{
            $query='SELECT wheel_companies.id,
                            wheel_companies.name,
                            wheel_companies.cityId,
                            wheel_companies.active,
                            wheel_companies.iso,
                            wheel_companies.rate,
                    wheel_city.name as city
                    FROM wheel_companies LEFT JOIN wheel_city ON wheel_city.id=wheel_companies.cityId
                ORDER BY wheel_companies.name ASC';
        }
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            if($this->companyId!=null){
                $viewData=$row;
            }else{
                $viewData[]=$row;
            }
        }
        return ($isRaw)?$viewData:json_encode($viewData);
    }
}