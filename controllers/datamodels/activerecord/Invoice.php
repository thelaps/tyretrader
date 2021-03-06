<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 04.04.15
 * Time: 16:54
 * To change this template use File | Settings | File Templates.
 */
class Invoice extends ActiveRecord\Model
{
    const STATUS_UNPAID = 0;
    const STATUS_PENDING = 1;
    const STATUS_VERIFY = 2;
    const STATUS_PAID = 3;
    const STATUS_FAILED = 4;
    const STATUS_CLOSED = 5;
    const TYPE_BALANCE = 0;
    const TYPE_PACKAGE = 1;

    public static $table_name = 'wheel_invoice';

    static $has_many = array(
        array('invoiceitem', 'readonly' => false, 'order' => 'name asc',)
    );
    static $belongs_to = array(
        array('user', 'readonly' => false)
    );

    public function getExpirationIntervals()
    {
        $expirations = new stdClass();
        for ($month = 1; $month < 13; $month++) {
            $expirations->months[] = ($month < 10) ? '0' . $month : $month;
        }
        $currentYear = date('y');
        for ($year = $currentYear; $year < $currentYear + 5; $year++) {
            $expirations->years[] = $year;
        }
        return $expirations;
    }

    public static function createNew($type, $userId, $phone, $amount = 0)
    {
        $invoice = new Invoice();
        $invoice->type = $type;
        $invoice->title = $invoice->getTitleByType($type);
        $invoice->status = self::STATUS_UNPAID;
        $invoice->price = $amount;
        $invoice->datecreate = date('Y-m-d H:i:s');
        $invoice->user_id = $userId;
        $invoice->phone = $phone;
        $invoice->save();
        return $invoice;
    }

    public function getTitleByType($type)
    {
        $titles = array(
            'Account Balance',
            'Package Revenue'
        );
        return (isset($titles[$type])) ? $titles[$type] : 'Unknown Payment';
    }

    public function completePayment()
    {
        if ( $this->status != self::STATUS_CLOSED ) {
            switch ($this->type) {
                case self::TYPE_BALANCE:
                    return $this->userBalanceIncrease();
                    break;
                case self::TYPE_PACKAGE:
                    return $this->userBalanceDecrease();
                    break;
            }
        }
        return false;
    }

    private function userBalanceDecrease()
    {
        if ( $this->user->balance >=  $this->price) {
            $this->user->balance = $this->user->balance - $this->price;
            if ( $this->user->save() ) {
                $this->status = self::STATUS_CLOSED;
                $this->save();
                return true;
            }
        }
        return false;
    }

    private function userBalanceIncrease()
    {
        $this->user->balance = $this->user->balance + $this->price;
        if ( $this->user->save() ) {
            $this->status = self::STATUS_CLOSED;
            $this->save();
            return true;
        }
        return false;
    }
}