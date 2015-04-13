<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 04.04.15
 * Time: 17:50
 * To change this template use File | Settings | File Templates.
 */
class PayOnline
{
    const LIQPAY = 'LiqPay';
    const LIQPAY_PUB = 'i42003954328';
    const LIQPAY_PRT = 'tpYKt4sw08xpMC0mibz7KtJ1WE6ENZrfoYU0SVZY';
    private $paymentInstance = null;

    public function makePayment($paymentSystem, $invoice, $card)
    {
        $payment = new PayOnline();
        if ($payment->initPaymentInstance($paymentSystem)) {
            return $payment->{'pay'.$paymentSystem}($invoice, $card);
        }
        return false;
    }

    public function makePaymentFormData($paymentSystem, $invoice, $card)
    {
        $payment = new PayOnline();
        if ($payment->initPaymentInstance($paymentSystem)) {
            return $payment->{'pay'.$paymentSystem.'Sign'}($invoice, $card);
        }
        return false;
    }

    public static function confirmPayment($paymentSystem, $invoice, $card)
    {
        $payment = new PayOnline();
        if ($payment->initPaymentInstance($paymentSystem)) {
            $payment->{'confirm'.$paymentSystem}($invoice, $card);
        }
    }

    public function initPaymentInstance($paymentSystem)
    {
        $payDriversPath = __DIR__ . DIRECTORY_SEPARATOR . 'drivers' . DIRECTORY_SEPARATOR;
        if ( is_file($payDriversPath . $paymentSystem . '.php') ) {
            include_once($payDriversPath . $paymentSystem . '.php');
            switch ($paymentSystem) {
                case self::LIQPAY:
                    $this->paymentInstance = new $paymentSystem(self::LIQPAY_PUB, self::LIQPAY_PRT);
                    break;
            }
            return true;
        }
        return false;
    }

    private function payLiqPaySign($invoice, $card)
    {
        $signature = $this->paymentInstance->cnb_form_data(array(
            'version'        => '3',
            'amount'         => $invoice->price,
            'currency'       => 'UAH',
            'description'    => $invoice->title,
            'order_id'       => $invoice->id,
            'sandbox'        => '1',
            'server_url'     => 'http://release.pp.ua/?view=api&load=paymentcenter&fnc=payVerify',
            'result_url'     => 'http://release.pp.ua/?load=home',
            'pay_way'        => 'card',
            'language'       => 'ru'
        ));
        $invoice->token = $signature['signature'];
        $invoice->save();
        return $signature;
    }

    private function payLiqPaySignVerify($post)
    {
        /*$data = $post['data'];
        $signature = $post['signature'];*/
        //$signature = $this->paymentInstance->str_to_sign($data);
        /*$signature = $this->paymentInstance->cnb_form_data(array(
            'version'        => '3',
            'amount'         => $invoice->price,
            'currency'       => 'UAH',
            'description'    => $invoice->title,
            'order_id'       => $invoice->id,
            'sandbox'        => '1',
            'server_url'     => 'For callback answer',
            'result_url'     => 'For UI redirect',
            'pay_way'        => 'card',
            'language'       => 'ru'
        ));
        return $signature;*/
    }

    private function confirmLiqPay($invoice, $card)
    {
        $result = $this->paymentInstance->api("payment/verify", array(
            'version' => '3',
            'token'   => $invoice->token,
            'otp'     => $card['sms_pass']
        ));

        switch ( $result->status ) {
            case '3ds_verify':
                $invoice->status = Invoice::STATUS_VERIFY;
                $invoice->save();
                return true;
                break;
            case 'success':
                $invoice->status = Invoice::STATUS_PAID;
                $invoice->save();
                return true;
                break;
        }
        return false;
    }
}
