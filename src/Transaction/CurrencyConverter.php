<?php


namespace App\Transaction;

class CurrencyConverter implements CurrencyConverterInterface
{
    /**
     * @var CurrencyExchangeRateInterface
     */
    private $currencyExchangeRate;

    public function __construct(
        CurrencyExchangeRateInterface $currencyExchangeRate
    ) {
        $this->currencyExchangeRate = $currencyExchangeRate;
    }

    /**
     * @param Transaction $transaction
     * @return Transaction
     */
    public function convertTransactionToGBP(Transaction $transaction): Transaction
    {
        $currency = $transaction->getCurrency();
        $exchangeRate = $this->currencyExchangeRate->getExchangeRateToGBP($currency);
        $transaction->setAmount(self::convert($transaction->getAmount(), $exchangeRate));
        $transaction->setCurrency('GBP');
        return $transaction;
    }

    /**
     * @param Transaction[] $transactions
     * @return Transaction[]
     */
    public function convertTransactionsToGBP(array $transactions): array
    {
        /** @var Transaction[] $merchantTransactionsInGBP */
        $merchantTransactionsInGBP = array_map(
            [$this, 'convertTransactionToGBP'],
            $transactions
        );
        return $merchantTransactionsInGBP;
    }

    public static function convert(float $amount, float $exchangeRate)
    {
        return round($amount / $exchangeRate, 2);
    }

}