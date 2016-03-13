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
    const NORESET = 0;
    const RESETTED = 1;
    const RESETFAIL = 2;
    const TYPE_USER = 1;
    const TYPE_SHOP = 2;
    const TYPE_COMPANY = 3;
    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

    public static $table_name = 'wheel_user';

    public $confirm;

    static $validates_presence_of = array(
        array('login', 'message' => 'Введите другой логин'),
        array('phone', 'message' => 'Введите правильно № телефона'),
        array('lastname', 'message' => 'Введите фамилию'),
        array('firstname', 'message' => 'Введите имя'),
        array('email', 'message' => 'Введите email'),
        array('pass', 'message' => 'Введите пароль'),
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

    public function register($attributes)
    {
        $model = new User();
        $model->email = $attributes['email'];
        $model->pass = $attributes['pass'];
        $model->cityid = $attributes['cityId'];
        $model->usertype = $attributes['userType'];
        $model->firstname = $attributes['firstName'];
        $model->lastname = $attributes['lastName'];
        $model->phone = $attributes['phone'];
        $model->login = $attributes['login'];
        if ( !$model->isExist($model->login, $model->email) ) {
            if($model->is_valid()){
                $model->pass = md5($attributes['pass']);

                if ( $model->usertype == User::TYPE_SHOP || $model->usertype == User::TYPE_COMPANY ) {
                    $company = new Company();
                    $company->cityid = $model->cityid;
                    $company->active = Company::STATUS_ACTIVE;
                    if ( $model->usertype == User::TYPE_COMPANY ) {
                        $company->warehouse = Company::WAREHOUSE;
                    }
                    $company->iso = 'UAH';
                    $company->rate = 1.000;
                    $company->expire = date('Y-m-d H:i:s', strtotime('+2 days'));
                    $company->save();

                    $companyBilling = new Companybilling();
                    $companyBilling->companyid = $company->id;
                    $companyBilling->email = $model->email;
                    $companyBilling->phone_1 = $model->phone;
                    $companyBilling->cityid = $model->cityid;
                    $companyBilling->save();

                    $model->companyid = $company->id;

                    if ( $model->usertype == User::TYPE_COMPANY ) {
                        Price::createCompanyPriceTable($company->id);
                        Price::synchronisePriceStructure();
                    }
                }


                $model->save();
                $model->pass = $attributes['pass'];
                App::helper()->sendMail('registerSuccess', $attributes['email'], 'Регистрация на портале', $model);
                $_content = new Content();
                $_supportEmail = $_content->getText('MANAGER_EMAIL_1');
                if (!empty($_supportEmail)) {
                    App::helper()->sendMail('registerSuccessAdmin', $_supportEmail, 'Новый пользователь на портале', $model);
                }
            }
        } else {
            $model->errors = array(
                array('message' => 'Логин уже занят'),
                array('message' => 'email уже занят')
            );
        }
        return $model;
    }

    public function getCompanyPaidStatus()
    {
        if ( $this->companyid > 0 ) {
            $company = $this->getActiveCompany();
            return (!empty($company));
        }
        return false;
    }

    public function getActiveCompany()
    {
        if ( $this->companyid > 0 ) {
            return Company::find($this->companyid, array('conditions' => "expire > NOW()"));
        } else {
            return null;
        }
    }

    public function getCompany($allowEmptyObject = true)
    {
        if ( $this->companyid > 0 ) {
            return Company::find($this->companyid);
        } else {
            return ($allowEmptyObject) ? new Company() : null;
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

    public function findForgotten($email, $login){
        $user = new User;
        if ( !empty($email) ) {
            $user = User::find(array('conditions' => array('email = ?', $email)));
        } elseif ( !empty($login) ) {
            $user = User::find(array('conditions' => array('login = ?', $login)));
        } elseif ( !empty($email) && !empty($login) ) {
            $user = User::find(array('conditions' => array('login = ? and email = ?', $login, $email)));
        } else {
            $user->errors = array(
                array('message' => 'Введите email и/или логин!')
            );
        }
        if ( empty($user) ) {
            $user->errors = array(
                array('message' => 'Пользователь не найден!')
            );
        } else {
            $data = new stdClass();
            $user->resetkey = md5(rand(0,27031990));
            $user->save(false);
            $data->user = $user;
            $data->link = App::getConfig('baseLink') . DIRECTORY_SEPARATOR . '?reset=' . $user->resetkey;
            App::helper()->sendMail('forgotRequest', $user->email, 'Восстановление данных', $data);
        }
        return $user;
    }

    public function resetPassByKey($key){
        $user = User::find(array('conditions' => array('resetKey = ?', $key)));
        if ( $user ) {
            $newPass = 'rcvry' . rand(0,2468);
            $user->pass = md5($newPass);
            $user->resetkey = null;
            $user->save(false);
            $data = new stdClass();
            $data->user = $user;
            $data->newpass = $newPass;
            App::helper()->sendMail('forgotDone', $user->email, 'Восстановление данных', $data);
            return true;
        }
        return false;
    }

    public function isExist($login, $email){
        $user = User::find(array('conditions' => array('login = ? OR email = ?', $login, $email)));
        return ($user);
    }

    public function isPaidForView()
    {
        if ( $this->exists() ) {
            return true;
        }
        return false;
    }

    public function getAllGroupedUsres()
    {
        $model = new User();
        $items = new stdClass();
        $items->users = $model->find_by_sql('
        SELECT `wheel_user`.*,
        `wheel_companies`.`name` AS company_name,
        `wheel_companies`.`active` AS company_status,
        `wheel_companies`.`expire` AS company_expire,
        `wheel_city`.`name` AS city_name
        FROM `wheel_user` LEFT JOIN `wheel_companies`
        ON `wheel_companies`.`id`=`wheel_user`.`companyId`
        LEFT JOIN `wheel_city` ON `wheel_city`.`id` = `wheel_companies`.`cityId`
        ORDER BY `wheel_companies`.`name`, `wheel_user`.`firstName`, `wheel_user`.`lastName`');
        return $items->users;
    }

    public function getUsersStat()
    {
        $model = new User();
        $stat = new stdClass();
        $_online = $model->find_by_sql('
        SELECT COUNT(`wheel_user`.`log_time`) AS counter
        FROM `wheel_user`
        WHERE NOW() BETWEEN `wheel_user`.`log_time` AND DATE_SUB(`wheel_user`.`log_time` , INTERVAL -1 HOUR )
        ');
        $stat->online = ( !empty($_online) ) ? $_online[0]->counter : 0;

        $_lastDayOnline = $model->find_by_sql('
        SELECT COUNT(`wheel_user`.`log_time`) AS counter
        FROM `wheel_user`
        WHERE NOW() BETWEEN `wheel_user`.`log_time` AND DATE_SUB(`wheel_user`.`log_time` , INTERVAL -24 HOUR )
        ');
        $stat->last_day_online = ( !empty($_lastDayOnline) ) ? $_lastDayOnline[0]->counter : 0;
        return $stat;
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