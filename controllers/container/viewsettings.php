<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class viewsettings extends controller{

    public function render(){

        /*$this->viewData['formData'] = Manufacturer::getManufacturerAndModel();
        $this->viewData['formData']->cities = City::getCapitals();
        $companies = Company::getCompanies();
        $this->viewData['formData']->companies = $companies->items;
        $this->viewData['listItems'] = $this->getMarginItems();*/
        $this->viewData['class'] = $this;
        return 'container/viewsettings.tpl';
    }
}