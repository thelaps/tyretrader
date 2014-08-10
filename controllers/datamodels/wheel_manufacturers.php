<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class wheel_manufacturers extends datamodel{

    public function commit($isRaw=false){
        $this->datamodel=$this->getManufacturers($isRaw);
    }

    public function getManufacturers($isRaw=false){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT DISTINCT wheel_manufacturers.id,
                wheel_manufacturers.name,
                wheel_manufacturers2type.manufacturer_id,
                wheel_manufacturers2type.type
                FROM wheel_manufacturers
                INNER JOIN wheel_manufacturers2type
                WHERE wheel_manufacturers.id=wheel_manufacturers2type.manufacturer_id';
        if($isRaw){
                $query.=' GROUP BY wheel_manufacturers.id ORDER BY wheel_manufacturers.name';
        }
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            if($isRaw){
                $viewData[]=$row;
            }else{
                $viewData[$row->type][]=$row;
            }
        }
        if(!$isRaw){
            $viewData[0]=$this->getManufacturers(true);
            $viewData[0]=$this->attachSynonyms($viewData[0]);
        }
        return ($isRaw)?$viewData:json_encode($viewData);
    }

    private function attachSynonyms($manufacturers){
        $rebuild=array();
        $total=sizeof($manufacturers);
        $inStatement=array();
        for($i=0; $i<$total; $i++){
            $inStatement[]=$manufacturers[$i]->id;
        }
        $inStr=implode(', ',$inStatement);
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_synonym2manufacturers.manufacturer_id, wheel_synonym2manufacturers.synonym
                FROM wheel_synonym2manufacturers
                WHERE wheel_synonym2manufacturers.manufacturer_id IN ('.$inStr.')';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData[$row->manufacturer_id][]=$row;
        }
        for($i=0; $i<$total; $i++){
            if(isset($viewData[$manufacturers[$i]->id])){
                $manufacturers[$i]->alias=$viewData[$manufacturers[$i]->id];
            }else{
                $manufacturers[$i]->alias=null;
            }
        }
        return $manufacturers;
    }
}