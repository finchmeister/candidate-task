<?php


namespace App\Transaction;

interface CurrencyExchangeRateInterface
{

    public function getExchangeRateToGBP(string $currency): float;

}
