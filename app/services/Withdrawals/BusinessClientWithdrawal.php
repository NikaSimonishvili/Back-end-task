<?php

namespace App\services\Withdrawals;

use App\Actions\ChargePercentageAction;
use App\Interfaces\WithdrawInterface;

class BusinessClientWithdrawal implements WithdrawInterface
{
    public static function handleWithdraw($userInteractions)
    {
       return ChargePercentageAction::handle($userInteractions['amount'], 0.5);
    }
}
