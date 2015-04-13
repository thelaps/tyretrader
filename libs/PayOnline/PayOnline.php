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

    public static function confirmPayment($paymentSystem, $data)
    {
        $payment = new PayOnline();
        if ($payment->initPaymentInstance($paymentSystem)) {
            return $payment->{'confirm'.$paymentSystem}($data);
        }
        return false;
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

    private function confirmLiqPay($data)
    {
        if ( $data['signature'] == base64_encode(sha1( self::LIQPAY_PRT . $data['data'] . self::LIQPAY_PRT, 1)) ) {
            $result = json_decode(base64_decode($data['data']));
            $invoice = Invoice::find($result->order_id);
            if ( !empty($invoice) && $invoice->status != Invoice::STATUS_CLOSED ) {
                switch ( $result->status ) {
                    case 'processing':
                        $invoice->status = Invoice::STATUS_PENDING;
                        $invoice->save();
                        break;
                    case 'failure':
                        $invoice->status = Invoice::STATUS_FAILED;
                        $invoice->save();
                        break;
                    case 'sandbox':
                        $invoice->status = Invoice::STATUS_PAID;
                        $invoice->save();
                        break;
                    case 'sandbox':
                        $invoice->status = Invoice::STATUS_PAID;
                        $invoice->save();
                        break;
                    case 'success':
                        $invoice->status = Invoice::STATUS_PAID;
                        $invoice->save();
                        break;
                    case 'wait_secure':
                        $invoice->status = Invoice::STATUS_VERIFY;
                        $invoice->save();
                        break;
                    case 'wait_accept':
                        $invoice->status = Invoice::STATUS_VERIFY;
                        $invoice->save();
                        break;
                }
                return $invoice;
            }
        }
        return false;
    }
}
