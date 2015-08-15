<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 11.12.13
 * Time: 23:25
 * To change this template use File | Settings | File Templates.
 */
class CurrencyRate extends ActiveRecord\Model
{
    const ISO_UAH = 'UAH';
    const ISO_EUR = 'EUR';
    const ISO_USD = 'USD';
    const ISO_RUB = 'RUB';
    const ISO_GBP = 'GBP';

    public static $table_name = 'wheel_currencyRate';


}