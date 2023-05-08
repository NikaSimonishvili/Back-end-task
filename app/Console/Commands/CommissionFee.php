<?php

namespace App\Console\Commands;

use App\services\TransactionsService;
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
    public function handle(TransactionsService $service)
    {
        $results = $service->handle($this->argument('fileName'));

        foreach ($results as $result) {
            $this->info($result);
        }
    }
}
