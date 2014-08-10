<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class post extends datamodel{

    public function commit(){
        $this->datamodel=$this->getPost();
    }

    public function getPost(){

        $getReq=$this->getRequest('get');

        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT * FROM posts WHERE id=\''.$getReq['id'].'\'';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData=$row;
        }
        return $viewData;
    }
}