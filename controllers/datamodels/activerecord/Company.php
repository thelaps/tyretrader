<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 11.12.13
 * Time: 23:25
 * To change this template use File | Settings | File Templates.
 */
class Company extends ActiveRecord\Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_SUSPENDED = 2;
    const STATUS_INACTIVE = 0;
    const WAREHOUSE = 1;

    public static $table_name = 'wheel_companies';

    static $belongs_to = array(
        array('city', 'readonly' => true)
    );

    public static function getCompanies($warehousesOnly = false)
    {
        $model = new Company();
        $companies = new stdClass();
        $companies->items = $model->find_by_sql('
                        SELECT `wheel_companies`.*,
                               `wheel_city`.`name` as city,
                               `wheel_region`.`name` as region,
                               `wheel_region`.`id` as regionid,
                               C.`name` as capital,
                               C.`id` as capitalid
                        FROM `wheel_companies`
                        LEFT JOIN `wheel_city`
                        ON `wheel_city`.`id`=`wheel_companies`.`cityId`
                        LEFT JOIN `wheel_region`
                        ON `wheel_region`.`id`=`wheel_city`.`region_id`
                        LEFT JOIN `wheel_city` C
                        ON C.`capital_id`=`wheel_region`.`id`
                        '.(($warehousesOnly) ? 'WHERE `wheel_companies`.`warehouse`='.self::WAREHOUSE : '').'
                        ORDER BY `wheel_companies`.`name`');
        $companies->total = sizeof($companies->items);
        $companies->filter = null;
        return $companies;
    }

    public static function getCompanyById($companyId)
    {
        $model = new Company();
        $company = new stdClass();
        $companyItems = $model->find_by_sql('SELECT `wheel_companies`.*,
                        `wheel_city`.`name` as city,
                        `wheel_user`.`firstName`,
                        `wheel_user`.`lastName`,
                        `wheel_user`.`email`,
                        `wheel_user`.`phone`
                        FROM (`wheel_companies`
                        LEFT JOIN `wheel_city`
                        ON `wheel_city`.`id`=`wheel_companies`.`cityId`)
                        LEFT JOIN `wheel_user`
                        ON `wheel_user`.`companyId`=`wheel_companies`.`id`
                        WHERE `wheel_companies`.`id`='.$companyId);
        $company->items = (sizeof($companyItems)>0)?$companyItems[0]:$model;
        $company->total = sizeof($companyItems);
        $company->billing = Companybilling::getCompanybillingByCompanyIdClean($company->items->id);
        return $company;
    }

    public static function getCompanyByIdBE($companyId)
    {
        $model = new Company();
        $company = new stdClass();
        $companyItems = $model->find_by_sql('SELECT `wheel_companies`.`id`,
                `wheel_companies`.`name`,
                `wheel_companies`.`cityId`,
                `wheel_companies`.`active`,
                `wheel_companies`.`rate`,
                `wheel_companies`.`iso`,
                        `wheel_city`.`name` as city,
                        `wheel_user`.`firstName`,
                        `wheel_user`.`lastName`,
                        `wheel_user`.`email`,
                        `wheel_user`.`phone`,
                        `wheel_user`.`balance`
                        FROM (`wheel_companies`
                        LEFT JOIN `wheel_city`
                        ON `wheel_city`.`id`=`wheel_companies`.`cityId`)
                        LEFT JOIN `wheel_user`
                        ON `wheel_user`.`companyId`=`wheel_companies`.`id`
                        WHERE `wheel_companies`.`id`='.$companyId);
        $company->items = (sizeof($companyItems)>0)?$companyItems[0]:$model;
        $company->total = sizeof($companyItems);
        $company->billing = Companybilling::getCompanybillingByCompanyIdClean($company->items->id);
        return $company;
    }

    public static function getCompany($companyId)
    {
        $model = new Company();
        $company = $model->find(array('conditions' => array('id = ?', $companyId)));
        return $company;
    }

    public static function getAllByRegion($regionId)
    {
        $sqlIds = array();
        $model = new City;
        $ids = $model->find_by_sql('
        SELECT `wheel_companies`.`id`
            FROM `wheel_companies`
            INNER JOIN (
                SELECT `wheel_city`.`id`
                FROM `wheel_city`
                WHERE `wheel_city`.`region_id`='.$regionId.'
                ) as C
            ON `wheel_companies`.`cityId`=C.`id`
            ORDER BY `wheel_companies`.`id`');
        foreach($ids as $row){
            $sqlIds[]=$row->id;
        }
        return $sqlIds;
    }

    public function getPaidStatusByAllUsers()
    {
        $model = new Company();
        $paidItems = $model->find_by_sql('
        SELECT * FROM `wheel_invoice` AS i
        INNER JOIN `wheel_user` AS u ON i.`user_id` = u.`id`
        WHERE u.`companyId` = ' . $this->id . '
        AND i.`type`=' . Invoice::TYPE_PACKAGE . '
        AND i.`status`=' . Invoice::STATUS_PAID . '
        AND i.`expire` > NOW()
        ORDER BY i.`expire`
        ');
        return (sizeof($paidItems) > 0);
    }

    public static function sendExpirePriceMail()
    {
        $model = new Company();
        $expirePriceItems = $model->find_by_sql('
            SELECT c.*, u.`email`, u.`firstName`, u.`lastName`
            FROM `wheel_companies` AS c
            LEFT JOIN `wheel_user` AS u
                ON u.`companyId`=c.`id`
            WHERE c.`warehouse`='.self::WAREHOUSE.'
            AND DATEDIFF(NOW(), c.`last_update`) > '.App::getConfig('updateExpire').'
        ');
        if ( sizeof($expirePriceItems) > 0 ) {
            foreach ( $expirePriceItems as $companyItem ) {
                App::helper()->sendMail('expirationOfPrice', $companyItem->email, 'Обновление прайса', $companyItem);
                die;
            }
        }
        print_r(array('OKAY', sizeof($expirePriceItems)));
    }

    /*public static  function getAllAssocRates()
    {
        $companies = array();
        $model = new Company();
        $tmpCompanies = $model->all();
        foreach ( $tmpCompanies as $company ) {
            $companies[$company->id]
        }
    }*/
}