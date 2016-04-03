<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class datalist extends controller{

    public $errors = array();

    public $profiler = null;

    public function render(){
        $post = $this->getRequest('post');

        $completeData = null;
        $action = null;
        if(isset($post['fnc'])){
            $action = $post['fnc'];
            switch ($post['fnc']){
                case 'models':
                    $completeData = $this->getModels($post);
                    break;
                case 'cities':
                    $completeData = $this->getCities($post);
                    break;
            }
        }

        $response = array(
            'action' => $action,
            'completeData' => $this->arrayAttributes($completeData, $action),
            'errors' => (isset($completeData->errors))?$completeData->errors->full_array():$this->errors
        );
        App::ajax(json_encode($response));
    }

    private function getModels($post)
    {
        if ( !empty($post['id']) ) {
           return  ManufacturerItems::all(array('conditions' => array('manufacturer_id = ?', $post['id']), 'order' => 'name asc'));
        }
        return array();
    }

    private function getCities($post)
    {
        if ( !empty($post['id']) ) {
           return  City::all(array('conditions' => array('capital_id = ?', $post['id']), 'order' => 'name asc'));
        }
        return array();
    }

    private function arrayAttributes($items)
    {
        $obj = new stdClass();
        $obj->items = array();
        $obj->total = 0;
        if ( sizeof($items) > 0 ) {
            $optItemsAttributes = array();
            foreach ( $items as $item ) {
                $optItemsAttributes[] = $item->attributes();
            }
            $obj->items = $optItemsAttributes;//$this->setIds($optItemsAttributes);
            $obj->total = sizeof($items);
        }
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