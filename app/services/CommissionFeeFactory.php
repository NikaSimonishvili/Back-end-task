<?php

namespace App\services;

use App\Enums\OperationType;
use App\Enums\UserType;
use App\services\Deposits\Deposit;
use App\services\Withdrawals\BusinessClientWithdrawal;
use App\services\Withdrawals\PrivateClientWithdrawal;

class CommissionFeeFactory
{
    public static function getOperationType($userInteractions)
    {
        return match ($userInteractions['operationType']) {
            OperationType::WITHDRAW->value => match ($userInteractions['userType']) {
                UserType::PRIVATE->value => PrivateClientWithdrawal::handleWithdraw($userInteractions),
                UserType::BUSINESS->value => BusinessClientWithdrawal::handleWithdraw($userInteractions)
            },
            OperationType::DEPOSIT->value => Deposit::handleDeposit($userInteractions)
        };
    }
}
