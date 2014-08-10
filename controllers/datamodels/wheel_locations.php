<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class wheel_locations extends datamodel{

    private $locationId=null;

    public function commit(){
        $this->datamodel=$this->getLocations();
    }

    public function setLocationId($locationId){
        $this->locationId=$locationId;
    }

    public function getLocations(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_city.id, wheel_city.region_id, wheel_city.name, wheel_city.phone_code, wheel_region.name as region
                FROM wheel_city LEFT JOIN wheel_region ON wheel_region.id=wheel_city.region_id ORDER BY wheel_region.name, wheel_city.name';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData[$row->region][]=$row;
        }

        return $viewData;
    }

    public function addLocation(){

    }
}