<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:22
 * To change this template use File | Settings | File Templates.
 */
Abstract Class controller extends connector{
    public $viewData;
    abstract function render();

    public function whatSeason($id)
    {
        $y = date('Y');
        $from = strtotime(($y-1).'-10-01');
        $fromc = strtotime($y.'-10-01');
        $to = strtotime($y.'-02-01');
        $ton = strtotime(($y+1).'-02-01');
        $now = strtotime(date('Y-m-d'));

        $winter = array('1');
        $summer = array('2');

        if ($now >= $from && $now <= $to) {
            return in_array($id,$winter);
        } elseif ($now >= $to && $now <= $fromc) {
            return in_array($id,$summer);
        }
    }
}