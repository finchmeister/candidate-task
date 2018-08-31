<?php


namespace App\Transaction;

class CurrencyExchangeRateMockService implements CurrencyExchangeRateInterface
{
    public const EXCHANGE_RATES = [
        'GBP' => 1,
        'USD' => 0.77,
        'EUR' => 0.9,
    ];

    public function getExchangeRateToGBP(string $currency): float
    {
        return self::EXCHANGE_RATES[$currency];
    }

}