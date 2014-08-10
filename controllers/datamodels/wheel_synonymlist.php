<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class wheel_synonymlist extends datamodel{

    public function commit(){
        $this->datamodel=array(
            'list'=>$this->getSynonymList(),
            'values'=>$this->getSynonymValues()
        );
    }

    public function getSynonymValues(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_synonym2dict.id,
                wheel_synonym2dict.synonym,
                wheel_dict2parameters.id as dict_id,
                wheel_dict2parameters.name as dict_value,
                wheel_parameters.name as parameter_name,
                wheel_parameters.id as parameter_id
                FROM (wheel_synonym2dict
                LEFT JOIN wheel_dict2parameters
                ON wheel_dict2parameters.id=wheel_synonym2dict.dict_id)
                LEFT JOIN wheel_parameters ON wheel_parameters.id=wheel_dict2parameters.parameter_id';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData[$row->parameter_id][]=$row;
        }
        $viewData[41]=$this->appendModelsValues();
        $viewData[42]=$this->appendManufacturersValues();

        return $viewData;
    }

    public function getSynonymList(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_dict2parameters.id as dict_id,
                wheel_dict2parameters.name as dict_value,
                wheel_parameters.name as parameter_name,
                wheel_parameters.id as parameter_id
                FROM wheel_dict2parameters LEFT JOIN wheel_parameters
                ON wheel_parameters.id=wheel_dict2parameters.parameter_id';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData[$row->parameter_id]['origin'][]=$row;
            $viewData[$row->parameter_id]['value']=$row->parameter_name;
            $viewData[$row->parameter_id]['key']=$row->parameter_id;
        }
        $viewData[41]=$this->appendModels();
        $viewData[42]=$this->appendManufacturers();

        return $viewData;
    }

    public function appendModels(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_models.id as dict_id,
                wheel_models.name as dict_value,
                wheel_models.manufacturer_id
                FROM wheel_models
                ORDER BY wheel_models.name';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $row->parameter_name='Модель';
            $row->parameter_id=41;
            $viewData['origin'][$row->manufacturer_id][]=$row;
        }
        $viewData['value']='Модель';
        $viewData['key']=41;

        return $viewData;
    }

    public function appendModelsValues(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_synonym2model.id,
                wheel_synonym2model.synonym,
                wheel_models.id as dict_id,
                wheel_models.name as dict_value,
                wheel_models.manufacturer_id
                FROM wheel_synonym2model LEFT JOIN wheel_models
                ON wheel_synonym2model.model_id=wheel_models.id
                ORDER BY wheel_models.name, wheel_synonym2model.synonym';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $row->parameter_name='Модель';
            $row->parameter_id=41;
            $viewData[$row->manufacturer_id][]=$row;
        }

        return $viewData;
    }

    public function appendManufacturers(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_manufacturers.id as dict_id,
                wheel_manufacturers.name as dict_value
                FROM wheel_manufacturers
                ORDER BY wheel_manufacturers.name';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $row->parameter_name='Производитель';
            $row->parameter_id=42;
            $viewData['origin'][]=$row;
        }
        $viewData['value']='Производитель';
        $viewData['key']=42;

        return $viewData;
    }

    public function appendManufacturersValues(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_synonym2manufacturers.id,
                wheel_synonym2manufacturers.synonym,
                wheel_manufacturers.id as dict_id,
                wheel_manufacturers.name as dict_value
                FROM wheel_synonym2manufacturers LEFT JOIN wheel_manufacturers
                ON wheel_synonym2manufacturers.manufacturer_id=wheel_manufacturers.id
                ORDER BY wheel_manufacturers.name, wheel_synonym2manufacturers.synonym';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $row->parameter_name='Производитель';
            $row->parameter_id=42;
            $viewData[]=$row;
        }

        return $viewData;
    }
}