<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class user extends controller{

    public function render(){
        $this->viewData['checkWork']='okay';

        return 'user.tpl';
    }
}