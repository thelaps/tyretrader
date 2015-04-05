<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alice
 * Date: 10.10.12
 * Time: 2:25
 * To change this template use File | Settings | File Templates.
 */
class paymentcenter extends controller{

    public $errors = array();

    public $profiler = null;

    public function render(){
        $post = $this->getRequest('post');
        $get = $this->getRequest('get');

        $completeData = null;
        $action = null;
        if(isset($post['fnc'])){
            $action = $post['fnc'];
            switch ($post['fnc']){
                case 'payBallance':
                    $completeData = $this->payBalance();
                    break;
            }
            //App::ajax(json_encode($response));
        }
        $response = array(
            'action' => $action,
            'completeData' => (!empty($completeData)) ? $completeData->attributes() : null,
            'errors' => (isset($completeData->errors))?((is_array($completeData->errors)) ? $completeData->errors : $completeData->errors->full_array()):$this->errors
        );
        App::ajax(json_encode($response));
    }

    public function payBalance()
    {
        $post = $this->getRequest('post');
        if ( $this->profiler->isLoggedIn() ) {
            $user = $this->profiler->user;
            $invoice = Invoice::createNew(Invoice::TYPE_BALANCE, $user->id, $post['payment']['phone'], $post['payment']['amount']);
            $PayOnline=App::newJump('PayOnline','libs');
            $PayOnline->makePayment(PayOnline::LIQPAY, $invoice, $post['payment']);
            return $invoice;
        }
        return false;
    }
}