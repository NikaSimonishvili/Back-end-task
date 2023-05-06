<?php

namespace App\Actions;

class ExchangeCurrency
{
    public static function handle($amount, $from, $to)
    {
        if ($from == $to) {
            return $amount;
        }

        $rate = config('currencies.currencies.' . $to) / config('currencies.currencies.' . $from);

        return round($amount * $rate, 2);
    }
}
