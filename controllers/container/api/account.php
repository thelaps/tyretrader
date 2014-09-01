<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class account extends controller{

    public $errors = array();

    public $profiler = null;

    public function render(){
        $get = $this->getRequest('get');
        $post = $this->getRequest('post');

        $completeData = null;
        $action = null;
        if(isset($post['fnc'])){
            $action = $post['fnc'];
            switch ($post['fnc']){
                case 'register':
                    $completeData = $this->apiRegister();
                    break;
                case 'changeAccount':
                    $completeData = $this->apiUpdateAccount();
                    break;
                case 'auth':
                    $completeData = $this->apiAuth();
                    break;
                case 'logout':
                    $completeData = $this->apiLogout();
                    break;
            }
            //App::ajax(json_encode($response));
        }
        $response = array(
            'action' => $action,
            'completeData' => $completeData->attributes(),
            'errors' => (isset($completeData->errors))?$completeData->errors->full_array():$this->errors
        );
        App::ajax(json_encode($response));
    }

    private function apiRegister(){
        $post = $this->getRequest('post');
        $user = new User();
        $user = $user->register($post);
        return $user;
    }

    private function apiUpdateAccount(){
        if ( $this->profiler->isLoggedIn() ) {
            $post = $this->getRequest('post');
            $user = $this->profiler->user;

            if ( App::isActive($post['user']['firstName']) ) {
                $user->firstname = $post['user']['firstName'];
            }
            if ( App::isActive($post['user']['lastName']) ) {
                $user->lastname = $post['user']['lastName'];
            }
            if ( App::isActive($post['user']['email']) ) {
                $user->email = $post['user']['email'];
            }
            if ( App::isActive($post['user']['phone']) ) {
                $user->phone = $post['user']['phone'];
            }
            if ( App::isActive($post['user']['cityId']) ) {
                $user->cityid = $post['user']['cityId'];
            }
            if ( App::isActive($post['user']['pass']) ) {
                if($user->is_valid()){
                    if ( md5($post['user']['pass']) == $user->pass ) {
                        $user->pass = md5($post['user']['new_pass']);
                    }
                }
            }
            if ( App::isActive($post['user']['subscribe']) ) {
                $user->subscribe = $post['user']['subscribe'];
            }
            if ( App::isActive($post['user']['userType']) ) {
                $user->usertype = $post['user']['userType'];
            };
            $user->save();

            if ( App::isActive($post['company']['name']) ) {
                $company = Company::find(array('conditions' => array('id = ?', $user->companyid)));
                if ( $company ) {
                    $company->name = $post['company']['name'];
                    $company->save();
                }
            }

            $companyBilling = Companybilling::find(array('conditions' => array('companyid = ?', $user->companyid)));
            if ( $companyBilling ) {
                if ( App::isActive($post['company']['shop_name']) ) {
                    $companyBilling->shop_name = $post['company']['shop_name'];
                };
                if ( App::isActive($post['company']['certificate']) ) {
                    $companyBilling->certificate = $post['company']['certificate'];
                };
                if ( App::isActive($post['company']['site']) ) {
                    $companyBilling->site = $post['company']['site'];
                };
                if ( App::isActive($post['company']['payment_details']) ) {
                    $companyBilling->payment_details = $post['company']['payment_details'];
                };
                if ( App::isActive($post['company']['affiliates']) ) {
                    $companyBilling->affiliates = $post['company']['affiliates'];
                };
                if ( App::isActive($post['company']['conditions']) ) {
                    $companyBilling->conditions = $post['company']['conditions'];
                };
                if ( App::isActive($post['company']['noncache_conditions']) ) {
                    $companyBilling->noncache_conditions = $post['company']['noncache_conditions'];
                };
                if ( App::isActive($post['company']['logo']) ) {
                    if ( $this->uploadLogo() ) {
                        $companyBilling->logo = $_FILES['logo']['name'];
                    }
                };
                $companyBilling->save();
            }
            return $user;
        }
        return false;
    }

    private function uploadLogo(){
        $demo_mode = false;
        $upload_dir = 'files/company/';
        $allowed_ext = array('png','gif', 'jpg', 'jpeg');

        if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
            //$this->sError='Error! Wrong HTTP method!';
            return false;
        }

        if(array_key_exists('logo',$_FILES) && $_FILES['logo']['error'] == 0 ){
            $source = $_FILES['logo'];
            if(!in_array($this->get_extension($source['name']),$allowed_ext)){
                //$this->sError='Only '.implode(',',$allowed_ext).' files are allowed!';
                return false;
            }
            if($demo_mode){
                $line = implode('		', array( date('r'), $_SERVER['REMOTE_ADDR'], $source['size'], $source['name']));
                file_put_contents('log.txt', $line.PHP_EOL, FILE_APPEND);
                //$this->sError='Uploads are ignored in demo mode.';
            }
            if(move_uploaded_file($source['tmp_name'], $upload_dir.urldecode($source['name']))){
                return true;
            }

        }else{
            return false;
        }
    }

    private function get_extension($file_name){
        $ext = explode('.', $file_name);
        $ext = array_pop($ext);
        return strtolower($ext);
    }

    private function apiAuth(){
        $profiler = $this->getModel('profilerModel');
        $post = $this->getRequest('post');
        $model = new User();
        $user = $model->auth($post['login'], $post['pass']);
        if(!empty($user)){
            $profiler->setUser($user);
        }else{
            $scope = new \stdClass();
            $scope->attribute = 'login';
            $scope->message = 'Введенные вами данные не верны!';
            array_push($this->errors, $scope);
            return $model;
        }
        return $user;
    }

    private function apiLogout(){
        session_destroy();
        return new User();
    }
}