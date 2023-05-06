<?php

namespace App\services\Withdrawals;

use App\Actions\ChargePercentageAction;
use App\Interfaces\WithdrawInterface;

class BusinessClientWithdrawal implements WithdrawInterface
{
    public static function handleWithdraw($userInteractions)
    {
        $fee = $userInteractions['amount'] * (0.5 / 100);

        return number_format((float)$fee, 2, '.', '');
    }
}
