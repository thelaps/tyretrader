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
                case 'getFormBalance':
                    $completeData = $this->getFormBalance();
                    break;
            }
            //App::ajax(json_encode($response));
        } elseif (isset($get['fnc'])) {
            $action = $get['fnc'];
            switch ($get['fnc']) {
                case 'payVerify':
                    $completeData = $this->payVerify();
                    break;
            }
        }
        $response = array(
            'action' => $action,
            'completeData' => (!empty($completeData)) ? (($post['fnc'] != 'getFormBalance') ? $completeData->attributes() : $completeData) : null,
            'errors' => (isset($completeData->errors))?((is_array($completeData->errors)) ? $completeData->errors : $completeData->errors->full_array()):$this->errors
        );
        App::ajax(json_encode($response));
    }

    public function getFormBalance()
    {
        $post = $this->getRequest('post');
        if ( $this->profiler->isLoggedIn() ) {
            $user = $this->profiler->user;
            $invoice = Invoice::createNew(Invoice::TYPE_BALANCE, $user->id, $post['payment']['phone'], $post['payment']['amount']);
            $PayOnline=App::newJump('PayOnline','libs');
            return $PayOnline->makePaymentFormData(PayOnline::LIQPAY, $invoice, $post['payment']);
        }
        return false;
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

    public function payVerify()
    {
        $post = $this->getRequest('post');

        $PayOnline=App::newJump('PayOnline','libs');

        $post = $this->getRequest('post');
        $get = $this->getRequest('get');
        mail('rimmerz@gmail.com', 'LiqAnswerPost1', $post['data']);
        mail('rimmerz@gmail.com', 'LiqAnswerPost2', $post['signature']);
    }
}