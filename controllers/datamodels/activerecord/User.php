<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 11.12.13
 * Time: 23:25
 * To change this template use File | Settings | File Templates.
 */
class User extends ActiveRecord\Model
{
    public static $table_name = 'wheel_user';

    public $confirm;

    static $validates_presence_of = array(
        array('login', 'message' => 'логин'),
        array('phone', 'message' => 'телефон'),
        array('lastname', 'message' => 'фамилию'),
        array('firstname', 'message' => 'имя'),
        array('email', 'message' => 'email'),
        array('pass', 'message' => 'пароль'),
    );

    /*static $validates_format_of = array(
        array('email', 'with' =>
        '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/', 'message' => 'реальный email')
    );*/

    /*public function makePass($confirm){
        if ($this->pass != $confirm){
            //$this->errors->add('pass', 'Пароль и подтверждение не совпадают!');
            return $this->pass;
        }else{
            return md5($this->pass);
        }
    }*/

    public function validate()
    {
        if ($this->pass != $this->confirm){
            $this->errors->add('pass', 'Пароль и подтверждение не совпадают!');
        }
    }

    public function register($attributes){
        $this->email = $attributes['email'];
        $this->pass = $attributes['pass'];
        $this->cityid = $attributes['cityId'];
        $this->usertype = $attributes['userType'];
        $this->firstname = $attributes['firstName'];
        $this->lastname = $attributes['lastName'];
        $this->phone = $attributes['phone'];
        $this->login = $attributes['login'];
        if($this->is_valid()){
            $this->pass = md5($attributes['pass']);
            $this->save();
        }
        return $this;
    }

    public function getCompany()
    {
        if ( $this->companyid > 0 ) {
            return Company::find($this->companyid);
        } else {
            return new Company();
        }
    }

    public function getCompanyBilling()
    {
        if ( $this->companyid > 0 ) {
            return Companybilling::getCompanybillingByCompanyId($this->companyid);
        } else {
            return new Companybilling();
        }
    }

    public static function getAccount()
    {
        $user = new User();
        $profiler = App::newJump('profilerModel','datamodels');
        if ( $profiler->isLoggedIn() ) {
            return $profiler->user;
        }
        return $user;
    }

    public function change($attributes){
        print_r(array($this->getCompanyBilling()));
        die();
        $this->email = $attributes['email'];
        $this->cityid = $attributes['cityId'];
        if ( isset($attributes['userType']) ) {
            $this->usertype = $attributes['userType'];
        }
        $this->firstname = $attributes['firstName'];
        $this->lastname = $attributes['lastName'];
        $this->phone = $attributes['phone'];

        if($this->is_valid()){
            if ( md5($attributes['pass']) == $this->pass ) {
                $this->pass = md5($attributes['new_pass']);
                $this->save();
            }
        }
        return $this;
    }

    public function auth($login, $pass){
        $user = User::find(array('conditions' => array('login = ? and pass = ?', $login, md5($pass))));
        return $user;
    }
    /*// order can have many payments by many people
    // the conditions is just there as an example as it makes no logical sense
    static $has_many = array(
        array('payments'),
        array('people',
            'through'    => 'payments',
            'select'     => 'people.*, payments.amount',
            'conditions' => 'payments.amount < 200'));

    // order must have a price and tax > 0
    static $validates_numericality_of = array(
        array('price', 'greater_than' => 0),
        array('tax',   'greater_than' => 0));

    // setup a callback to automatically apply a tax
    static $before_validation_on_create = array('apply_tax');

    public function apply_tax()
    {
        if ($this->person->state == 'VA')
            $tax = 0.045;
        elseif ($this->person->state == 'CA')
            $tax = 0.10;
        else
            $tax = 0.02;

        $this->tax = $this->price * $tax;
    }*/
}