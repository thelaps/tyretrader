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
    const LIQPAY_PUB = 'i45972314943';
    const LIQPAY_PRT = 'SJ0EG00shPzFFFEohhHZsj6QzhyC90afmjxS3buD';
    private $paymentInstance = null;

    public function makePayment($paymentSystem, $invoice, $card)
    {
        $payment = new PayOnline();
        if ($payment->initPaymentInstance($paymentSystem)) {
            return $payment->{'pay'.$paymentSystem}($invoice, $card);
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

    private function payLiqPay($invoice, $card)
    {
        try {
        $result = $this->paymentInstance->api("payment/pay", array(
            'version'        => '3',
            'phone'          => $invoice->phone,
            'amount'         => $invoice->price,
            'currency'       => 'UAH',
            'description'    => $invoice->title,
            'order_id'       => $invoice->id,
            'card'           => $card['card_num'],
            'card_exp_month' => $card['card_exp_month'],
            'card_exp_year'  => $card['card_exp_year'],
            'card_cvv'       => $card['card_cvv'],
            'sandbox'       => 1,
        ));
print_r(array($result));
        if ( $result->status == 'otp_verify' ) {
            $invoice->token = $result->token;
            $invoice->status = Invoice::STATUS_PENDING;
            $invoice->save();
            return true;
        }
        } catch (Exception $e) {
            print_r($e);die;
        }
        return false;
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
