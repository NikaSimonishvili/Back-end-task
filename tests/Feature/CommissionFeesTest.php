<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommissionFeesTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_commission_fees_success(): void
    {
        $this->artisan('commission-fee:import', ['fileName' => 'commission-fees'])
            ->assertSuccessful();
    }
}
