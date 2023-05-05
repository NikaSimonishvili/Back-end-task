<?php

namespace App\services\Deposits;

use App\Actions\ChargePercentageAction;
use App\Interfaces\DepositInterface;

class Deposit implements DepositInterface
{
    public static function handleDeposit($userInteractions)
    {
        return ChargePercentageAction::handle($userInteractions['amount'], 0.03);
    }
}
