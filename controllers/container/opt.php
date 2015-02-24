<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class opt extends controller{

    public function render(){
        $this->viewData['opt'] = null;//Price::getOptItems();
        $this->viewData['formData'] = Manufacturer::getManufacturerAndModelByType();
        $this->viewData['formData']->cities = City::getCapitals();
        $companies = Company::getCompanies();
        $this->viewData['formData']->companies = $companies->items;
        $this->viewData['class'] = $this;
        return 'container/opt.tpl';
    }
}