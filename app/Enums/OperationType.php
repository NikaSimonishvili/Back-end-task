<?php

namespace App\Enums;

enum OperationType: string
{
    case WITHDRAW = 'withdraw';
    case DEPOSIT = 'deposit';
}
