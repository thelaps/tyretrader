<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 16.02.13
 * Time: 15:29
 * To change this template use File | Settings | File Templates.
 */
Abstract Class datamodel extends connector{
    public $datamodel;
    abstract function commit();
}