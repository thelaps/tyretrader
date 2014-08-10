<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class analitycs extends controller{

    public function render(){

        $this->viewData['formData'] = Manufacturer::getManufacturerAndModelByType();
        $this->viewData['class'] = $this;
        return 'container/analitycs.tpl';
    }
}