<?php

namespace App\services\Deposits;

use App\Actions\ChargePercentageAction;
use App\Interfaces\DepositInterface;

class Deposit implements DepositInterface
{
    public static function handleDeposit($userInteractions)
    {
        $fee = $userInteractions['amount'] * (config('fees.deposit') / 100);

        return number_format((float)$fee, 2, '.', '');
    }
}
