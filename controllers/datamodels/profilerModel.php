<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 29.09.13
 * Time: 19:24
 * To change this template use File | Settings | File Templates.
 */
class profilerModel extends datamodel{

    public $user = null;
    public $company = null;

    public function commit(){

    }

    public function isLoggedIn(){
        return $this->checkToken();
    }

    private function checkToken(){
        $token = (isset($_SESSION['userToken'])) ? $_SESSION['userToken'] : null;
        if ( $token != null ) {
            $user = User::find(array('conditions' => array('token = ?', $token)));
            if(!empty($user)){
                $this->user = $user;
                $this->company = $user->getCompanyBilling();
                return true;
            }
        }
        return false;
    }

    public function setUser($user)
    {
        $token = uniqid('user_');
        $_SESSION['userToken'] = $token;
        $user->update_attributes(array('token'=>$token));
    }

    public function user()
    {
        $this->checkToken();
        return $this->user;
    }

    public function isAllowedToLoad($loadable)
    {
        $notAuthorized = array(
            'opt',
            'analitycs',
            'calculator',
            'export',
            'home',
        );
        if ( !$this->isLoggedIn() ) {
            return !in_array($loadable, $notAuthorized);
        }
        return true;
    }
}