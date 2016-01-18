<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class user_panel extends controller{

    public $sError=null;

    public function render(){
        $get=$this->getRequest('post');
        if(isset($get['fnc'])){
            $isComplete=false;
            switch ($get['fnc']){
                case 'add':
                    $isComplete=false;
                    break;
                case 'update':
                    $isComplete=false;
                    break;
                case 'delete':
                    $isComplete=$this->deleteUser($get['dataid']);
                    break;
            }
            App::ajax(json_encode(array('status'=>$isComplete)));
        }else{
            $this->viewData['users']=$this->getUsers();
            $this->viewData['statistics']=$this->getUsersStat();
            return 'users.tpl';
        }
        App::ajax($this->sError);
    }

    public function getUsers(){
        $model=new User; //Getter for datamodel classes -> we have an object of class
        return $model->getAllGroupedUsres(); //"->datamodel" - pseudo storage. After commit this is not empty)
    }

    public function deleteUser($_id){
        $user = User::find($_id);
        if ( $user->companyid > 0 ) {
            $company = $user->getCompany(false);
            if ($company != null) {
                $company->delete();
            }
        }
        $user->delete();
        return Price::synchronisePriceStructure();
    }

    public function getUsersStat(){
        $model=new User; //Getter for datamodel classes -> we have an object of class
        return $model->getUsersStat();
    }
}