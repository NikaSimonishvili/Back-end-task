<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Actions\ExchangeCurrency;
use App\Actions\SetCurrenciesAction;
use App\services\Deposits\Deposit;
use App\services\Withdrawals\BusinessClientWithdrawal;
use Tests\TestCase;

class CommissionFeesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        SetCurrenciesAction::handle();
    }

    /**
     * A basic test example.
     */
    public function test_commission_fees_success(): void
    {
        $this->artisan('commission-fee:import', ['fileName' => 'commission-fees'])
            ->assertSuccessful();
    }

    public function test_exchange_currencies_to_euro_successful()
    {

        $USDToEUR = (new ExchangeCurrency())->handle(20, 'USD', 'EUR');
        $JPYoEUR = (new ExchangeCurrency())->handle(20, 'JPY', 'EUR');

        $this->assertEquals(17.71, $USDToEUR);
        $this->assertEquals(0.15, $JPYoEUR);
    }

    public function test_business_client_withdrawal_charges_correctly()
    {
        $result = BusinessClientWithdrawal::handleWithdraw(['amount' => 1000]);

        $this->assertEquals(5.00, $result);
    }

    public function test_deposit_charges_correctly()
    {
        $result = Deposit::handleDeposit(['amount' => 1000]);

        $this->assertEquals(0.30, $result);
    }
}
