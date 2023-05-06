<?php

namespace App\Actions;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class SetCurrenciesAction
{
    public static function handle(): void
    {
        $rates = Http::get(config('currencies.url'))->json();

        Config::set('currencies.currencies.USD', $rates['rates']['USD']);
        Config::set('currencies.currencies.JPY', $rates['rates']['JPY']);
        Config::set('currencies.currencies.EUR', $rates['rates']['EUR']);
    }
}
