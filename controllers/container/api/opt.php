<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class opt extends controller{

    public $errors = array();

    public $profiler = null;

    public function render(){
        $get = $this->getRequest('get');
        $post = $this->getRequest('post');

        $completeData = null;
        $action = null;
        if(isset($post['fnc'])){
            $action = $post['fnc'];
            switch ($post['fnc']){
                case 'opt':
                    $completeData = $this->getOptItems($post);
                    break;
                case 'company':
                    $completeData = $this->getCompanies();
                    break;
                case 'xlsCatalog':
                    $completeData = $this->getXlsCatalog($post);
                    break;
                case 'priceExport':
                    $completeData = $this->getPriceCatalog($post);
                    break;
                case 'analitycs':
                    $completeData = $this->getAnalitycsScope($post);
                    break;
            }
            //App::ajax(json_encode($response));
        }
        $response = array(
            'action' => $action,
            'completeData' => (!in_array($action, array('xlsCatalog', 'priceExport'))) ? $this->arrayAttributes($completeData, $action) : $completeData,
            'errors' => (isset($completeData->errors))?$completeData->errors->full_array():$this->errors
        );
        App::ajax(json_encode($response));
    }

    private function arrayAttributes($optItems, $action)
    {
        $optItemsAttributes = array();
        foreach ( $optItems->items as $item ) {
            $optItemsAttributes[] = $item->attributes();
        }
        $obj = new stdClass();
        $obj->items = ($action == 'opt')?$this->groupByScope($optItemsAttributes):$this->setIds($optItemsAttributes);
        $obj->total = $optItems->total;
        $obj->filter = ($optItems->filter)?$optItems->filter:null;
        return $obj;
    }

    private function groupByScope($items)
    {
        $groupedItems = array();
        foreach ($items as $item) {
            $groupedItems[md5($item['scopename'])][] = $item;
        }
        return $groupedItems;
    }

    private function setIds($items)
    {
        $groupedItems = array();
        foreach ($items as $item) {
            $groupedItems[$item['id']] = $item;
        }
        return $groupedItems;
    }

    private function getXlsCatalog($post = null)
    {
        if ( $this->profiler->isLoggedIn() ) {
            $user = $this->profiler->user;

            $company = Company::getCompanyById($user->companyid);

            $oWordReader=App::newJump('phpwordlayer','libs');

            $oWordReader->setFilename(ROOT_DIR.'files/price/');

            try{
                $compiledStruct = array();

                $priceData = $this->getOptItems($post);

                foreach ($priceData->items as $priceItem) {
                    $compiledStruct[$company->items->id][] = array(
                        'company' => $company,
                        'item' => $priceItem
                    );
                }

                return $oWordReader->createDoc($compiledStruct, $post['catalogAmounts']);
            }catch(Exception $e){
                return null;
            }
        }
    }

    private function getPriceCatalog($post = null)
    {
        $oExelReader=App::newJump('phpexel','libs');

        $oExelReader->setFilename(ROOT_DIR.'files/price/');

        try{
            $priceData = $this->getAllItems($post);

            return $oExelReader->createXlsx($priceData, $post);
        }catch(Exception $e){
            return null;
        }
    }

    private function getOptItems($post = null)
    {
        return Price::getOptItems($post);
    }

    private function getAnalitycsScope($post = null)
    {
        if ( $this->profiler->isLoggedIn() ) {
            $company = $this->profiler->company->items;
            return Price::getAnalitycsScope($post, $company);
        }
        return null;
    }


    private function getAllItems($post = null)
    {
        return Price::getAllItems($post);
    }

    private function getCompanies()
    {
        return Company::getCompanies();
    }
}