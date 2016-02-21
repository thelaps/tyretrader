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
                case 'buyPackage':
                    $completeData = $this->payPackage();
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
            'completeData' => (!empty($completeData)) ? (($action != 'getFormBalance') ? $completeData->attributes() : $completeData) : null,
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

    public function payPackage()
    {
        $post = $this->getRequest('post');
        if ( $this->profiler->isLoggedIn() ) {
            $package = Package::find($post['id']);
            if ( $package ) {
                $user = $this->profiler->user;
                $invoice = Invoice::createNew(Invoice::TYPE_PACKAGE, $user->id, null, $package->cost * (($package->amount > 0) ? $package->amount : 1));
                $invoiceItem = Invoiceitem::createNew($invoice->id, 'Пакет услуг: ' . $package->title, $package->amount, $package->cost, $invoice->price);
                if ( $invoice->completePayment() ) {
                    switch ($package->sku) {
                        case 'company-prolongation':
                            $company = $user->getCompany(false);
                            if ( $company ) {
                                if ( strtotime($company->expire->format('Y-m-d H:i:s')) >= time() ) {
                                    $company->expire = date('Y-m-d H:i:s', strtotime($company->expire->format('Y-m-d H:i:s') . ' +'.$package->amount.' month'));
                                } else {
                                    $company->expire = date('Y-m-d H:i:s', strtotime('+'.$package->amount.' month'));
                                }
                                $company->active = Company::STATUS_ACTIVE;
                                $company->save();
                            }
                            break;
                    }
                    return $invoice;
                } else {
                    if ($user->balance < $invoice->price) {
                        $this->errors[] = array('message' => 'У Вас недостаточно средств на счету!');
                    }
                }
                return false;
            }
        }
        return false;
    }

    public function payVerify()
    {
        $post = $this->getRequest('post');
        $PayOnline=App::newJump('PayOnline','libs');

        $invoice = $PayOnline->confirmPayment(PayOnline::LIQPAY, $post);

        App::helper()->sendMail('paymentVerify', 'rimmerz@gmail.com', 'Верификация: '.md5($invoice->id), array('invoice' => $invoice, 'post' => $post));
        if ( !empty($invoice) ) {
            if ( $invoice->status == Invoice::STATUS_PAID ) {
                $invoice->completePayment();
            }
        }

        return $invoice;
    }
}