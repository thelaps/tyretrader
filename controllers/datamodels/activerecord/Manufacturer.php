<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 11.12.13
 * Time: 23:25
 * To change this template use File | Settings | File Templates.
 */
class Manufacturer extends ActiveRecord\Model
{
    public static $table_name = 'wheel_manufacturers';

    public static function getManufacturerAndModelByType()
    {
        $dataSorted = array();
        $model = new Manufacturer();
        $data = $model->manufacturerAndModelByType();

        $obj = new stdClass();
        $obj->model = array();
        $obj->manufacturer = array();
        foreach ( $data as $row) {
            switch($row->manufacturer_type){
                case 1:
                    $row->manufacturer_type = 'tyre';
                    break;
                case 2:
                    $row->manufacturer_type = 'wheel';
                    break;
                default:
                    $row->manufacturer_type = NULL;
                    break;
            }
            $joinedRule = self::joinRule($row->type_transport);
            $obj->manufacturer[$joinedRule][$row->manufacturer_id] = $row;
            //$obj->manufacturerModel[$row->type_transport][$row->manufacturer_id][$row->model_id] = $row;
            $obj->model[$joinedRule][$row->model_id] = $row;
        }
        return $obj;
    }

    public static function getManufacturerAndModel()
    {
        $dataSorted = array();
        $model = new Manufacturer();
        $data = $model->manufacturerAndModelByType();

        $obj = new stdClass();
        $obj->model = array();
        $obj->manufacturer = array();
        foreach ( $data as $row) {
            switch($row->manufacturer_type){
                case 1:
                    $row->manufacturer_type = 'tyre';
                    break;
                case 2:
                    $row->manufacturer_type = 'wheel';
                    break;
                default:
                    $row->manufacturer_type = NULL;
                    break;
            }
            $obj->manufacturer[$row->manufacturer_id] = $row;
            $obj->model[$row->model_id] = $row;
        }
        return $obj;
    }

    private static function joinRule($type_transport)
    {
        switch( $type_transport ) {
            case 1:
                return 1;
                break;
            case 2:
                return 1;
                break;
            case 3:
                return 3;
                break;
            case 4:
                return 3;
                break;
            default:
                return $type_transport;
                break;
        }
    }

    public function manufacturerAndModelByType()
    {
        return $this->find_by_sql('
            SELECT `wheel_manufacturers`.`id` AS manufacturer_id,
            `wheel_manufacturers`.`name` AS manufacturer_name,
            `wheel_models`.`id` AS model_id,
            `wheel_models`.`name` AS model_name,
            `wheel_models`.`type_transport`,
            `wheel_manufacturers2type`.`type` AS manufacturer_type,
            `wheel_manufacturers2type`.`wheel_type`
            FROM (`wheel_manufacturers`
            LEFT JOIN `wheel_models`
            ON `wheel_models`.`manufacturer_id`=`wheel_manufacturers`.`id`)
            LEFT JOIN `wheel_manufacturers2type` ON `wheel_manufacturers2type`.`manufacturer_id`=`wheel_manufacturers`.`id`
            ORDER BY `wheel_manufacturers`.`name` ASC, `wheel_models`.`name` ASC');
    }
    /*// order belongs to a person
    static $belongs_to = array(
        array('person'));*/

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