<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class all_posts extends datamodel{

    public function commit(){
        $this->datamodel=$this->getAllPosts();
    }

    public function getAllPosts(){

        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT * FROM posts ORDER BY id DESC';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData[]=$row;
        }
        return $viewData;
    }
}