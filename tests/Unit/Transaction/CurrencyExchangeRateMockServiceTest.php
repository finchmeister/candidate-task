<?php

namespace App\Tests\Unit\Transaction;

use App\Transaction\CurrencyExchangeRateMockService;
use PHPUnit\Framework\TestCase;

class CurrencyExchangeRateMockServiceTest extends TestCase
{

    /**
     * @dataProvider dataProviderGetExchangeRateToGBP
     * @param float $expectedExchangeRate
     * @param string $currency
     */
    public function testGetExchangeRateToGBP(
        float $expectedExchangeRate,
        string $currency
    ): void {
        $currencyService = new CurrencyExchangeRateMockService();
        $this->assertSame(
            $expectedExchangeRate,
            $currencyService->getExchangeRateToGBP($currency)
        );
    }

    public function dataProviderGetExchangeRateToGBP(): array
    {
        return [
            [1, 'GBP'],
            [0.77, 'USD'],
            [0.9, 'EUR'],
        ];
    }
}
