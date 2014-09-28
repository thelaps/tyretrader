<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class calculator extends controller{

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
                case 'addMargin':
                    $completeData = $this->addMarginItems($post);
                    break;
                case 'edit':
                    //$completeData = $this->getCompanies();
                    break;
                case 'deleteMargin':
                    $completeData = $this->deleteMarginItems($post['calculator']['id']);
                    break;
                case 'get':
                    $completeData = $this->getMarginItemById($post['calculator']['id']);
            }
            //App::ajax(json_encode($response));
        }
        $response = array(
            'action' => $action,
            'completeData' => ($action != 'get') ? $this->arrayAttributes($this->getMarginItems(),$action) : $this->arrayAttributes($completeData, $action),
            'errors' => (isset($completeData->errors))?$completeData->errors->full_array():$this->errors
        );
        App::ajax(json_encode($response));
    }

    public function addMarginItems($post = null) {
        if (isset($post)) {
            return Margin::addMarginItem($post);
        }
        return null;
    }

    public function getMarginItems() {
        return Margin::getMarginItems();
    }

    public function getMarginItemById($id) {
        return Margin::getMarginItemById($id);
    }

    public function deleteMarginItems($id) {
        return Margin::deleteMarginItems($id);
    }

    private function arrayAttributes($items, $action)
    {
        $itemsAttributes = array();
        foreach ( $items->items as $item ) {
            $itemsAttributes[] = $item->attributes();
        }
        $obj = new stdClass();
        $obj->items = ($action != 'get') ? $this->setIds($itemsAttributes) : $itemsAttributes;
        $obj->total = ($items->total)?$items->total:0;
        $obj->filter = null;
        return $obj;
    }

    private function setIds($items)
    {
        $groupedItems = array();
        foreach ($items as $item) {
            $groupedItems[$item['id']] = $item;
        }
        return $groupedItems;
    }
}