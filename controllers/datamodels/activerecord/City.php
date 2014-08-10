<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 11.12.13
 * Time: 23:25
 * To change this template use File | Settings | File Templates.
 */
class City extends ActiveRecord\Model
{
    public static $table_name = 'wheel_city';

    static $belongs_to = array(
        array('region', 'readonly' => true)
    );

    public static function getWithRegions()
    {
        $withRegions = array();
        $cities = City::all();

        foreach ( $cities as $city ) {
            $withRegions[$city->region->id]['cities'][] = $city;
            $withRegions[$city->region->id]['region'] = $city->region;
        }
        return $withRegions;
    }

    public static function getCapitals()
    {
        $model = new City;
        $capitals = $model->find_by_sql('SELECT * FROM `wheel_city`
            WHERE `wheel_city`.`capital_id` IS NOT NULL
            ORDER BY `wheel_city`.`name`');
        return $capitals;
    }

    public static function getRegionId($cityId)
    {
        $model = new City;
        $city = $model->find(array('conditions' => array('id = ?', $cityId)));
        if ( $city ) {
            return $city->region_id;
        }
        return null;
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