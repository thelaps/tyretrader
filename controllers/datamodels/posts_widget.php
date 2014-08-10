<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class posts_widget extends datamodel{

    public function commit(){
        $this->datamodel=$this->getRandomPosts();
    }

    public function getRandomPosts(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT id, title, src FROM posts ORDER BY rand() LIMIT 2';
        $stmt = $dbo->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData[]=$row;
        }
        return $viewData;
    }
}