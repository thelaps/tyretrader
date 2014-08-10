<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class customer extends controller{

    public $errors = array();

    public $profiler = null;

    public function render(){
        $get = $this->getRequest('get');

        if (isset($get['company_id'])) {
            $this->viewData = $this->getCompany($get['company_id']);
        }

        return 'container/api/company.tpl';
    }

    private function getCompany($company)
    {
        return Company::getCompanyById($company);
    }
}