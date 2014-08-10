<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class wheel_valueslist extends datamodel{

    public function commit($id = null){
        $this->datamodel=array(
            'list'=>$this->getValuesList()
        );
    }

    public function getValuesList(){
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
        $viewData[41]=$this->appendModels(true);
        $viewData[42]=$this->appendManufacturers();

        return $viewData;
    }

    public function appendModels($isFullData = false){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_models.id as dict_id,
                wheel_models.name as dict_value,
                wheel_models.manufacturer_id,';
        if($isFullData){
            $query.='
                wheel_models.season,
                wheel_models.use,
                wheel_models.type_transport,
                wheel_models.axle,
                wheel_models.src,
                wheel_models.description,';
        }
        $query.='
                wheel_manufacturers2type.type
                FROM wheel_models LEFT JOIN wheel_manufacturers2type
                ON wheel_manufacturers2type.manufacturer_id=wheel_models.manufacturer_id
                ORDER BY wheel_models.name';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $row->parameter_name='Модель';
            $row->parameter_id=41;
            $viewData['origin'][$row->manufacturer_id][]=$row;
            $viewData['alias'][$row->manufacturer_id][$row->dict_id]=$row;
        }
        $viewData['value']='Модель';
        $viewData['key']=41;

        return $viewData;
    }

    public function appendManufacturers(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT DISTINCT wheel_manufacturers.id as dict_id,
                wheel_manufacturers.name as dict_value,
                wheel_manufacturers2type.type,
                wheel_manufacturers2type.wheel_type
                FROM wheel_manufacturers LEFT JOIN wheel_manufacturers2type
                ON wheel_manufacturers2type.manufacturer_id=wheel_manufacturers.id
                ORDER BY wheel_manufacturers.name';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $row->parameter_name='Производитель';
            $row->parameter_id=42;
            $viewData['origin'][]=$row;
            $viewData['alias'][$row->dict_id]=$row;
        }
        $viewData['value']='Производитель';
        $viewData['key']=42;

        return $viewData;
    }
}