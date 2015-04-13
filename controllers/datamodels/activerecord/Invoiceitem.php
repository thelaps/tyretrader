<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 04.04.15
 * Time: 16:54
 * To change this template use File | Settings | File Templates.
 */
class Invoiceitem extends ActiveRecord\Model
{
    public static $table_name = 'wheel_invoiceitem';

    public static function createNew($invoiceId, $name, $amount = 1, $cost = 0, $price = 0)
    {
        $invoiceItem = new Invoiceitem();
        $invoiceItem->invoice_id = $invoiceId;
        $invoiceItem->name = $name;
        $invoiceItem->amount = $amount;
        $invoiceItem->cost = $cost;
        $invoiceItem->price = $price;
        $invoiceItem->save();
        return $invoiceItem;
    }
}