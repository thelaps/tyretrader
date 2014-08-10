<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class wheel_semantic extends datamodel{

    private $modelId = null;

    public function commit(){
        if($this->modelId!=null){
            $this->datamodel=$this->getModelInfoById();
        }else{
            $this->datamodel=$this->getSemanticData();
        }
    }

    public function setModelId($id){
        $this->modelId = $id;
    }

    public function getSemanticData(){
        $viewData=array(
            'manufacturers'=>$this->getManufacturers(),
            'models'=>$this->getModels()
        );

        return $viewData;
    }

    public function getManufacturers(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT DISTINCT wheel_manufacturers.name FROM wheel_manufacturers
                INNER JOIN wheel_manufacturers2type
                WHERE wheel_manufacturers.id=wheel_manufacturers2type.manufacturer_id
                ORDER BY wheel_manufacturers.name';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $aTmp=array_merge_recursive($viewData,$this->letterizeToAssoc($row->name));
            $viewData=$aTmp;
        };
        return json_encode($viewData);
    }

    private function letterizeToAssoc($str){
        $lvl=3;
        $astr=str_split(substr(strtolower($str),0,$lvl),1);
        $out=array();
        $out[$astr[0]]=$this->pushRecursive($astr,1,2,$str);

        return $out;
    }

    private function pushRecursive($astr,$need,$total,$str){
        $next=($need+1);

        $pushed=array();

        if(isset($astr[$need])){
            $pushed[$astr[$need]]=($need<$total)?$this->pushRecursive($astr,$next,$total,$str):$str;
        }

        return $pushed;
    }

    public function getModelInfoById(){
        $viewSynonyms=$this->attachSynonymsInfoById();
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_models.id,
                        wheel_models.name as model,
                        wheel_models.manufacturer_id,
                        wheel_manufacturers.name as manufacturer,
                        LOWER(wheel_manufacturers.name) as manufacturerLower
                FROM wheel_models
                LEFT JOIN wheel_manufacturers
                ON wheel_manufacturers.id=wheel_models.manufacturer_id
                WHERE wheel_models.id='.$this->modelId.'
                ORDER BY wheel_manufacturers.name, wheel_models.name';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            if(isset($viewSynonyms[$row->id])){
                $row->alias=$viewSynonyms[$row->id];
            }else{
                $row->alias=null;
            }
            $viewData=$row;
        };
        return $viewData;
    }

    private function attachSynonymsInfoById(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_synonym2model.model_id,
                        wheel_synonym2model.synonym,
                        wheel_models.manufacturer_id
                FROM wheel_synonym2model LEFT JOIN wheel_models
                ON wheel_models.id=wheel_synonym2model.model_id
                WHERE wheel_synonym2model.model_id='.$this->modelId.'';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData[$row->model_id][]=$row;
        }
        return $viewData;
    }

    public function getModels(){
        $viewSynonyms=$this->attachSynonyms();
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_models.id,
                        wheel_models.name as model,
                        wheel_models.manufacturer_id,
                        wheel_manufacturers.name as manufacturer,
                        LOWER(wheel_manufacturers.name) as manufacturerLower
                FROM wheel_models
                LEFT JOIN wheel_manufacturers
                ON wheel_manufacturers.id=wheel_models.manufacturer_id
                ORDER BY wheel_manufacturers.name ASC, wheel_models.name ASC';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            if(isset($viewSynonyms[$row->id])){
                $row->alias=$viewSynonyms[$row->id];
            }else{
                $row->alias=null;
            }
            $manufacturerLower=$row->manufacturerLower;
            unset($row->manufacturerLower);
            $viewData[$manufacturerLower][]=$row;
        };
        return json_encode($viewData);
    }

    private function attachSynonyms(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_synonym2model.model_id,
                        wheel_synonym2model.synonym,
                        wheel_models.manufacturer_id
                FROM wheel_synonym2model LEFT JOIN wheel_models
                ON wheel_models.id=wheel_synonym2model.model_id';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData[$row->model_id][]=$row;
        }
        return $viewData;
    }
}