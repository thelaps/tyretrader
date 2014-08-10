<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class posts extends controller{

    protected $sTpl=null;

    public function render(){

        $getReq=$this->getRequest('get');
        if(array_key_exists('id',$getReq)){
            $this->viewData['post']=$this->getPost();
            $this->sTpl='post.tpl';
        }else{
            $this->viewData['posts']=$this->getAllPosts();
            $this->sTpl='posts.tpl';
        }

        return $this->sTpl;
    }

    private function getPost(){
        $posts=$this->getModel('post'); //Getter for datamodel classes -> we have an object of class
        $posts->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $posts->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    private function getAllPosts(){
        $posts=$this->getModel('all_posts'); //Getter for datamodel classes -> we have an object of class
        $posts->commit(); //Commit - set data to storage from model - this able us to controlling models
        return $posts->datamodel; //"->datamodel" - pseudo storage. After commit this is not empty)
    }
}