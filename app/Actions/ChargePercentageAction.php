<?php

namespace App\Actions;

class ChargePercentageAction
{
    public static function handle($amount, $percentage)
    {
        $fee = $amount * ($percentage / 100);

        return (number_format($amount - $fee, 2, '.', ''));
    }
}
