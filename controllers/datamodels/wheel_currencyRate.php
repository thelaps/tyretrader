<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class wheel_currencyRate extends datamodel{

    public function commit(){
        $this->datamodel=$this->getCurrencyRate();
    }

    public function getCurrencyRate(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT  wheel_currencyRate.iso,  wheel_currencyRate.rate
                FROM wheel_currencyRate
                ORDER BY wheel_currencyRate.iso';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData['rate'][$row->iso]=$row->rate;
            $viewData['iso']=$this->getIsoes();
        }

        return $viewData;
    }

    public function getIsoes(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT  wheel_dict2parameters.name
                FROM wheel_dict2parameters
                WHERE wheel_dict2parameters.parameter_id=40';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData[]=$row->name;
        }

        return $viewData;
    }

    public function getIsoMargins(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT wheel_currencyRate.iso, wheel_currencyRate.rate
                FROM wheel_currencyRate
                ORDER BY wheel_currencyRate.iso';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData[$row->iso]=$row->rate;
        }

        return $viewData;
    }
}