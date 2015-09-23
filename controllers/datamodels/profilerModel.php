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
    public $currency = null;

    public function commit(){

    }

    public function isLoggedIn(){
        return $this->checkToken();
    }

    public function isPaidForView(){
        if ($this->isLoggedIn()) {
            if ( ($this->user->usertype == User::TYPE_SHOP && $this->user->isPaidForView()) || $this->user->usertype == User::TYPE_COMPANY ) {
                return $this->user->getCompanyPaidStatus();
            }
        }
        return false;
    }

    private function checkToken(){
        $token = (isset($_SESSION['userToken'])) ? $_SESSION['userToken'] : null;
        if ( $token != null ) {
            $user = User::find(array('conditions' => array('token = ?', $token)));
            if(!empty($user)){
                $this->user = $user;
                $this->company = $user->getCompanyBilling();
                $this->currency = CurrencyRate::all(array('conditions' => 'ISO != \'' . CurrencyRate::ISO_UAH . '\''));
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

    public function isAllowedToLoad($loadable, $isAdminAccess = false)
    {
        $notAuthorized = array(
            'opt',
            'analitycs',
            'calculator',
            'export',
            'home',
        );
        $notAuthorizedAdmin = array(
            'price_panel',
            'user_panel'
        );

        if ($isAdminAccess) {
            if ( !$this->isLoggedIn() ) {
                return !in_array($loadable, $notAuthorizedAdmin);
            } elseif ($this->isLoggedIn() && $this->user->roleid == User::ROLE_ADMIN) {
                return true;
            } else {
                return false;
            }
        } else {
            if ( !$this->isLoggedIn() ) {
                return !in_array($loadable, $notAuthorized);
            }
        }
        return true;
    }
}