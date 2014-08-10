<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class wheel_parameters extends datamodel{

    public function commit(){
        $this->datamodel=$this->getParameters();
    }

    public function getParameters($isRaw=false){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT * FROM wheel_parameters
                INNER JOIN wheel_parameters2type
                WHERE wheel_parameters.id=wheel_parameters2type.parameter_id
                AND wheel_parameters.type=1';

        if($isRaw){
            $query.=' GROUP BY wheel_parameters.id';
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
            $viewData[0]=$this->getParameters(true);
        }
        return ($isRaw)?$viewData:json_encode($viewData);
    }
}