<?php

namespace App\Actions;

class ChargePercentageAction
{
    public static function handle($amount, $percentage)
    {
        $feePercentage = $percentage;
        $fee = $amount * ($feePercentage / 100);

        return (number_format($amount - $fee, 2, '.', ''));
    }
}
