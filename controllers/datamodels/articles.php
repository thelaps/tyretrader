<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
class articles extends datamodel{

    public function commit(){
        $this->datamodel=$this->getArticles();
    }

    public function getArticles(){
        $viewData=array();
        $dbo=App::DBO();
        $query='SELECT oxid, oxtitle, oxprice FROM oxarticles WHERE oxactive=\'1\' ORDER BY rand() LIMIT 10';
        $stmt = $dbo->prepare($query);

        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $viewData[]=$row;
        }
        return $viewData;
    }
}