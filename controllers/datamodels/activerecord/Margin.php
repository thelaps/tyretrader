<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 11.12.13
 * Time: 23:25
 * To change this template use File | Settings | File Templates.
 */
class Margin extends ActiveRecord\Model
{
    public static $table_name = 'wheel_margins';

    public static function addMarginItem($attributes){
        $model = null;
        if ( !empty($attributes['calculator']['id']) ) {
            $model = Margin::find($attributes['calculator']['id']);
        } else {
            $model = new Margin();
        }
        $model->type = $attributes['calculator']['type'];
        $model->percentage = $attributes['calculator']['percentage'];
        $model->min_cost = round($attributes['calculator']['min_cost'],2);
        $model->max_cost = round($attributes['calculator']['max_cost'],2);
        $model->fixed_cost = round($attributes['calculator']['fixed_cost'],2);
        $model->not_less = round($attributes['calculator']['not_less'],2);
        $model->not_more = round($attributes['calculator']['not_more'],2);
        $model->shipping = round($attributes['calculator']['shipping'],2);
        $model->transfer = round($attributes['calculator']['transfer'],2);
        $model->bank = round($attributes['calculator']['bank'],2);
        $model->manufacturer_id = (!empty($attributes['calculator']['manufacturer_id'])) ? $attributes['calculator']['manufacturer_id'] : null;
        $model->model_id = (!empty($attributes['calculator']['model_id'])) ? $attributes['calculator']['model_id'] : null;
        $model->city_id = (!empty($attributes['calculator']['city_id'])) ? $attributes['calculator']['city_id'] : null;
        $model->company_id = (!empty($attributes['calculator']['company_id'])) ? $attributes['calculator']['company_id'] : null;
        $model->season = (isset($attributes['calculator']['season'])) ? $attributes['calculator']['season'] : null;
        $model->size_w = (isset($attributes['tyre']['size_w'])) ? $attributes['tyre']['size_w'][0] : null;
        $model->size_h = (isset($attributes['tyre']['size_h'])) ? $attributes['tyre']['size_h'][0] : null;
        $model->size_r = (isset($attributes['tyre']['size_r'])) ? $attributes['tyre']['size_r'][0] : null;
        $model->save();
        return $model;
    }

    public static function getMarginItems(){
        $marginItemsObj = new  stdClass();
        $model = new Margin();
        $marginItemsObj->items = array();
        $marginItems = $model->find_by_sql('
            SELECT `wheel_margins`.*, `wheel_companies`.name as company, `wheel_models`.name as model, `wheel_manufacturers`.name as manufacturer
            FROM `wheel_margins` LEFT JOIN `wheel_companies` ON `wheel_companies`.`id` = `wheel_margins`.`company_id`
            LEFT JOIN `wheel_models` ON `wheel_models`.`id` = `wheel_margins`.`model_id`
            LEFT JOIN `wheel_manufacturers` ON `wheel_manufacturers`.`id` = `wheel_margins`.`manufacturer_id`
            ORDER BY `wheel_companies`.`name`
        ');
        foreach ( $marginItems as $item ) {
            $marginItemsObj->items[] = $item;
        }
        $marginItemsObj->total = sizeof($marginItemsObj->items);

        return $marginItemsObj;
    }

    public static function getMarginItemById($id)
    {
        $marginItemsObj = new  stdClass();
        $model = new Margin();
        $marginItemsObj->items = array();
        $marginItems = $model->find_by_sql('
            SELECT `wheel_margins`.*, `wheel_companies`.name as company, `wheel_models`.name as model, `wheel_manufacturers`.name as manufacturer
            FROM `wheel_margins` LEFT JOIN `wheel_companies` ON `wheel_companies`.`id` = `wheel_margins`.`company_id`
            LEFT JOIN `wheel_models` ON `wheel_models`.`id` = `wheel_margins`.`model_id`
            LEFT JOIN `wheel_manufacturers` ON `wheel_manufacturers`.`id` = `wheel_margins`.`manufacturer_id`
            WHERE `wheel_margins`.`id`='.$id.'
        ');
        foreach ( $marginItems as $item ) {
            $marginItemsObj->items[] = $item;
        }
        $marginItemsObj->total = sizeof($marginItemsObj->items);

        return $marginItemsObj;
    }

    public static function useMargin($item, &$total)
    {
        $company_id = $item->company_id;
        $manufacturer_id = $item->manufacturer_id;
        $model = new Margin();
        $marginItems = array();
        $marginItems = $model->find_by_sql('
            SELECT `wheel_margins`.*
            FROM `wheel_margins`
            WHERE `wheel_margins`.`company_id`='.$company_id.'
            ORDER BY
            `wheel_margins`.`model_id` DESC,
            `wheel_margins`.`size_w` DESC,
            `wheel_margins`.`size_h` DESC,
            `wheel_margins`.`size_r` DESC
        ');

        /*
         *   4,2,1 - поставщик
             4,2,1,1- поставщик+типоразмер
             4,2,2- типоразмер
             4,2,3- Бренду
             4,2,4- Бренду+модель
             4,2,5 Бренду+модель+типоразмер
             4,2,6 поставщик+ Бренду+ модель+ типоразмер*/


        $rules = array();
        foreach ( $marginItems as $marginItem ) {
            if ($marginItem->manufacturer_id != NULL && $marginItem->model_id != NULL &&
                $marginItem->size_w != NULL && $marginItem->size_h != NULL && $marginItem->size_r != NULL) {
                if ( $item->manufacturer_id == $marginItem->manufacturer_id && $item->model_id == $marginItem->model_id &&
                    $item->size_w == $marginItem->size_w && $item->size_h == $marginItem->size_h && $item->size_r == $marginItem->size_r ) {
                    $rules[]=$marginItem;
                }
            } elseif ($marginItem->manufacturer_id != NULL && $marginItem->model_id != NULL) {
                if ( $item->manufacturer_id == $marginItem->manufacturer_id && $item->model_id == $marginItem->model_id ) {
                    $rules[]=$marginItem;
                }
            } elseif ($marginItem->manufacturer_id != NULL) {
                if ( $item->manufacturer_id == $marginItem->manufacturer_id ) {
                    $rules[]=$marginItem;
                }
            } elseif ($marginItem->size_w != NULL && $marginItem->size_h != NULL && $marginItem->size_r != NULL) {
                if ( $item->size_w == $marginItem->size_w && $item->size_h == $marginItem->size_h && $item->size_r == $marginItem->size_r ) {
                    $rules[]=$marginItem;
                }
            }
        }

        if ( isset($rules[0]) ) {
            if ($rules[0]->percentage > 0) {
                $totalTmp = $total + (($total/100) * $rules[0]->percentage);
                if ( $rules[0]->not_more > 0 ) {
                    if ( $totalTmp <= $rules[0]->not_more && $totalTmp >= $rules[0]->not_less ) {
                        $total = $totalTmp;
                    }
                } else {
                    $total = $totalTmp;
                }
            } elseif ($rules[0]->fixed_cost > 0) {
                $totalTmp = $total + $rules[0]->fixed_cost;
                if ( $rules[0]->not_more > 0 ) {
                    if ( $totalTmp <= $rules[0]->not_more && $totalTmp >= $rules[0]->not_less ) {
                        $total = $totalTmp;
                    }
                } else {
                    $total = $totalTmp;
                }
            }
            $total = $total + $rules[0]->shipping + $rules[0]->transfer + $rules[0]->bank;
        }
    }

    /*public function auth($login, $pass){
        $user = User::find(array('conditions' => array('login = ? and pass = ?', $login, md5($pass))));
        return $user;
    }*/
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
        if ($model->person->state == 'VA')
            $tax = 0.045;
        elseif ($model->person->state == 'CA')
            $tax = 0.10;
        else
            $tax = 0.02;

        $model->tax = $model->price * $tax;
    }*/
}