<?php

namespace App\services\Withdrawals;

use App\Actions\ChargePercentageAction;
use App\Actions\ExchangeCurrency;
use App\Interfaces\WithdrawInterface;
use Carbon\Carbon;

class PrivateClientWithdrawal implements WithdrawInterface
{
    protected static array $withdrawalsThisWeek = [];
    protected static array $totalWithdrawalsThisWeek = [];

    public static function handleWithdraw($userInteractions)
    {
        $transactionCurrency = $userInteractions['operationCurrency'];

        // check if currency is not EUR and if not exchange it
        $userInteractions['amount'] = ExchangeCurrency::handle(
            $userInteractions['amount'],
            $transactionCurrency,
            'EUR'
        );

        // Get the start and end date of the week
        $startDate = Carbon::parse($userInteractions['operationDate'])->startOfWeek();
        $endDate = Carbon::parse($userInteractions['operationDate'])->endOfWeek();

        // Check if the user's withdrawals array exists, and create it if it doesn't
        if (!isset(self::$withdrawalsThisWeek[$userInteractions['userId']])) {
            self::$withdrawalsThisWeek[$userInteractions['userId']] = [];
        }

        // Check if the user's total withdrawals array exists, and create it if it doesn't
        if (!isset(self::$totalWithdrawalsThisWeek[$userInteractions['userId']])) {
            self::$totalWithdrawalsThisWeek[$userInteractions['userId']] = [];
        }

        // Check if interactions happens not for the first time
        if (!empty(self::$withdrawalsThisWeek[$userInteractions['userId']])) {
            $lastInteraction = end(self::$withdrawalsThisWeek[$userInteractions['userId']]);

            // If interaction happens in same week
            if (Carbon::parse($lastInteraction)->between($startDate, $endDate) &&
                Carbon::parse($userInteractions['operationDate'])->between(
                    $startDate,
                    $endDate
                )) {
                self::$withdrawalsThisWeek[$userInteractions['userId']][] = $userInteractions['operationDate'];
                self::$totalWithdrawalsThisWeek[$userInteractions['userId']][] = $userInteractions['amount'];

                $totalWithdrawalsThisWeek = array_sum(self::$totalWithdrawalsThisWeek[$userInteractions['userId']]);

                if ($totalWithdrawalsThisWeek > 1000) {
                    $exceededAmount = $totalWithdrawalsThisWeek - 1000;
                    $fee = $exceededAmount * (0.3 / 100);
                    return number_format((float)$fee, 2, '.', '');
                }

                // If withdrawal is in the free range
                if (count(self::$withdrawalsThisWeek[$userInteractions['userId']]) <= 3) {
                    return number_format(0.0, 2, '.', '');
                } elseif (count(self::$withdrawalsThisWeek[$userInteractions['userId']]) > 3) {
                    $fee = $userInteractions['amount'] * (0.3 / 100);
                    return number_format((float)$fee, 2, '.', '');

                }

                return number_format(0.0, 2, '.', '');
            } // If interaction happens in different week
            else {
                self::$withdrawalsThisWeek[$userInteractions['userId']] = [];
                self::$totalWithdrawalsThisWeek[$userInteractions['userId']] = [];

                if ($userInteractions['amount'] > 1000) {
                    $exceededAmount = $userInteractions['amount'] - 1000;
                    return $exceededAmount * (0.3 / 100);
                } else {
                    return number_format(0.0, 2, '.', '');
                }
            }
        } // If interaction happens for the first time
        else {
            self::$withdrawalsThisWeek[$userInteractions['userId']][] = $userInteractions['operationDate'];
            self::$totalWithdrawalsThisWeek[$userInteractions['userId']][] = $userInteractions['amount'];

            if ($userInteractions['amount'] > 1000) {
                $exceededAmount = $userInteractions['amount'] - 1000;
                $fee = $exceededAmount * (0.3 / 100);
                return number_format((float)$fee, 2, '.', '');
            }
            return number_format(0.0, 2, '.', '');
        }
    }
}
