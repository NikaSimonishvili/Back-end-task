<?php

namespace App\Console\Commands;

use App\Actions\SetCurrenciesAction;
use App\services\CommissionFeeFactory;
use Illuminate\Console\Command;

class CommissionFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commission-fee:import {fileName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import csv file and calculate commission fees.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $results = [];

        SetCurrenciesAction::handle();

        $file = fopen(storage_path('app/public/' . $this->argument('fileName') . '.csv'), 'r');

        if ($file) {
            $users = [];
            while (($data = fgetcsv($file, 0, ',')) !== false) {
                $this->saveUsersDataInArray($users, $data);

                $provider = CommissionFeeFactory::getOperationType($users GAFILTRULI, USERIS AIDIT)
            }
            dd($users);

            fclose($file);
        }
    }

    private function saveUsersDataInArray(array &$users, array $data)
    {
        $users[$data[1]][] = [
            'operationDate' => $data[0],
            'userType' => $data[2],
            'operationType' => $data[3],
            'amount' => $data[4],
            'operationCurrency' => $data[5],
        ];
    }
}
