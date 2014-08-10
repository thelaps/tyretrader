<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class wheel_extras extends datamodel{

    public function commit(){
        $this->datamodel=$this->getExtras();
    }

    public function getExtras(){
        $viewData=array(
            'color'=>'',
            'technology'=>'',
            'spike'=>'',
            'marking'=>'',
            'currency'=>''
        );
        $ids=array();
        $cleanValues=array();
        $dbo=App::DBO();
        $query='SELECT wheel_dict2parameters.id,
                wheel_dict2parameters.name,
                wheel_dict2parameters.parameter_id
                FROM wheel_dict2parameters
                ORDER BY wheel_dict2parameters.parameter_id ASC,
                wheel_dict2parameters.name DESC';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $ids[$row->id]=$row->parameter_id;
            $cleanValues[$row->parameter_id][]=$row;
        }

        $viewDataTmp=$this->getAliasesFrom($cleanValues);
        $viewData['color']=$viewDataTmp[16];
        $viewData['technology']=$viewDataTmp[32];
        $viewData['spike']=$viewDataTmp[33];
        $viewData['marking']=$viewDataTmp[39];
        $viewData['currency']=$viewDataTmp[40];
        return json_encode($viewData);
    }

    private function getAliasesFrom($cleanValues){
        $aliases=array();
        $dbo=App::DBO();
        $query='SELECT wheel_synonym2dict.id,
                wheel_synonym2dict.dict_id,
                wheel_synonym2dict.synonym
                FROM wheel_synonym2dict
                ORDER BY wheel_synonym2dict.dict_id ASC,
                 wheel_synonym2dict.synonym DESC';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $aliases[$row->dict_id][]=$row;
        }
        foreach($cleanValues as $key=>$value){
            $tmpTotal=sizeof($value);
            for($i=0; $i<$tmpTotal; $i++){
                $newRow=$cleanValues[$key][$i];
                if(isset($aliases[$newRow->id])){
                    $cleanValues[$key][$i]->alias=$aliases[$newRow->id];
                }else{
                    $cleanValues[$key][$i]->alias=null;
                }
            }
        }
        return $cleanValues;
    }
}