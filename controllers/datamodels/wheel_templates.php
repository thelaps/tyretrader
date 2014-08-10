<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class wheel_templates extends datamodel{

    public function commit(){
        $this->datamodel=$this->getTemplates();
    }

    public function getTemplates(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT * FROM wheel_searchTemplate';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData[$row->template_key]=$row;
        }
        return json_encode($viewData);
    }
}