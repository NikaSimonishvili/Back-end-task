<?php

namespace App\services;

use App\Enums\OperationType;
use App\Enums\UserType;
use App\services\Deposits\Deposit;
use App\services\Withdrawals\BusinessClientWithdrawal;
use App\services\Withdrawals\PrivateClientWithdrawal;

class CommissionFeeFactory
{
    public static function getOperationType($operationType, $userType)
    {
        return match ($operationType) {
            OperationType::WITHDRAW->value => match ($userType) {
                UserType::PRIVATE->value => new PrivateClientWithdrawal(),
                UserType::BUSINESS->value => new BusinessClientWithdrawal()
            },
            OperationType::DEPOSIT->value => new Deposit()
        };
    }
}
