<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 04.04.15
 * Time: 16:54
 * To change this template use File | Settings | File Templates.
 */
class Content extends ActiveRecord\Model
{
    const TEXT = 4;
    const BANNER = 3;
    const PAGE = 2;
    const SYSTEM_PAGE = 1;
    const DEF_KEY = 'default';

    public static $table_name = 'wheel_content';

    public function getText($_sku = null)
    {
        $model = null;
        if ( $_sku != null ) {
            $model = self::find(array('conditions' => array('type = ? AND sku = ?', self::TEXT, $_sku)));
        }
        return (empty($model)) ? null : $model->content;
    }

    public static function pageContent()
    {
        $_sys = App::_sys();
        $model = self::find(array('conditions' => array('sys_controller = ? AND sys_loader = ? AND type = ?', $_sys->controller, $_sys->loader, self::SYSTEM_PAGE)));
        return (!empty($model)) ? $model : new Content();
    }

    public static function pageBanner()
    {
        $_sys = App::_sys();
        $model = self::find(array('conditions' => array('sys_controller = ? AND sys_loader = ? AND type = ?', $_sys->controller, $_sys->loader, self::BANNER)));
        if (!empty($model)) {
            return $model;
        }
        $model = self::find(array('conditions' => array('sys_controller = ? AND sys_loader = ? AND type = ?', 'index', self::DEF_KEY, self::BANNER)));
        return (!empty($model)) ? $model : new Content();
    }
}