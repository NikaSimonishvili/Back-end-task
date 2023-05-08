<?php

namespace App\services;

use App\Actions\SetCurrenciesAction;

class TransactionsService
{
    public function handle($fileName): array
    {
        $results = [];
        SetCurrenciesAction::handle();

        $file = fopen(storage_path('app/public/'.$fileName.'.csv'), 'r');

        if ($file) {
            $users = [];

            while (($data = fgetcsv($file, 0, ',')) !== false) {
                $this->saveUsersDataInArray($users, $data);
                $results[] = CommissionFeeFactory::getOperationType(end($users[$data[1]]));
            }

            fclose($file);
        }

        return $results;
    }

    private function saveUsersDataInArray(array &$users, array $data): void
    {
        $users[$data[1]][] = [
            'userId' => $data[1],
            'operationDate' => $data[0],
            'userType' => $data[2],
            'operationType' => $data[3],
            'amount' => $data[4],
            'operationCurrency' => $data[5],
        ];
    }
}
