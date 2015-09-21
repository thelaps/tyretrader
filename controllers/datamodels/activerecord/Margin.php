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

    private static $marginItems;

    const WHOLESALE = 'wholesale';
    const RETAIL = 'retail';

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

    public static function getMarginItemByType($type)
    {
        $marginItemsObj = new  stdClass();
        $model = new Margin();
        $marginItemsObj->items = array();
        $marginItems = $model->find_by_sql('
            SELECT `wheel_margins`.*, `wheel_companies`.name as company, `wheel_models`.name as model, `wheel_manufacturers`.name as manufacturer
            FROM `wheel_margins` LEFT JOIN `wheel_companies` ON `wheel_companies`.`id` = `wheel_margins`.`company_id`
            LEFT JOIN `wheel_models` ON `wheel_models`.`id` = `wheel_margins`.`model_id`
            LEFT JOIN `wheel_manufacturers` ON `wheel_manufacturers`.`id` = `wheel_margins`.`manufacturer_id`
            WHERE `wheel_margins`.`type`=\''.$type.'\'
        ');
        foreach ( $marginItems as $item ) {
            $marginItemsObj->items[] = $item;
        }
        $marginItemsObj->total = sizeof($marginItemsObj->items);

        return $marginItemsObj;
    }

    public static function deleteMarginItems($id)
    {
        $model = Margin::find($id);
        return $model->delete();
    }

    public static function useMargin($item, &$totalWholesale, &$totalRetail)
    {
        $company_id = $item->company_id;
        $manufacturer_id = $item->manufacturer_id;
        $model = new Margin();
        $marginItems = array();
        $wholesaleMarginToRetail = 0;
        if ( empty(self::$marginItems) ) {
            $marginItems = $model->find_by_sql('
                SELECT `wheel_margins`.*
                FROM `wheel_margins`
                ORDER BY
                `wheel_margins`.`type` DESC
            ');

            /*
             *   4,2,1 - поставщик
                 4,2,1,1- поставщик+типоразмер
                 4,2,2- типоразмер
                 4,2,3- Бренду
                 4,2,4- Бренду+модель
                 4,2,5 Бренду+модель+типоразмер
                 4,2,6 поставщик+ Бренду+ модель+ типоразмер*/

            self::$marginItems = $marginItems;
        } else {
            $marginItems = self::$marginItems;
        }
        $template = array(
            'manufacturer_id',
            'model_id',
            'city_id',
            'company_id',
            'season',
            'size_w',
            'size_h',
            'size_r'
        );

        $total = $totalWholesale;

        foreach ( $marginItems as $marginItem ) {
            $attributeRule = (object)array(
                'rule' => null,
                'item' => null,
                'ruleValues' => array(),
                'itemValues' => array(),
                'attributes' => array()
            );
            foreach ( $marginItem->attributes() as $attribute => $value ) {
                if ( !empty($value) ) {
                    if ( $value > 0 ) {
                        if ( in_array($attribute, $template) && array_key_exists($attribute, $item->attributes()) ) {
                            $attributeRule->ruleValues[] = $value;
                            $attributeRule->itemValues[] = $item->$attribute;
                            $attributeRule->attributes[] = $attribute;
                        }
                    }
                }
            }
            $attributeRule->rule = implode(':',$attributeRule->ruleValues);
            $attributeRule->item = implode(':',$attributeRule->itemValues);

            if ( $marginItem->type == self::RETAIL ) {
                $total = (!empty($totalRetail) && $totalRetail > $totalWholesale) ? $totalRetail : $totalWholesale;
            }
            if ( $marginItem->type == self::WHOLESALE ) {
                $total = $totalWholesale;
            }

            if ( $attributeRule->rule == $attributeRule->item ) {
                if ( $marginItem->percentage > 0 ) {
                    $percentage = (($total/100) * $marginItem->percentage);
                    $totalTmp = $total + $percentage;
                    if ( $marginItem->not_more > 0 ) {
                        if ( $percentage <= $marginItem->not_more && $percentage >= $marginItem->not_less ) {
                            $total = $totalTmp;
                        } else {
                            if ( $percentage > $marginItem->not_more ) {
                                $total = $total + $marginItem->not_more;
                            }
                            if ( $percentage < $marginItem->not_less ) {
                                $total = $total + $marginItem->not_less;
                            }
                        }
                    } else {
                        $total = $totalTmp;
                    }
                }
                if ( $marginItem->fixed_cost > 0 ) {
                    $totalTmp = $total + $marginItem->fixed_cost;
                    if ( $marginItem->not_more > 0 ) {
                        if ( $marginItem->fixed_cost <= $marginItem->not_more && $marginItem->fixed_cost >= $marginItem->not_less ) {
                            $total = $totalTmp;
                        } else {
                            if ( $marginItem->fixed_cost > $marginItem->not_more ) {
                                $total = $total + $marginItem->not_more;
                            }
                            if ( $marginItem->fixed_cost < $marginItem->not_less ) {
                                $total = $total + $marginItem->not_less;
                            }
                        }
                    } else {
                        $total = $totalTmp;
                    }
                }
                $total = $total + $marginItem->shipping + $marginItem->transfer + $marginItem->bank;
                if ( $marginItem->type == self::RETAIL ) {
                    $totalRetail = $total;
                }
                if ( $marginItem->type == self::WHOLESALE ) {
                    $totalWholesale = $total;
                    if ( $totalRetail < $totalWholesale ) {
                        $totalRetail = $totalWholesale;
                    }
                }
            }
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