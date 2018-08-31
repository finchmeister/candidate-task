<?php


namespace App\Transaction;

interface CurrencyConverterInterface
{
    /**
     * @param Transaction $transactions
     * @return Transaction
     */
    public function convertTransactionToGBP(Transaction $transactions): Transaction;

    /**
     * @param Transaction[] $transactions
     * @return Transaction[]
     */
    public function convertTransactionsToGBP(array $transactions): array;

}
