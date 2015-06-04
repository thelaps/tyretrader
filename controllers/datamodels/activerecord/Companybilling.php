<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 11.12.13
 * Time: 23:25
 * To change this template use File | Settings | File Templates.
 */
class Companybilling extends ActiveRecord\Model
{
    public static $table_name = 'wheel_company2billing';

    public static function getCompanybillingByCompanyId($companyId)
    {
        $model = new Companybilling();
        $company = new stdClass();
        $companyItems = $model->find_by_sql('SELECT `wheel_company2billing`.*, `wheel_companies`.`name`
                        FROM `wheel_company2billing`
                        INNER JOIN `wheel_companies`
                        ON `wheel_companies`.`id`=`wheel_company2billing`.`companyId`
                        WHERE `wheel_company2billing`.`companyId`='.$companyId);
        $company->items = (sizeof($companyItems)>0)?$companyItems[0]:$model;
        $company->items->assign_attribute('phones', array($company->items->phone_1,$company->items->phone_2,$company->items->phone_3));
        $company->total = sizeof($companyItems);
        return $company;
    }

    public static function getCompanybillingByCompanyIdClean($companyId)
    {
        $model = new Companybilling();
        $company = new stdClass();
        $companyItems = $model->find_by_sql('SELECT `wheel_company2billing`.*, `wheel_companies`.`name`
                        FROM `wheel_company2billing`
                        INNER JOIN `wheel_companies`
                        ON `wheel_companies`.`id`=`wheel_company2billing`.`companyId`
                        WHERE `wheel_company2billing`.`companyId`='.$companyId);
        $company->items = (sizeof($companyItems)>0)?$companyItems[0]:$model;
        $company->items->assign_attribute('phones', array($company->items->phone_1,$company->items->phone_2,$company->items->phone_3));
        return $company->items;
    }

    public function getLogoUrl()
    {
        $logoPath = array(
            App::getConfig('baseLink'),
            'files',
            'company'
        );
        $logoPath = implode(DIRECTORY_SEPARATOR, $logoPath) . DIRECTORY_SEPARATOR;
        if ( empty($this->logo) ) {
            return $logoPath . 'no_logo.png';
        } else {
            return $logoPath . $this->logo;
        }
    }
}